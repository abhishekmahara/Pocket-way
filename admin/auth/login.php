<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Handle logout message
$logout_message = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'logout_success') {
    $logout_message = 'You have been successfully logged out.';
}

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: ../pages/dashboard.php');
    exit;
}

// Include database configuration
require_once '../includes/db-config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND status = 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_role'] = $user['role'];
                header('Location: ../pages/dashboard.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $error = 'System error, please try again later';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pocket-way Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>


    :root {
        --primary: #007B7F;
        --primary-dark: #006366;
        --accent: #F9A825;
    }
    
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        max-width: 420px;
        width: 100%;
        padding: 2.5rem;
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
    }

    .login-logo {
        width: 130px;
        margin-bottom: 2rem;
        animation: fadeIn 1s ease;
    }

    .form-control {
        padding: 14px;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 127, 0.25);
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 1px solid #e0e0e0;
        background: #f8f9fa;
    }

    .btn-primary {
        background: var(--primary);
        border: none;
        padding: 12px 20px;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 127, 0.3);
    }

    .welcome-text {
        color: var(--primary-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Additional animations */
    .form-control, .btn-primary {
        animation: slideUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="../../assets/img/logoo_teal.png" alt="Pocket-way Logo" class="login-logo">
            <h4>Welcome Back</h4>
            <p class="text-muted">Please login to continue</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" 
                           class="form-control" 
                           id="username" 
                           name="username" 
                           required 
                           autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>