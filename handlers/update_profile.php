<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_img'])) {
    $response = ['status' => '', 'message' => ''];

    try {
        $file = $_FILES['profile_img'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // File validation
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if ($fileError === 0) {
            $fileType = mime_content_type($fileTmp);
            if (in_array($fileType, $allowedTypes)) {
                if ($fileSize <= $maxSize) {
                    $fileNewName = uniqid('profile_') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                    $uploadPath = '../assets/uploads/profiles/' . $fileNewName;

                    if (!is_dir('../assets/uploads/profiles')) {
                        mkdir('../assets/uploads/profiles', 0777, true);
                    }

                    if (move_uploaded_file($fileTmp, $uploadPath)) {
                        $stmt = $conn->prepare("UPDATE users SET profile_img = ? WHERE id = ?");
                        $profilePath = 'assets/uploads/profiles/' . $fileNewName;
                        if ($stmt->execute([$profilePath, $_SESSION['user_id']])) {
                            $_SESSION['profile_img'] = $profilePath;
                            $response['status'] = 'success';
                            $response['message'] = 'Profile picture updated successfully';
                        }
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'File is too large. Maximum size is 5MB';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid file type. Only JPEG, JPG and PNG are allowed';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error uploading file';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit();
}
