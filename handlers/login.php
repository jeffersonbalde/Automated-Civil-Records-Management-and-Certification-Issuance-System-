<?php
session_start();
require_once '../config/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$conn = $database->getConnection();

// Test database connection more thoroughly
if (!$conn) {
    error_log("Database connection failed");
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

try {
    // Test query to verify database access
    $testStmt = $conn->query("SELECT 1");
    error_log("Database connection test successful");
} catch (PDOException $e) {
    error_log("Database test query failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['status' => '', 'message' => ''];

    try {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        error_log("Login attempt for username: " . $username);

        // Updated query to match table structure
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            error_log("User found: " . $user['username']);
            
            // Debug: Log password verification
            error_log("Input password: " . $password);
            error_log("Stored hash: " . $user['password']);
            error_log("Password verify result: " . (password_verify($password, $user['password']) ? 'true' : 'false'));

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
                error_log("Login successful for user: " . $username);
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid password';
                error_log("Invalid password for user: " . $username);
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'User not found or inactive';
            error_log("User not found or inactive: " . $username);
        }
    } catch (PDOException $e) {
        error_log("Login PDOException: " . $e->getMessage());
        $response['status'] = 'error';
        $response['message'] = 'Login error: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}