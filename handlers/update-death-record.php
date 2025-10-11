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
    
    if (!$input) {
        throw new Exception('No data received');
    }

    if ($input['action'] !== 'update_death_record') {
        throw new Exception('Invalid action');
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Validate death ID
    if (!isset($input['death_id']) || empty($input['death_id'])) {
        throw new Exception('Invalid death record ID');
    }

    $deathId = $input['death_id'];

    // Start transaction
    $pdo->beginTransaction();

    // Update death_records table
    $deathSql = "UPDATE death_records SET 
        first_name = ?, middle_name = ?, last_name = ?,
        sex = ?, date_of_death = ?, date_of_birth = ?,
        place_of_death = ?, civil_status = ?, religion = ?,
        citizenship = ?, residence = ?, occupation = ?,
        father_name = ?, mother_maiden_name = ?,
        immediate_cause = ?, antecedent_cause = ?, underlying_cause = ?,
        other_significant_conditions = ?, maternal_condition = ?,
        manner_of_death = ?, place_of_occurrence = ?, autopsy = ?,
        attendant = ?, attendant_other = ?, attended_from = ?, attended_to = ?,
        certifier_signature = ?, certifier_name = ?, certifier_title = ?,
        certifier_address = ?, certifier_date = ?, attended_deceased = ?,
        death_occurred_time = ?, corpse_disposal = ?, burial_permit_number = ?,
        burial_permit_date = ?, transfer_permit_number = ?, transfer_permit_date = ?,
        cemetery_name = ?, cemetery_address = ?, informant_signature = ?,
        informant_name = ?, informant_relationship = ?, informant_address = ?,
        informant_date = ?, prepared_by_signature = ?, prepared_by_name = ?,
        prepared_by_title = ?, prepared_by_date = ?
    WHERE death_id = ?";

    $deathStmt = $pdo->prepare($deathSql);
    $deathStmt->execute([
        $input['first_name'] ?? '',
        $input['middle_name'] ?? '',
        $input['last_name'] ?? '',
        $input['sex'] ?? '',
        $input['date_of_death'] ?? null,
        $input['date_of_birth'] ?? null,
        $input['place_of_death'] ?? '',
        $input['civil_status'] ?? '',
        $input['religion'] ?? '',
        $input['citizenship'] ?? '',
        $input['residence'] ?? '',
        $input['occupation'] ?? '',
        $input['father_name'] ?? '',
        $input['mother_maiden_name'] ?? '',
        $input['immediate_cause'] ?? '',
        $input['antecedent_cause'] ?? '',
        $input['underlying_cause'] ?? '',
        $input['other_significant_conditions'] ?? '',
        $input['maternal_condition'] ?? '',
        $input['manner_of_death'] ?? '',
        $input['place_of_occurrence'] ?? '',
        $input['autopsy'] ?? '',
        $input['attendant'] ?? '',
        $input['attendant_other'] ?? '',
        $input['attended_from'] ?? null,
        $input['attended_to'] ?? null,
        $input['certifier_signature'] ?? '',
        $input['certifier_name'] ?? '',
        $input['certifier_title'] ?? '',
        $input['certifier_address'] ?? '',
        $input['certifier_date'] ?? null,
        $input['attended_deceased'] ?? '',
        $input['death_occurred_time'] ?? '',
        $input['corpse_disposal'] ?? '',
        $input['burial_permit_number'] ?? '',
        $input['burial_permit_date'] ?? null,
        $input['transfer_permit_number'] ?? '',
        $input['transfer_permit_date'] ?? null,
        $input['cemetery_name'] ?? '',
        $input['cemetery_address'] ?? '',
        $input['informant_signature'] ?? '',
        $input['informant_name'] ?? '',
        $input['informant_relationship'] ?? '',
        $input['informant_address'] ?? '',
        $input['informant_date'] ?? null,
        $input['prepared_by_signature'] ?? '',
        $input['prepared_by_name'] ?? '',
        $input['prepared_by_title'] ?? '',
        $input['prepared_by_date'] ?? null,
        $deathId
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Death record updated successfully!',
        'death_id' => $deathId
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Death record update error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error updating death record: ' . $e->getMessage()
    ]);
}
?>