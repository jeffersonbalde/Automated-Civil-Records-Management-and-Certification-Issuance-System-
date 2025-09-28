<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Initialize database connection using your existing config
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || $input['action'] !== 'save_birth_record') {
        throw new Exception('Invalid action or no data received');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Start transaction
    $pdo->beginTransaction();

    // Generate registry number
    $registry_number = generateRegistryNumber($pdo);

    // 1. Insert into birth_records - CORRECTED COLUMN NAMES
    $birthSql = "INSERT INTO birth_records (
        registry_number, child_first_name, child_middle_name, child_last_name,
        sex, date_of_birth, time_of_birth, place_of_birth,
        birth_address_house, birth_address_barangay, birth_address_city,
        type_of_birth, multiple_birth_order, birth_order, birth_weight, birth_notes,
        date_registered, encoded_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    $birthStmt = $pdo->prepare($birthSql);
    $birthStmt->execute([
        $registry_number,
        $input['child_first_name'],
        $input['child_middle_name'] ?? '',
        $input['child_last_name'],
        $input['sex'],
        $input['date_of_birth'],
        $input['time_of_birth'] ?? '',
        $input['place_of_birth'] ?? '',
        $input['birth_address_house'] ?? '',
        $input['birth_address_barangay'] ?? '',
        $input['birth_address_city'] ?? '',
        $input['type_of_birth'] ?? '',
        $input['multiple_birth_order'] ?? '',
        $input['birth_order'] ?? '',
        $input['birth_weight'] ?? '',
        $input['birth_notes'] ?? '',
        $_SESSION['user_id'] // Use actual user ID from session
    ]);

    $birthId = $pdo->lastInsertId();

    // 2. Insert mother's information
    $motherSql = "INSERT INTO parents_information (
        birth_id, parent_type, first_name, middle_name, last_name,
        citizenship, religion, occupation, age_at_birth,
        children_born_alive, children_still_living, children_deceased,
        house_no, barangay, city, province, country
    ) VALUES (?, 'Mother', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $motherStmt = $pdo->prepare($motherSql);
    $motherStmt->execute([
        $birthId,
        $input['mother_first_name'] ?? '',
        $input['mother_middle_name'] ?? '',
        $input['mother_last_name'] ?? '',
        $input['mother_citizenship'] ?? '',
        $input['mother_religion'] ?? '',
        $input['mother_occupation'] ?? '',
        $input['mother_age_at_birth'] ?? '',
        $input['mother_children_born_alive'] ?? 0,
        $input['mother_children_still_living'] ?? 0,
        $input['mother_children_deceased'] ?? 0,
        $input['mother_house_no'] ?? '',
        $input['mother_barangay'] ?? '',
        $input['mother_city'] ?? '',
        $input['mother_province'] ?? '',
        $input['mother_country'] ?? 'Philippines'
    ]);

    // 3. Insert father's information
    $fatherSql = "INSERT INTO parents_information (
        birth_id, parent_type, first_name, middle_name, last_name,
        citizenship, religion, occupation, age_at_birth,
        house_no, barangay, city, province, country
    ) VALUES (?, 'Father', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $fatherStmt = $pdo->prepare($fatherSql);
    $fatherStmt->execute([
        $birthId,
        $input['father_first_name'] ?? '',
        $input['father_middle_name'] ?? '',
        $input['father_last_name'] ?? '',
        $input['father_citizenship'] ?? '',
        $input['father_religion'] ?? '',
        $input['father_occupation'] ?? '',
        $input['father_age_at_birth'] ?? '',
        $input['father_house_no'] ?? '',
        $input['father_barangay'] ?? '',
        $input['father_city'] ?? '',
        $input['father_province'] ?? '',
        $input['father_country'] ?? 'Philippines'
    ]);

    // 4. Insert marriage information if provided
    if (!empty($input['marriage_date']) || !empty($input['marriage_place_city'])) {
        $marriageSql = "INSERT INTO parents_marriage (
            birth_id, marriage_date, marriage_place_city, marriage_place_province, marriage_place_country
        ) VALUES (?, ?, ?, ?, ?)";

        $marriageStmt = $pdo->prepare($marriageSql);
        $marriageStmt->execute([
            $birthId,
            $input['marriage_date'] ?? null,
            $input['marriage_place_city'] ?? null,
            $input['marriage_place_province'] ?? null,
            $input['marriage_place_country'] ?? null
        ]);
    }

    // 5. Insert attendant information
    $attendantSql = "INSERT INTO birth_attendants (
        birth_id, attendant_type, attendant_name, attendant_license,
        attendant_certification, attendant_address, attendant_title
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $attendantStmt = $pdo->prepare($attendantSql);
    $attendantStmt->execute([
        $birthId,
        $input['attendant_type'] ?? '',
        $input['attendant_name'] ?? '',
        $input['attendant_license'] ?? '',
        $input['attendant_certification'] ?? '',
        $input['attendant_address'] ?? '',
        $input['attendant_title'] ?? ''
    ]);

    // 6. Insert informant information
    $informantSql = "INSERT INTO informants (
        birth_id, first_name, middle_name, last_name,
        relationship, address, certification_accepted
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $informantStmt = $pdo->prepare($informantSql);
    $informantStmt->execute([
        $birthId,
        $input['informant_first_name'] ?? '',
        $input['informant_middle_name'] ?? '',
        $input['informant_last_name'] ?? '',
        $input['informant_relationship'] ?? '',
        $input['informant_address'] ?? '',
        isset($input['informantCertification']) ? 1 : 0
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Birth record saved successfully!',
        'registry_number' => $registry_number,
        'birth_id' => $birthId
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Birth record save error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error saving birth record: ' . $e->getMessage()
    ]);
}

function generateRegistryNumber($pdo) {
    $year = date('Y');
    $sql = "SELECT COUNT(*) as count FROM birth_records WHERE YEAR(date_registered) = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$year]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sequence = $result['count'] + 1;
    return "BR-" . $year . "-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
}
?>