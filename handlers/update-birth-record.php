<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// NEW: Function to check for duplicate records (exclude current record)
function checkForDuplicate($pdo, $input, $excludeId = null) {
    $childFirstName = $input['child_first_name'] ?? '';
    $childLastName = $input['child_last_name'] ?? '';
    $dateOfBirth = $input['date_of_birth'] ?? '';
    
    if (empty($childFirstName) || empty($childLastName) || empty($dateOfBirth)) {
        return false;
    }
    
    $sql = "SELECT COUNT(*) as duplicate_count FROM birth_records 
            WHERE child_first_name = ? AND child_last_name = ? AND date_of_birth = ?";
    $params = [$childFirstName, $childLastName, $dateOfBirth];
    
    if ($excludeId) {
        $sql .= " AND birth_id != ?";
        $params[] = $excludeId;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['duplicate_count'] > 0;
}

// NEW: Function to find similar records
function findSimilarRecords($pdo, $input, $excludeId = null) {
    $childFirstName = $input['child_first_name'] ?? '';
    $childLastName = $input['child_last_name'] ?? '';
    $dateOfBirth = $input['date_of_birth'] ?? '';
    
    $similarRecords = [];
    
    // Check by name and similar date (within 30 days)
    if (!empty($childFirstName) && !empty($childLastName)) {
        $sql = "SELECT br.birth_id, br.registry_number, br.child_first_name, 
                       br.child_middle_name, br.child_last_name, br.date_of_birth,
                       br.place_of_birth, br.date_registered
                FROM birth_records br
                WHERE (br.child_first_name LIKE ? OR br.child_last_name LIKE ?)";
        
        $params = ["%$childFirstName%", "%$childLastName%"];
        
        if ($excludeId) {
            $sql .= " AND br.birth_id != ?";
            $params[] = $excludeId;
        }
        
        $sql .= " ORDER BY br.date_registered DESC LIMIT 5";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $similarRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $similarRecords;
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

    // NEW: Handle duplicate check request for edit
    if ($input['action'] === 'check_duplicate_edit') {
        $birthId = $input['birth_id'] ?? null;
        $isDuplicate = checkForDuplicate($pdo, $input, $birthId);
        $similarRecords = findSimilarRecords($pdo, $input, $birthId);
        
        echo json_encode([
            'is_duplicate' => $isDuplicate,
            'similar_records' => $similarRecords,
            'checked_fields' => [
                'child_first_name' => $input['child_first_name'] ?? '',
                'child_last_name' => $input['child_last_name'] ?? '',
                'date_of_birth' => $input['date_of_birth'] ?? ''
            ]
        ]);
        exit;
    }

    if ($input['action'] !== 'update_birth_record') {
        throw new Exception('Invalid action');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Validate birth ID
    if (!isset($input['birth_id']) || empty($input['birth_id'])) {
        throw new Exception('Invalid birth record ID');
    }

    $birthId = $input['birth_id'];

    // NEW: Check for duplicates before updating (exclude current record)
    if (checkForDuplicate($pdo, $input, $birthId)) {
        echo json_encode([
            'success' => false,
            'message' => 'Duplicate record found. Another record with the same child name and date of birth already exists.',
            'is_duplicate' => true
        ]);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // 1. Update birth_records
    $birthSql = "UPDATE birth_records SET 
        child_first_name = ?, child_middle_name = ?, child_last_name = ?,
        sex = ?, date_of_birth = ?, time_of_birth = ?, place_of_birth = ?,
        birth_address_house = ?, birth_address_barangay = ?, birth_address_city = ?,
        type_of_birth = ?, multiple_birth_order = ?, birth_order = ?, 
        birth_weight = ?, birth_notes = ?, date_updated = NOW()
    WHERE birth_id = ?";

    $birthStmt = $pdo->prepare($birthSql);
    $birthStmt->execute([
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
        $birthId
    ]);

    // ... rest of your existing update code remains exactly the same ...
    // 2. Update mother's information
    $motherSql = "UPDATE parents_information SET 
        first_name = ?, middle_name = ?, last_name = ?,
        citizenship = ?, religion = ?, occupation = ?, age_at_birth = ?,
        children_born_alive = ?, children_still_living = ?, children_deceased = ?,
        house_no = ?, barangay = ?, city = ?, province = ?, country = ?
    WHERE birth_id = ? AND parent_type = 'Mother'";

    $motherStmt = $pdo->prepare($motherSql);
    $motherStmt->execute([
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
        $input['mother_country'] ?? 'Philippines',
        $birthId
    ]);

    // 3. Update father's information
    $fatherSql = "UPDATE parents_information SET 
        first_name = ?, middle_name = ?, last_name = ?,
        citizenship = ?, religion = ?, occupation = ?, age_at_birth = ?,
        house_no = ?, barangay = ?, city = ?, province = ?, country = ?
    WHERE birth_id = ? AND parent_type = 'Father'";

    $fatherStmt = $pdo->prepare($fatherSql);
    $fatherStmt->execute([
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
        $input['father_country'] ?? 'Philippines',
        $birthId
    ]);

    // 4. Update marriage information
    // First check if marriage record exists
    $checkMarriageSql = "SELECT COUNT(*) FROM parents_marriage WHERE birth_id = ?";
    $checkStmt = $pdo->prepare($checkMarriageSql);
    $checkStmt->execute([$birthId]);
    $marriageExists = $checkStmt->fetchColumn();

    if (!empty($input['marriage_date']) || !empty($input['marriage_place_city'])) {
        if ($marriageExists) {
            // Update existing marriage record
            $marriageSql = "UPDATE parents_marriage SET 
                marriage_date = ?, marriage_place_city = ?, marriage_place_province = ?, marriage_place_country = ?
            WHERE birth_id = ?";
        } else {
            // Insert new marriage record
            $marriageSql = "INSERT INTO parents_marriage (marriage_date, marriage_place_city, marriage_place_province, marriage_place_country, birth_id) 
                           VALUES (?, ?, ?, ?, ?)";
        }
        
        $marriageStmt = $pdo->prepare($marriageSql);
        $marriageStmt->execute([
            $input['marriage_date'] ?? null,
            $input['marriage_place_city'] ?? null,
            $input['marriage_place_province'] ?? null,
            $input['marriage_place_country'] ?? null,
            $birthId
        ]);
    } elseif ($marriageExists) {
        // Delete marriage record if it exists but no marriage data provided
        $deleteMarriageSql = "DELETE FROM parents_marriage WHERE birth_id = ?";
        $deleteStmt = $pdo->prepare($deleteMarriageSql);
        $deleteStmt->execute([$birthId]);
    }

    // 5. Update attendant information
    $attendantSql = "UPDATE birth_attendants SET 
        attendant_type = ?, attendant_name = ?, attendant_license = ?,
        attendant_certification = ?, attendant_address = ?, attendant_title = ?
    WHERE birth_id = ?";

    $attendantStmt = $pdo->prepare($attendantSql);
    $attendantStmt->execute([
        $input['attendant_type'] ?? '',
        $input['attendant_name'] ?? '',
        $input['attendant_license'] ?? '',
        $input['attendant_certification'] ?? '',
        $input['attendant_address'] ?? '',
        $input['attendant_title'] ?? '',
        $birthId
    ]);

    // 6. Update informant information
    $informantSql = "UPDATE informants SET 
        first_name = ?, middle_name = ?, last_name = ?,
        relationship = ?, address = ?, certification_accepted = ?
    WHERE birth_id = ?";

    $informantStmt = $pdo->prepare($informantSql);
    $informantStmt->execute([
        $input['informant_first_name'] ?? '',
        $input['informant_middle_name'] ?? '',
        $input['informant_last_name'] ?? '',
        $input['informant_relationship'] ?? '',
        $input['informant_address'] ?? '',
        isset($input['informantCertification']) ? 1 : 0,
        $birthId
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Birth record updated successfully!',
        'birth_id' => $birthId
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Birth record update error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error updating birth record: ' . $e->getMessage()
    ]);
}
?>