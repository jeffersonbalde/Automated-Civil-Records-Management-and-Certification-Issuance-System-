<?php
session_start();
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

try {
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception('Database connection failed');
    }

    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || $input['action'] !== 'delete_marriage_record') {
        throw new Exception('Invalid request');
    }

    $marriage_id = $input['marriage_id'] ?? null;

    if (!$marriage_id) {
        throw new Exception('Marriage ID is required');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Start transaction
    $pdo->beginTransaction();

    // Delete marriage record
    $deleteSql = "DELETE FROM marriage_records WHERE marriage_id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->execute([$marriage_id]);

    if ($deleteStmt->rowCount() === 0) {
        throw new Exception('Marriage record not found or already deleted');
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Marriage record deleted successfully'
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Delete marriage record error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error deleting marriage record: ' . $e->getMessage()
    ]);
}
?>