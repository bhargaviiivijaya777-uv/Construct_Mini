<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$res = $conn->query("SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id = s.seller_id ORDER BY m.material_name");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>View Materials</title>
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
h1{font-size:2.5rem;margin-bottom:2rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
@keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
.table-container{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);position:relative;overflow:hidden;}
.table-container::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
@keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
.table{width:100%;border-collapse:collapse;background:transparent;}
.table th{background:rgba(251,191,36,0.2);color:white;padding:1.25rem;text-align:left;font-weight:600;border-bottom:2px solid rgba(251,191,36,0.3);}
.table td{padding:1.25rem;border-bottom:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);}
.table tr:hover td{background:rgba(255,255,255,0.05);}
.price-cell{color:#fbbf24;font-weight:600;}
.quantity-cell{font-weight:500;}
.actions{display:flex;gap:0.75rem;}
.btn{display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:8px;text-decoration:none;font-weight:500;transition:all 0.3s ease;font-size:0.875rem;}
.btn-edit{background:rgba(245,158,11,0.2);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);}
.btn-edit:hover{background:rgba(245,158,11,0.3);transform:translateY(-2px);}
.btn-delete{background:rgba(220,38,38,0.2);color:#fca5a5;border:1px solid rgba(220,38,38,0.3);}
.btn-delete:hover{background:rgba(220,38,38,0.3);transform:translateY(-2px);}
.back-link{display:inline-flex;align-items:center;gap:0.5rem;color:#cbd5e1;text-decoration:none;margin-top:1.5rem;transition:color 0.3s ease;}
.back-link:hover{color:#f59e0b;}
@media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}.table-container{overflow-x:auto;}.table th,.table td{padding:0.75rem 0.5rem;}}
</style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:10%;left:5%;">🏗️</div>
<div class="floating-icon" style="top:30%;left:80%;animation-delay:2s;">🔨</div>
<div class="floating-icon" style="top:60%;left:10%;animation-delay:4s;">⚒️</div>

<header class="topbar">
    <div class="brand">
        <span class="brand-emoji">🏗️</span>
        <div class="brand-title">CONSTRUCTHUB</div>
    </div>
    <nav class="mainnav">
        <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <a href="add_material.php" style="background:rgba(16,185,129,0.2);border-color:rgba(16,185,129,0.4);"><i class="fas fa-plus"></i> Add Material</a>
    </nav>
</header>

<main class="container">
    <h1><i class="fas fa-boxes"></i> Materials List</h1>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Seller</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($r = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $r['material_id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($r['material_name']); ?></strong></td>
                    <td class="price-cell">$<?php echo $r['price']; ?></td>
                    <td class="quantity-cell">
                        <?php 
                        $quantity = $r['quantity'];
                        $unit = $r['unit'];
                        if (preg_match('/[a-zA-Z]/', $quantity)) {
                            echo $quantity;
                        } else {
                            echo $quantity . ' ' . $unit;
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($r['seller_name']); ?></td>
                    <td>
                        <div class="actions">
                            <a href="edit_material.php?id=<?php echo $r['material_id']; ?>" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete_material.php?id=<?php echo $r['material_id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this material?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</main>

<script>
window.addEventListener('scroll', function() {
    const topbar = document.querySelector('.topbar');
    topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
    topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});
</script>
</body>
</html>