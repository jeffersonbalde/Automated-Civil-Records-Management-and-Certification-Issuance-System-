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

    $death_id = $_GET['death_id'] ?? null;

    if (!$death_id) {
        throw new Exception('Death record ID is required');
    }

    // Fetch death record details
    $sql = "SELECT * FROM death_records WHERE death_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$death_id]);
    $death_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$death_record) {
        throw new Exception('Death record not found');
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'death_record' => $death_record
        ]
    ]);
} catch (Exception $e) {
    error_log('Fetch death details error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Error fetching death record details: ' . $e->getMessage()
    ]);
}
?>