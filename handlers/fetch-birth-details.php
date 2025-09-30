<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Initialize database connection
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    // Get birth_id from request
    $birth_id = isset($_GET['birth_id']) ? intval($_GET['birth_id']) : 0;

    if ($birth_id <= 0) {
        throw new Exception('Invalid birth record ID');
    }

    // Fetch main birth record
    $birthSql = "SELECT * FROM birth_records WHERE birth_id = ?";
    $birthStmt = $pdo->prepare($birthSql);
    $birthStmt->execute([$birth_id]);
    $birthRecord = $birthStmt->fetch(PDO::FETCH_ASSOC);

    if (!$birthRecord) {
        throw new Exception('Birth record not found');
    }

    // Fetch mother's information
    $motherSql = "SELECT * FROM parents_information WHERE birth_id = ? AND parent_type = 'Mother'";
    $motherStmt = $pdo->prepare($motherSql);
    $motherStmt->execute([$birth_id]);
    $motherInfo = $motherStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch father's information
    $fatherSql = "SELECT * FROM parents_information WHERE birth_id = ? AND parent_type = 'Father'";
    $fatherStmt = $pdo->prepare($fatherSql);
    $fatherStmt->execute([$birth_id]);
    $fatherInfo = $fatherStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch marriage information
    $marriageSql = "SELECT * FROM parents_marriage WHERE birth_id = ?";
    $marriageStmt = $pdo->prepare($marriageSql);
    $marriageStmt->execute([$birth_id]);
    $marriageInfo = $marriageStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch attendant information
    $attendantSql = "SELECT * FROM birth_attendants WHERE birth_id = ?";
    $attendantStmt = $pdo->prepare($attendantSql);
    $attendantStmt->execute([$birth_id]);
    $attendantInfo = $attendantStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch informant information
    $informantSql = "SELECT * FROM informants WHERE birth_id = ?";
    $informantStmt = $pdo->prepare($informantSql);
    $informantStmt->execute([$birth_id]);
    $informantInfo = $informantStmt->fetch(PDO::FETCH_ASSOC);

    // Combine all data
    $recordDetails = [
        'birth_record' => $birthRecord,
        'mother_info' => $motherInfo ?: [],
        'father_info' => $fatherInfo ?: [],
        'marriage_info' => $marriageInfo ?: [],
        'attendant_info' => $attendantInfo ?: [],
        'informant_info' => $informantInfo ?: []
    ];

    echo json_encode([
        'success' => true,
        'data' => $recordDetails
    ]);

} catch (Exception $e) {
    error_log('Birth details fetch error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching birth record details: ' . $e->getMessage()
    ]);
}
?>