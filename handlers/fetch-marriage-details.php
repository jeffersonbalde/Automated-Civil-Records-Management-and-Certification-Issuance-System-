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

    $marriage_id = $_GET['marriage_id'] ?? null;

    if (!$marriage_id) {
        throw new Exception('Marriage ID is required');
    }

    // Fetch marriage record details
    $sql = "SELECT * FROM marriage_records WHERE marriage_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$marriage_id]);
    $marriage_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$marriage_record) {
        throw new Exception('Marriage record not found');
    }

    // Return all data in a structured format
    $response = [
        'success' => true,
        'data' => [
            'marriage_record' => $marriage_record,
            // You can add additional related data here if needed
        ]
    ];

    echo json_encode($response);
} catch (Exception $e) {
    error_log('Fetch marriage details error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error fetching marriage details: ' . $e->getMessage()
    ]);
}
?>