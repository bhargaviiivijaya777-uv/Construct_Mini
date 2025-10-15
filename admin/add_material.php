<?php
session_start(); if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$sellers = $conn->query("SELECT seller_id, seller_name FROM sellers ORDER BY seller_name");
$msg='';
if(isset($_POST['submit'])){
    $name = $conn->real_escape_string($_POST['material_name']);
    $price = floatval($_POST['price']);
    $qty = $conn->real_escape_string($_POST['quantity']); // Changed to accept text
    $unit = $conn->real_escape_string($_POST['unit']);
    $seller_id = intval($_POST['seller_id']);
    $sql = "INSERT INTO materials (material_name, price, quantity, unit, seller_id) VALUES ('$name',$price,'$qty','$unit',$seller_id)";
    if($conn->query($sql)) $msg='Material added';
    else $msg='Error: '.$conn->error;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Material</title>
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
.container{max-width:600px;margin:2rem auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
@keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
h1{font-size:2.5rem;margin-bottom:2rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;text-align:center;}
@keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
.form-container{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);position:relative;overflow:hidden;}
.form-container::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
@keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
input,select,button{width:100%;padding:1rem;margin-bottom:1rem;border-radius:12px;border:1px solid rgba(255,255,255,0.2);background:rgba(15,23,42,0.7);color:white;font-size:1rem;transition:all 0.3s ease;}
input:focus,select:focus{border-color:#fbbf24;outline:none;box-shadow:0 0 0 3px rgba(251,191,36,0.3);}
.quantity-row{display:flex;gap:1rem;margin-bottom:1rem;}
.quantity-row input{flex:2;margin-bottom:0;}
.quantity-row select{flex:1;margin-bottom:0;}
button{background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#0f172a;font-weight:600;cursor:pointer;border:none;}
button:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(251,191,36,0.3);}
.msg{padding:1rem;border-radius:12px;margin-bottom:1rem;text-align:center;background:rgba(16,185,129,0.2);border:1px solid rgba(16,185,129,0.4);}
.back-link{display:inline-flex;align-items:center;gap:0.5rem;color:#cbd5e1;text-decoration:none;margin-top:1.5rem;transition:color 0.3s ease;}
.back-link:hover{color:#f59e0b;}
.help-text{font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:-0.5rem;margin-bottom:1rem;}
@media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}.quantity-row{flex-direction:column;}}
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
        <a href="view_materials.php"><i class="fas fa-list"></i> View Materials</a>
    </nav>
</header>

<main class="container">
    <h1><i class="fas fa-plus-circle"></i> Add Material</h1>
    
    <div class="form-container">
        <?php if($msg): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input name="material_name" placeholder="Material Name" required>
            <input name="price" type="number" step="0.01" placeholder="Price" required>
            
            <div class="quantity-row">
                <input name="quantity" placeholder="Quantity (e.g., 50, 1000, 25 kgs)" required>
                <select name="unit">
                    <option value="units">Units</option>
                    <option value="kg">Kilograms</option>
                    <option value="g">Grams</option>
                    <option value="tons">Tons</option>
                    <option value="feet">Feet</option>
                    <option value="meters">Meters</option>
                    <option value="sq ft">Square Feet</option>
                    <option value="sq m">Square Meters</option>
                    <option value="bags">Bags</option>
                    <option value="pieces">Pieces</option>
                    <option value="bundles">Bundles</option>
                    <option value="cubic feet">Cubic Feet</option>
                    <option value="cubic meters">Cubic Meters</option>
                    <option value="liters">Liters</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            <p class="help-text">Examples: 50 kgs, 1000 bricks, 25 bags, 500 feet, etc.</p>
            
            <select name="seller_id" required>
                <?php while($s=$sellers->fetch_assoc()): ?>
                    <option value="<?php echo $s['seller_id']; ?>"><?php echo htmlspecialchars($s['seller_name']); ?></option>
                <?php endwhile; ?>
            </select>
            <button name="submit" type="submit"><i class="fas fa-plus"></i> Add Material</button>
        </form>
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

// Auto-detect unit from quantity input
document.querySelector('input[name="quantity"]').addEventListener('input', function(e) {
    const value = e.target.value.toLowerCase();
    const unitSelect = document.querySelector('select[name="unit"]');
    
    if (value.includes('kg') || value.includes('kilo')) {
        unitSelect.value = 'kg';
    } else if (value.includes('g ')) {
        unitSelect.value = 'g';
    } else if (value.includes('feet') || value.includes('ft')) {
        unitSelect.value = 'feet';
    } else if (value.includes('meter') || value.includes('m ')) {
        unitSelect.value = 'meters';
    } else if (value.includes('bag')) {
        unitSelect.value = 'bags';
    } else if (value.includes('piece') || value.includes('pc')) {
        unitSelect.value = 'pieces';
    } else if (value.includes('bundle')) {
        unitSelect.value = 'bundles';
    }
});
</script>
</body>
</html>