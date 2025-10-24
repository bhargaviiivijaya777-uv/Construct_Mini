<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin'])) {
    header("Location: landing.php");
    exit;
}

// Determine user type
$isAdmin = isset($_SESSION['admin']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $isAdmin ? "Admin" : "Dashboard"; ?> - ConstructHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Inter',sans-serif;background:linear-gradient(-45deg,#0f172a,#1e293b,#334155,#475569);background-size:400% 400%;animation:gradientShift 8s ease infinite;color:white;min-height:100vh;position:relative;overflow-x:hidden;}
    @keyframes gradientShift{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
    .construction-grid{position:fixed;top:0;left:0;width:100%;height:100%;background-image:linear-gradient(rgba(251,191,36,0.1) 1px,transparent 1px),linear-gradient(90deg,rgba(251,191,36,0.1) 1px,transparent 1px);background-size:50px 50px;animation:gridMove 20s linear infinite;z-index:-1;}
    @keyframes gridMove{0%{transform:translate(0,0);}100%{transform:translate(50px,50px);}}
    .floating-icon{position:absolute;font-size:2rem;opacity:0.1;animation:floatRandom 15s infinite linear;z-index:-1;}
    @keyframes floatRandom{0%{transform:translate(0,0) rotate(0deg);}25%{transform:translate(100px,50px) rotate(90deg);}50%{transform:translate(50px,100px) rotate(180deg);}75%{transform:translate(-50px,75px) rotate(270deg);}100%{transform:translate(0,0) rotate(360deg);}}
    .topbar{background:rgba(30,41,59,0.95);backdrop-filter:blur(20px);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;border-bottom:1px solid rgba(251,191,36,0.2);}
    .brand{display:flex;align-items:center;gap:12px;}
    .brand-emoji{font-size:2.5rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:bounce 2s infinite;}
    @keyframes bounce{0%,20%,50%,80%,100%{transform:translateY(0);}40%{transform:translateY(-5px);}60%{transform:translateY(-3px);}}
    .brand-title{font-weight:800;font-size:1.5rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    .mainnav{display:flex;gap:1.5rem;}
    .mainnav a{text-decoration:none;color:#cbd5e1;font-weight:500;padding:0.75rem 1.25rem;border-radius:12px;transition:all 0.3s ease;background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.2);}
    .mainnav a:hover{color:#f59e0b;background:rgba(251,191,36,0.15);transform:translateY(-2px);}
    .container{max-width:1200px;margin:2rem auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
    @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
    h1{font-size:2.5rem;margin-bottom:1rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
    @keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
    .welcome-card{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);margin-bottom:2.5rem;position:relative;overflow:hidden;}
    .welcome-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
    @keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
    .welcome-text{font-size:1.2rem;color:rgba(255,255,255,0.9);margin-bottom:1.5rem;}
    .dashboard-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:2rem;margin-top:2rem;}
    .dashboard-card{background:linear-gradient(135deg,rgba(255,255,255,0.15),rgba(255,255,255,0.05));backdrop-filter:blur(10px);border-radius:20px;padding:2rem;text-align:center;border:1px solid rgba(255,255,255,0.2);transition:all 0.4s ease;animation:cardSlideIn 0.6s ease forwards;opacity:0;transform:translateY(30px);text-decoration:none;color:white;}
    @keyframes cardSlideIn{to{opacity:1;transform:translateY(0);}}
    .dashboard-card:hover{transform:translateY(-8px);background:linear-gradient(135deg,rgba(255,255,255,0.2),rgba(255,255,255,0.1));}
    .card-icon{font-size:3rem;margin-bottom:1rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    .dashboard-card h3{font-size:1.25rem;margin-bottom:0.5rem;color:white;}
    .dashboard-card p{color:rgba(255,255,255,0.8);font-size:0.9rem;}
    .logout-btn{display:inline-flex;align-items:center;justify-content:center;gap:0.75rem;padding:1rem 2rem;background:linear-gradient(135deg,#dc2626,#ef4444);color:white;text-decoration:none;border-radius:12px;font-weight:600;transition:all 0.3s ease;border:none;margin-top:1.5rem;}
    .logout-btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(220,38,38,0.4);}
    @media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.dashboard-grid{grid-template-columns:1fr;gap:1.5rem;}.container{margin:1rem auto;padding:0 1rem;}}
    </style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:15%;left:8%;">🏗️</div>
<div class="floating-icon" style="top:25%;left:85%;animation-delay:2s;">🔨</div>
<div class="floating-icon" style="top:65%;left:12%;animation-delay:4s;">⚒️</div>

<header class="topbar">
    <div class="brand">
        <span class="brand-emoji">🏗️</span>
        <div>
            <div class="brand-title">CONSTRUCTHUB</div>
        </div>
    </div>
    <nav class="mainnav">
        <a href="<?php echo $isAdmin ? '../index.php' : 'index.php'; ?>"><i class="fas fa-home"></i> Home</a>
        <a href="logout.php" style="background:rgba(220,38,38,0.2);border-color:rgba(220,38,38,0.4);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</header>

<main class="container">
    <?php if ($isAdmin): ?>
        <div class="welcome-card">
            <h1><i class="fas fa-crown"></i> Admin Dashboard</h1>
            <p class="welcome-text">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong></p>
        </div>

        <div class="dashboard-grid">
            <a href="add_seller.php" class="dashboard-card" style="animation-delay:0.1s">
                <div class="card-icon"><i class="fas fa-user-plus"></i></div>
                <h3>Add Seller</h3>
                <p>Add new supplier to the platform</p>
            </a>
            
            <a href="view_sellers.php" class="dashboard-card" style="animation-delay:0.2s">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <h3>View Sellers</h3>
                <p>Manage all suppliers</p>
            </a>
            
            <a href="add_material.php" class="dashboard-card" style="animation-delay:0.3s">
                <div class="card-icon"><i class="fas fa-box"></i></div>
                <h3>Add Material</h3>
                <p>Add new construction material</p>
            </a>
            
            <a href="view_materials.php" class="dashboard-card" style="animation-delay:0.4s">
                <div class="card-icon"><i class="fas fa-boxes"></i></div>
                <h3>View Materials</h3>
                <p>Manage all materials</p>
            </a>
        </div>
    <?php else: ?>
        <div class="welcome-card">
            <h1><i class="fas fa-user"></i> User Dashboard</h1>
            <p class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>!</p>
            <p class="welcome-text">You're successfully logged in to ConstructHub.</p>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    <?php endif; ?>
</main>

<script>
window.addEventListener('scroll', function() {
    const topbar = document.querySelector('.topbar');
    topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
    topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
</body>
</html>