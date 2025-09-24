<?php
require_once '../config/database.php';

try {
    // Use the existing database connection from Database class
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        // Check if admin already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = 'admin'");
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // Create default admin account
            $username = 'admin';
            $password = '123';
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'admin';
            $full_name = 'System Administrator';

            // Changed password_hash to password in column name
            $stmt = $conn->prepare("INSERT INTO users (username, password, role, full_name, is_active) 
                                   VALUES (?, ?, ?, ?, 1)");

            if ($stmt->execute([$username, $password_hash, $role, $full_name])) {
                echo "Default admin account created successfully!<br>";
                echo "Username: admin<br>";
                echo "Password: 123<br>";
            } else {
                echo "Error creating admin account";
            }
        } else {
            echo "Admin account already exists!";
        }
    } else {
        echo "Database connection failed";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
