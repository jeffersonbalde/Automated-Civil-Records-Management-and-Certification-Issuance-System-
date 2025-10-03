<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Function to check for duplicate marriage records
function checkForMarriageDuplicate($pdo, $input, $excludeId = null)
{
    $husbandFirstName = $input['husband_first_name'] ?? '';
    $husbandLastName = $input['husband_last_name'] ?? '';
    $wifeFirstName = $input['wife_first_name'] ?? '';
    $wifeLastName = $input['wife_last_name'] ?? '';
    $marriageDate = $input['date_of_marriage'] ?? '';

    if (empty($husbandFirstName) || empty($husbandLastName) || empty($wifeFirstName) || empty($wifeLastName) || empty($marriageDate)) {
        return false;
    }

    $sql = "SELECT COUNT(*) as duplicate_count FROM marriage_records 
            WHERE husband_first_name = ? AND husband_last_name = ? 
            AND wife_first_name = ? AND wife_last_name = ? 
            AND date_of_marriage = ?";
    $params = [$husbandFirstName, $husbandLastName, $wifeFirstName, $wifeLastName, $marriageDate];

    if ($excludeId) {
        $sql .= " AND marriage_id != ?";
        $params[] = $excludeId;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['duplicate_count'] > 0;
}

// Function to find similar marriage records
function findSimilarMarriageRecords($pdo, $input, $excludeId = null)
{
    $husbandFirstName = $input['husband_first_name'] ?? '';
    $husbandLastName = $input['husband_last_name'] ?? '';
    $wifeFirstName = $input['wife_first_name'] ?? '';
    $wifeLastName = $input['wife_last_name'] ?? '';

    $similarRecords = [];

    if (!empty($husbandFirstName) && !empty($husbandLastName) && !empty($wifeFirstName) && !empty($wifeLastName)) {
        $sql = "SELECT mr.marriage_id, mr.registry_number, 
                       mr.husband_first_name, mr.husband_middle_name, mr.husband_last_name,
                       mr.wife_first_name, mr.wife_middle_name, mr.wife_last_name,
                       mr.date_of_marriage, mr.place_of_marriage, mr.date_registered
                FROM marriage_records mr
                WHERE (mr.husband_first_name LIKE ? OR mr.husband_last_name LIKE ? 
                       OR mr.wife_first_name LIKE ? OR mr.wife_last_name LIKE ?)";

        $params = ["%$husbandFirstName%", "%$husbandLastName%", "%$wifeFirstName%", "%$wifeLastName%"];

        if ($excludeId) {
            $sql .= " AND mr.marriage_id != ?";
            $params[] = $excludeId;
        }

        $sql .= " ORDER BY mr.date_registered DESC LIMIT 5";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $similarRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $similarRecords;
}

function generateMarriageRegistryNumber($pdo)
{
    $year = date('Y');

    // Get the highest sequence number for the current year
    $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(registry_number, '-', -1) AS UNSIGNED)) as max_sequence 
            FROM marriage_records 
            WHERE registry_number LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["MR-$year-%"]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $sequence = ($result['max_sequence'] ?? 0) + 1;

    // If no records found for this year, start from 1
    if ($sequence === 1) {
        // Double check if there are really no records for this year
        $checkSql = "SELECT COUNT(*) as count FROM marriage_records WHERE YEAR(date_registered) = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$year]);
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($checkResult['count'] > 0) {
            // If there are records but our sequence detection failed, use count + 1
            $sequence = $checkResult['count'] + 1;
        }
    }

    return "MR-" . $year . "-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
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
        $isDuplicate = checkForMarriageDuplicate($pdo, $input);
        $similarRecords = findSimilarMarriageRecords($pdo, $input);

        echo json_encode([
            'is_duplicate' => $isDuplicate,
            'similar_records' => $similarRecords,
            'checked_fields' => [
                'husband_first_name' => $input['husband_first_name'] ?? '',
                'husband_last_name' => $input['husband_last_name'] ?? '',
                'wife_first_name' => $input['wife_first_name'] ?? '',
                'wife_last_name' => $input['wife_last_name'] ?? '',
                'date_of_marriage' => $input['date_of_marriage'] ?? ''
            ]
        ]);
        exit;
    }

    // Handle similar records check request
    if ($input['action'] === 'find_similar') {
        $similarRecords = findSimilarMarriageRecords($pdo, $input);

        echo json_encode([
            'similar_records' => $similarRecords
        ]);
        exit;
    }

    if ($input['action'] !== 'save_marriage_record') {
        throw new Exception('Invalid action');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Check for duplicates before saving
    if (checkForMarriageDuplicate($pdo, $input)) {
        echo json_encode([
            'success' => false,
            'message' => 'Duplicate record found. A marriage record with the same couple and date already exists.',
            'is_duplicate' => true
        ]);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Generate registry number (AUTO-GENERATED, not from form)
    $registry_number = generateMarriageRegistryNumber($pdo);

    // Insert into marriage_records
    $marriageSql = "INSERT INTO marriage_records (
        registry_number, province, city_municipality, date_of_marriage, time_of_marriage,
        place_of_marriage, marriage_type, license_number, license_date, license_place,
        property_regime,
        
        -- Husband Information
        husband_first_name, husband_middle_name, husband_last_name, husband_birthdate,
        husband_birthplace, husband_sex, husband_citizenship, husband_religion,
        husband_civil_status, husband_occupation, husband_address,
        
        -- Husband Parents
        husband_father_name, husband_father_citizenship, husband_mother_name, husband_mother_citizenship,
        
        -- Husband Consent
        husband_consent_giver, husband_consent_relationship, husband_consent_address,
        
        -- Wife Information
        wife_first_name, wife_middle_name, wife_last_name, wife_birthdate,
        wife_birthplace, wife_sex, wife_citizenship, wife_religion,
        wife_civil_status, wife_occupation, wife_address,
        
        -- Wife Parents
        wife_father_name, wife_father_citizenship, wife_mother_name, wife_mother_citizenship,
        
        -- Wife Consent
        wife_consent_giver, wife_consent_relationship, wife_consent_address,
        
        -- Ceremony Details
        officiating_officer, officiant_title, officiant_license,
        
        -- Legal Basis
        legal_basis, legal_basis_article,
        
        -- Witnesses
        witness1_name, witness1_address, witness1_relationship,
        witness2_name, witness2_address, witness2_relationship,
        
        -- Additional
        marriage_remarks,
        
        -- System
        encoded_by
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?,
        ?
    )";

    $marriageStmt = $pdo->prepare($marriageSql);

    // Execute with proper NULL handling for optional fields
    $marriageStmt->execute([
        // Basic Information
        $registry_number,
        $input['province'] ?? '',
        $input['city_municipality'] ?? '',
        $input['date_of_marriage'] ?? '',
        $input['time_of_marriage'] ?? '', // No longer NULL
        $input['place_of_marriage'] ?? '',
        $input['marriage_type'] ?? '',
        $input['license_number'] ?? '', // No longer NULL
        $input['license_date'] ?? '', // No longer NULL
        $input['license_place'] ?? '', // No longer NULL
        $input['property_regime'] ?? '', // No longer NULL

        // Husband Information
        $input['husband_first_name'] ?? '',
        $input['husband_middle_name'] ?? '',
        $input['husband_last_name'] ?? '',
        $input['husband_birthdate'] ?? '',
        $input['husband_birthplace'] ?? '',
        $input['husband_sex'] ?? '',
        $input['husband_citizenship'] ?? '',
        $input['husband_religion'] ?? null,
        $input['husband_civil_status'] ?? '',
        $input['husband_occupation'] ?? null,
        $input['husband_address'] ?? '',

        // Husband Parents
        $input['husband_father_name'] ?? '',
        $input['husband_father_citizenship'] ?? '',
        $input['husband_mother_name'] ?? '',
        $input['husband_mother_citizenship'] ?? '',

        // Husband Consent
        $input['husband_consent_giver'] ?? null,
        $input['husband_consent_relationship'] ?? null,
        $input['husband_consent_address'] ?? null,

        // Wife Information
        $input['wife_first_name'] ?? '',
        $input['wife_middle_name'] ?? '',
        $input['wife_last_name'] ?? '',
        $input['wife_birthdate'] ?? '',
        $input['wife_birthplace'] ?? '',
        $input['wife_sex'] ?? '',
        $input['wife_citizenship'] ?? '',
        $input['wife_religion'] ?? null,
        $input['wife_civil_status'] ?? '',
        $input['wife_occupation'] ?? null,
        $input['wife_address'] ?? '',

        // Wife Parents
        $input['wife_father_name'] ?? '',
        $input['wife_father_citizenship'] ?? '',
        $input['wife_mother_name'] ?? '',
        $input['wife_mother_citizenship'] ?? '',

        // Wife Consent
        $input['wife_consent_giver'] ?? null,
        $input['wife_consent_relationship'] ?? null,
        $input['wife_consent_address'] ?? null,

        // Ceremony Details
        $input['officiating_officer'] ?? '',
        $input['officiant_title'] ?? null,
        $input['officiant_license'] ?? null,

        // Legal Basis
        $input['legal_basis'] ?? null,
        $input['legal_basis_article'] ?? null,

        // Witnesses
        $input['witness1_name'] ?? '',
        $input['witness1_address'] ?? '',
        $input['witness1_relationship'] ?? null,
        $input['witness2_name'] ?? '',
        $input['witness2_address'] ?? '',
        $input['witness2_relationship'] ?? null,

        // Additional
        $input['marriage_remarks'] ?? null,

        // System
        $_SESSION['user_id']
    ]);

    $marriageId = $pdo->lastInsertId();

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Marriage record saved successfully!',
        'registry_number' => $registry_number,
        'marriage_id' => $marriageId
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Marriage record save error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error saving marriage record: ' . $e->getMessage()
    ]);
}
