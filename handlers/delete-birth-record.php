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

    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || $input['action'] !== 'delete_birth_record') {
        throw new Exception('Invalid action or no data received');
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

    // Start transaction
    $pdo->beginTransaction();

    // Delete records in the correct order to maintain referential integrity
    $tables = [
        'parents_marriage',
        'birth_attendants', 
        'informants',
        'parents_information',
        'birth_records'
    ];

    foreach ($tables as $table) {
        $sql = "DELETE FROM $table WHERE birth_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$birthId]);
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Birth record deleted successfully!',
        'birth_id' => $birthId
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Birth record deletion error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting birth record: ' . $e->getMessage()
    ]);
}
?>