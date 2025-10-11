<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Function to check for duplicate death records
function checkForDeathDuplicate($pdo, $input, $excludeId = null)
{
    $firstName = $input['first_name'] ?? '';
    $lastName = $input['last_name'] ?? '';
    $dateOfDeath = $input['date_of_death'] ?? '';
    $dateOfBirth = $input['date_of_birth'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($dateOfDeath) || empty($dateOfBirth)) {
        return false;
    }

    $sql = "SELECT COUNT(*) as duplicate_count FROM death_records 
            WHERE first_name = ? AND last_name = ? 
            AND date_of_death = ? AND date_of_birth = ?";
    $params = [$firstName, $lastName, $dateOfDeath, $dateOfBirth];

    if ($excludeId) {
        $sql .= " AND death_id != ?";
        $params[] = $excludeId;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['duplicate_count'] > 0;
}

// Function to find similar death records
function findSimilarDeathRecords($pdo, $input, $excludeId = null)
{
    $firstName = $input['first_name'] ?? '';
    $lastName = $input['last_name'] ?? '';
    $dateOfDeath = $input['date_of_death'] ?? '';
    $dateOfBirth = $input['date_of_birth'] ?? '';

    $similarRecords = [];

    if (!empty($firstName) && !empty($lastName)) {
        $sql = "SELECT dr.death_id, dr.registry_number, 
                       dr.first_name, dr.middle_name, dr.last_name,
                       dr.date_of_death, dr.date_of_birth, dr.sex,
                       dr.place_of_death, dr.date_registered
                FROM death_records dr
                WHERE (dr.first_name LIKE ? OR dr.last_name LIKE ? 
                       OR (dr.first_name LIKE ? AND dr.last_name LIKE ?)
                       OR dr.date_of_birth = ? OR dr.date_of_death = ?)";

        $params = [
            "%$firstName%",
            "%$lastName%",
            "%$firstName%",
            "%$lastName%",
            $dateOfBirth,
            $dateOfDeath
        ];

        if ($excludeId) {
            $sql .= " AND dr.death_id != ?";
            $params[] = $excludeId;
        }

        $sql .= " ORDER BY dr.date_registered DESC LIMIT 5";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $similarRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $similarRecords;
}

function generateDeathRegistryNumber($pdo)
{
    $year = date('Y');

    // Get the highest sequence number for the current year
    $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(registry_number, '-', -1) AS UNSIGNED)) as max_sequence 
            FROM death_records 
            WHERE registry_number LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["DR-$year-%"]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $sequence = ($result['max_sequence'] ?? 0) + 1;

    // If no records found for this year, start from 1
    if ($sequence === 1) {
        // Double check if there are really no records for this year
        $checkSql = "SELECT COUNT(*) as count FROM death_records WHERE YEAR(date_registered) = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$year]);
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($checkResult['count'] > 0) {
            // If there are records but our sequence detection failed, use count + 1
            $sequence = $checkResult['count'] + 1;
        }
    }

    return "DR-" . $year . "-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
}

try {
    // Initialize database connection
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('No data received');
    }

    // Handle duplicate check request
    if ($input['action'] === 'check_duplicate') {
        $isDuplicate = checkForDeathDuplicate($pdo, $input);
        $similarRecords = findSimilarDeathRecords($pdo, $input);

        echo json_encode([
            'is_duplicate' => $isDuplicate,
            'similar_records' => $similarRecords,
            'checked_fields' => [
                'first_name' => $input['first_name'] ?? '',
                'last_name' => $input['last_name'] ?? '',
                'date_of_death' => $input['date_of_death'] ?? '',
                'date_of_birth' => $input['date_of_birth'] ?? ''
            ]
        ]);
        exit;
    }

    // Handle similar records check request
    if ($input['action'] === 'find_similar') {
        $similarRecords = findSimilarDeathRecords($pdo, $input);

        echo json_encode([
            'similar_records' => $similarRecords
        ]);
        exit;
    }

    if ($input['action'] !== 'save_death_record') {
        throw new Exception('Invalid action');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Check for duplicates before saving
    if (checkForDeathDuplicate($pdo, $input)) {
        echo json_encode([
            'success' => false,
            'message' => 'Duplicate record found. A death record with the same name and dates already exists.',
            'is_duplicate' => true
        ]);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Generate registry number (AUTO-GENERATED, not from form)
    $registry_number = generateDeathRegistryNumber($pdo);

    // Insert into death_records
    // Insert into death_records - REMOVE death_id and date_registered since they're auto/default
    $deathSql = "INSERT INTO death_records (
    registry_number, province, city_municipality,
    first_name, middle_name, last_name, sex, date_of_death, date_of_birth,
    age_years, age_months, age_days, age_hours, age_minutes,
    place_of_death, civil_status, religion, citizenship, residence, occupation,
    father_name, mother_maiden_name,
    immediate_cause, antecedent_cause, underlying_cause, other_significant_conditions,
    maternal_condition, manner_of_death, place_of_occurrence, autopsy,
    attendant, attendant_other, attended_from, attended_to,
    certifier_signature, certifier_name, certifier_title, certifier_address, certifier_date,
    attended_deceased, death_occurred_time,
    corpse_disposal, burial_permit_number, burial_permit_date,
    transfer_permit_number, transfer_permit_date,
    cemetery_name, cemetery_address,
    informant_signature, informant_name, informant_relationship, informant_address, informant_date,
    prepared_by_signature, prepared_by_name, prepared_by_title, prepared_by_date,
    encoded_by
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

    $deathStmt = $pdo->prepare($deathSql);

    // Calculate age if not provided
    $age_years = $input['age_years'] ?? null;
    if (empty($age_years) && !empty($input['date_of_birth']) && !empty($input['date_of_death'])) {
        // Calculate age from dates
        $birthDate = new DateTime($input['date_of_birth']);
        $deathDate = new DateTime($input['date_of_death']);
        $ageInterval = $deathDate->diff($birthDate);
        $age_years = $ageInterval->y;
    }

    // Ensure age_years is properly handled
    if ($age_years === '' || $age_years === null) {
        $age_years = null;
    } else {
        $age_years = (int)$age_years;
    }

    // Execute with proper NULL handling for optional fields
    $deathStmt->execute([
        // Registry and Location (3 params)
        $registry_number,
        $input['province'] ?? '',
        $input['city_municipality'] ?? '',

        // Personal Information (6 params)
        $input['first_name'] ?? '',
        $input['middle_name'] ?? '',
        $input['last_name'] ?? '',
        $input['sex'] ?? '',
        $input['date_of_death'] ?? '',
        $input['date_of_birth'] ?? '',

        // Age Information (5 params)
        $age_years !== '' ? $age_years : null,
        !empty($input['age_months']) ? (int)$input['age_months'] : null,
        !empty($input['age_days']) ? (int)$input['age_days'] : null,
        !empty($input['age_hours']) ? (int)$input['age_hours'] : null,
        !empty($input['age_minutes']) ? (int)$input['age_minutes'] : null,

        // Location and Status (6 params)
        $input['place_of_death'] ?? '',
        $input['civil_status'] ?? '',
        $input['religion'] ?? null,
        $input['citizenship'] ?? '',
        $input['residence'] ?? '',
        $input['occupation'] ?? null,

        // Parents Information (2 params)
        $input['father_name'] ?? '',
        $input['mother_maiden_name'] ?? '',

        // Causes of Death (4 params)
        $input['immediate_cause'] ?? '',
        $input['antecedent_cause'] ?? null,
        $input['underlying_cause'] ?? null,
        $input['other_significant_conditions'] ?? null,

        // Medical Information (4 params)
        $input['maternal_condition'] ?? null,
        $input['manner_of_death'] ?? null,
        $input['place_of_occurrence'] ?? null,
        $input['autopsy'] ?? null,

        // Attendant Information (4 params)
        $input['attendant'] ?? '',
        $input['attendant_other'] ?? null,
        $input['attended_from'] ?? null,
        $input['attended_to'] ?? null,

        // Certifier Information (5 params)
        $input['certifier_signature'] ?? null,
        $input['certifier_name'] ?? '',
        $input['certifier_title'] ?? null,
        $input['certifier_address'] ?? null,
        $input['certifier_date'] ?? null,

        // Death Certification (2 params)
        $input['attended_deceased'] ?? null,
        $input['death_occurred_time'] ?? null,

        // Corpse Disposal (3 params)
        $input['corpse_disposal'] ?? null,
        $input['burial_permit_number'] ?? null,
        $input['burial_permit_date'] ?? null,

        // Transfer Permit (2 params)
        $input['transfer_permit_number'] ?? null,
        $input['transfer_permit_date'] ?? null,

        // Cemetery Information (2 params)
        $input['cemetery_name'] ?? null,
        $input['cemetery_address'] ?? null,

        // Informant Information (5 params)
        $input['informant_signature'] ?? null,
        $input['informant_name'] ?? '',
        $input['informant_relationship'] ?? '',
        $input['informant_address'] ?? null,
        $input['informant_date'] ?? null,

        // Prepared By Information (4 params)
        $input['prepared_by_signature'] ?? null,
        $input['prepared_by_name'] ?? null,
        $input['prepared_by_title'] ?? null,
        $input['prepared_by_date'] ?? null,

        // System (1 param)
        $_SESSION['user_id']
    ]);
    $deathId = $pdo->lastInsertId();

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Death record saved successfully!',
        'registry_number' => $registry_number,
        'death_id' => $deathId
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Death record save error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error saving death record: ' . $e->getMessage()
    ]);
}
