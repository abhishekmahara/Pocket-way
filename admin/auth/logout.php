<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Log the logout event with more details
    if (isset($_SESSION['admin_username'])) {
        $logMessage = sprintf(
            "Admin logout: %s (ID: %s) from IP: %s at %s",
            $_SESSION['admin_username'],
            $_SESSION['admin_id'] ?? 'unknown',
            $_SERVER['REMOTE_ADDR'],
            date('Y-m-d H:i:s')
        );
        error_log($logMessage);
    }

    // Clear all session variables
    $_SESSION = array();

    // Delete the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(
            session_name(), 
            '', 
            [
                'expires' => time() - 3600,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
    }

    // Destroy the session
    session_destroy();

    // Clear any other cookies that might be set
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, '/');
    }

    // Redirect with success message
    $_SESSION['logout_message'] = 'You have been successfully logged out.';
    header('Location: login.php?msg=logout_success');
    exit();

} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    header('Location: login.php?msg=error');
    exit();
}