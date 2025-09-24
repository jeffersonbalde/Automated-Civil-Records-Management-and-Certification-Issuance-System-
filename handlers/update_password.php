<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['status' => '', 'message' => ''];

    try {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            $response['status'] = 'error';
            $response['message'] = 'New passwords do not match';
            echo json_encode($response);
            exit();
        }

        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (password_verify($current_password, $user['password'])) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");

            if ($stmt->execute([$new_hash, $_SESSION['user_id']])) {
                $response['status'] = 'success';
                $response['message'] = 'Password updated successfully';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Current password is incorrect';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit();
}
