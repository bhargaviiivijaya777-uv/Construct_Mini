<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ConstructHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #475569);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .construction-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(251, 191, 36, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(251, 191, 36, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -1;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .floating-icon {
            position: absolute;
            font-size: 3rem;
            opacity: 0.1;
            animation: floatRandom 15s infinite linear;
            z-index: -1;
        }

        @keyframes floatRandom {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(100px, 50px) rotate(90deg); }
            50% { transform: translate(50px, 100px) rotate(180deg); }
            75% { transform: translate(-50px, 75px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        .welcome-container {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 4rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.2);
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        .welcome-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            animation: borderFlow 3s linear infinite;
        }

        @keyframes borderFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 2rem;
        }

        .brand-emoji {
            font-size: 4rem;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .brand-title {
            font-weight: 800;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-text {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 1.2rem 2rem;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-admin {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
        }

        .btn-admin:hover {
            box-shadow: 0 15px 30px rgba(220, 38, 38, 0.4);
        }

        .divider {
            margin: 2rem 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .welcome-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            .brand-title {
                font-size: 2rem;
            }
            
            .brand-emoji {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="construction-grid"></div>
    <div class="floating-icon" style="top: 10%; left: 5%;">🏗️</div>
    <div class="floating-icon" style="top: 20%; left: 85%; animation-delay: 2s;">🔨</div>
    <div class="floating-icon" style="top: 60%; left: 10%; animation-delay: 4s;">⚒️</div>
    <div class="floating-icon" style="top: 80%; left: 70%; animation-delay: 6s;">🧱</div>

    <div class="welcome-container">
        <div class="brand">
            <span class="brand-emoji">🏗️</span>
            <div class="brand-title">CONSTRUCTHUB</div>
        </div>
        
        <p class="welcome-text">
            Welcome to India's Premier Construction Materials Marketplace.<br>
            Get started by creating your account or log in as admin.
        </p>

        <div class="btn-container">
            <a href="user_register.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> User Registration
            </a>
            
            <a href="user_login.php" class="btn btn-secondary">
                <i class="fas fa-sign-in-alt"></i> User Login
            </a>

            <div class="divider"></div>

            <a href="admin/admin_login.php" class="btn btn-admin">
                <i class="fas fa-lock"></i> Admin Login
            </a>
        </div>
    </div>
</body>
</html>