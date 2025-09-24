<?php
session_start();

// Kiểm tra token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token không hợp lệ.");
}

// Lấy ID người dùng từ yêu cầu
if (!empty($_POST['id'])) {
    $id = $_POST['id'];

    require_once 'models/UserModel.php';
    $userModel = new UserModel();

    // Xóa người dùng
    if ($userModel->deleteUserById($id)) {
        // Chuyển hướng đến danh sách người dùng với thông báo thành công
        header('Location: list_users.php?message=User deleted successfully');
        exit();
    } else {
        die("Error deleting user.");
    }
} else {
    die("User ID is not provided.");
}
