<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Pocket-way Admin</title>
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
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            padding: 3rem;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .welcome-logo {
            height: 100px;
            margin-bottom: 2rem;
        }
        
        .welcome-title {
            color: var(--primary);
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .welcome-subtitle {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
        }
        
        .welcome-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            text-align: left;
        }
        
        .feature-item {
            display: flex;
            align-items: start;
            gap: 1rem;
        }
        
        .feature-icon {
            background: var(--primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .feature-text h4 {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .feature-text p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <img src="../assets/img/logoo.png" alt="Pocket-way Logo" class="welcome-logo">
        <h1 class="welcome-title">Welcome to Pocket-way Admin</h1>
        <p class="welcome-subtitle">Manage your transport network efficiently and effectively</p>
        
        <div class="welcome-buttons">
            <a href="auth/login.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In to Dashboard
            </a>
        </div>
        
        <div class="features">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-route"></i>
                </div>
                <div class="feature-text">
                    <h4>Route Management</h4>
                    <p>Create and manage transport routes efficiently</p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-bus"></i>
                </div>
                <div class="feature-text">
                    <h4>Fleet Control</h4>
                    <p>Monitor and manage your bus fleet</p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="feature-text">
                    <h4>Schedule Management</h4>
                    <p>Organize bus timings and schedules</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>