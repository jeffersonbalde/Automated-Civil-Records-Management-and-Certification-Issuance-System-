<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
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

    if ($input['action'] !== 'delete_death_record') {
        throw new Exception('Invalid action');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    $death_id = $input['death_id'] ?? null;

    if (!$death_id) {
        throw new Exception('Death record ID is required');
    }

    // Start transaction
    $pdo->beginTransaction();

    // Delete death record
    $deleteSql = "DELETE FROM death_records WHERE death_id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->execute([$death_id]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Death record deleted successfully!'
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Delete death record error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error deleting death record: ' . $e->getMessage()
    ]);
}
?>