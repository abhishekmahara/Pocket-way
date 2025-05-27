<?php
session_start();
require_once '../includes/db-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'] ?? '';

    try {
        // Validate credentials
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND status = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['last_activity'] = time();
            $_SESSION['created'] = time();

            // Update last login timestamp
            $updateStmt = $pdo->prepare("UPDATE admin_users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
            $updateStmt->execute([$user['id']]);

            // Log successful login
            error_log("Admin login successful: {$user['username']} from IP: {$_SERVER['REMOTE_ADDR']}");

            // Redirect to dashboard
            header('Location: ../dashboard.php');
            exit;
        } else {
            // Log failed attempt
            error_log("Failed login attempt for username: $username from IP: {$_SERVER['REMOTE_ADDR']}");
            
            // Return to login with error
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: login.php');
            exit;
        }
    } catch (PDOException $e) {
        // Log database errors
        error_log("Login process error: " . $e->getMessage());
        
        $_SESSION['login_error'] = 'System error, please try again later';
        header('Location: login.php');
        exit;
    }
} else {
    // Invalid request method
    header('Location: login.php');
    exit;
}