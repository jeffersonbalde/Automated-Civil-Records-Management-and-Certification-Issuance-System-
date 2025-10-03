<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Include the same duplicate checking functions from save-marriage-record.php
function checkForMarriageDuplicate($pdo, $input, $excludeId = null) {
    // Same function as in save-marriage-record.php
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

function findSimilarMarriageRecords($pdo, $input, $excludeId = null) {
    // Same function as in save-marriage-record.php
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

try {
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('No data received');
    }

    // Handle similar records check for edit mode
    if ($input['action'] === 'find_similar') {
        $excludeId = $input['marriage_id'] ?? null;
        $similarRecords = findSimilarMarriageRecords($pdo, $input, $excludeId);

        echo json_encode([
            'similar_records' => $similarRecords
        ]);
        exit;
    }

    if ($input['action'] !== 'update_marriage_record') {
        throw new Exception('Invalid action');
    }

    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    $marriageId = $input['marriage_id'] ?? null;
    if (!$marriageId) {
        throw new Exception('Marriage ID is required for update');
    }

    // Check for duplicates (excluding current record)
    if (checkForMarriageDuplicate($pdo, $input, $marriageId)) {
        echo json_encode([
            'success' => false,
            'message' => 'Duplicate record found. Another marriage record with the same couple and date already exists.',
            'is_duplicate' => true
        ]);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Update marriage record
    $updateSql = "UPDATE marriage_records SET
        province = ?, city_municipality = ?, date_of_marriage = ?, time_of_marriage = ?,
        place_of_marriage = ?, marriage_type = ?, license_number = ?, license_date = ?, license_place = ?,
        property_regime = ?,
        
        husband_first_name = ?, husband_middle_name = ?, husband_last_name = ?, husband_birthdate = ?,
        husband_birthplace = ?, husband_sex = ?, husband_citizenship = ?, husband_religion = ?,
        husband_civil_status = ?, husband_occupation = ?, husband_address = ?,
        
        husband_father_name = ?, husband_father_citizenship = ?, husband_mother_name = ?, husband_mother_citizenship = ?,
        
        husband_consent_giver = ?, husband_consent_relationship = ?, husband_consent_address = ?,
        
        wife_first_name = ?, wife_middle_name = ?, wife_last_name = ?, wife_birthdate = ?,
        wife_birthplace = ?, wife_sex = ?, wife_citizenship = ?, wife_religion = ?,
        wife_civil_status = ?, wife_occupation = ?, wife_address = ?,
        
        wife_father_name = ?, wife_father_citizenship = ?, wife_mother_name = ?, wife_mother_citizenship = ?,
        
        wife_consent_giver = ?, wife_consent_relationship = ?, wife_consent_address = ?,
        
        officiating_officer = ?, officiant_title = ?, officiant_license = ?,
        
        legal_basis = ?, legal_basis_article = ?,
        
        witness1_name = ?, witness1_address = ?, witness1_relationship = ?,
        witness2_name = ?, witness2_address = ?, witness2_relationship = ?,
        
        marriage_remarks = ?
        
        WHERE marriage_id = ?";

    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([
        // Basic Information
        $input['province'] ?? '',
        $input['city_municipality'] ?? '',
        $input['date_of_marriage'] ?? '',
        $input['time_of_marriage'] ?? '',
        $input['place_of_marriage'] ?? '',
        $input['marriage_type'] ?? '',
        $input['license_number'] ?? '',
        $input['license_date'] ?? '',
        $input['license_place'] ?? '',
        $input['property_regime'] ?? '',
        
        // Husband Information
        $input['husband_first_name'] ?? '',
        $input['husband_middle_name'] ?? '',
        $input['husband_last_name'] ?? '',
        $input['husband_birthdate'] ?? '',
        $input['husband_birthplace'] ?? '',
        $input['husband_sex'] ?? '',
        $input['husband_citizenship'] ?? '',
        $input['husband_religion'] ?? '',
        $input['husband_civil_status'] ?? '',
        $input['husband_occupation'] ?? '',
        $input['husband_address'] ?? '',
        
        // Husband Parents
        $input['husband_father_name'] ?? '',
        $input['husband_father_citizenship'] ?? '',
        $input['husband_mother_name'] ?? '',
        $input['husband_mother_citizenship'] ?? '',
        
        // Husband Consent
        $input['husband_consent_giver'] ?? '',
        $input['husband_consent_relationship'] ?? '',
        $input['husband_consent_address'] ?? '',
        
        // Wife Information
        $input['wife_first_name'] ?? '',
        $input['wife_middle_name'] ?? '',
        $input['wife_last_name'] ?? '',
        $input['wife_birthdate'] ?? '',
        $input['wife_birthplace'] ?? '',
        $input['wife_sex'] ?? '',
        $input['wife_citizenship'] ?? '',
        $input['wife_religion'] ?? '',
        $input['wife_civil_status'] ?? '',
        $input['wife_occupation'] ?? '',
        $input['wife_address'] ?? '',
        
        // Wife Parents
        $input['wife_father_name'] ?? '',
        $input['wife_father_citizenship'] ?? '',
        $input['wife_mother_name'] ?? '',
        $input['wife_mother_citizenship'] ?? '',
        
        // Wife Consent
        $input['wife_consent_giver'] ?? '',
        $input['wife_consent_relationship'] ?? '',
        $input['wife_consent_address'] ?? '',
        
        // Ceremony Details
        $input['officiating_officer'] ?? '',
        $input['officiant_title'] ?? '',
        $input['officiant_license'] ?? '',
        
        // Legal Basis
        $input['legal_basis'] ?? '',
        $input['legal_basis_article'] ?? '',
        
        // Witnesses
        $input['witness1_name'] ?? '',
        $input['witness1_address'] ?? '',
        $input['witness1_relationship'] ?? '',
        $input['witness2_name'] ?? '',
        $input['witness2_address'] ?? '',
        $input['witness2_relationship'] ?? '',
        
        // Additional
        $input['marriage_remarks'] ?? '',
        
        // Where condition
        $marriageId
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Marriage record updated successfully!',
        'marriage_id' => $marriageId
    ]);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Marriage record update error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error updating marriage record: ' . $e->getMessage()
    ]);
}
?>