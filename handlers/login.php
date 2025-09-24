<?php
session_start();
require_once '../config/database.php';

$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die("Database connection failed. Please check your .env or config.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['status' => '', 'message' => ''];

    try {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Updated query to match table structure
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Changed from password_hash to password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id']; // Changed from id to user_id
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['profile_img'] = isset($user['profile_img']) ? $user['profile_img'] : null;

                if (isset($_POST['remember'])) {
                    setcookie('remember_user', $user['username'], time() + (86400 * 30), "/");
                }

                $response['status'] = 'success';
                $response['message'] = 'Welcome back, ' . $user['full_name'] . '!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid password';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'User not found or inactive';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Login error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit();
}
