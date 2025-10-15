<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $conn->real_escape_string($_POST['seller_name']);
    $contact = $conn->real_escape_string($_POST['contact_number']);
    $whatsapp = $conn->real_escape_string($_POST['whatsapp_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $sql = "UPDATE sellers SET seller_name='$name', contact_number='$contact', whatsapp_number='$whatsapp', address='$address' WHERE seller_id=$id";
    if($conn->query($sql)) { 
        $msg = "Seller updated successfully!"; 
    }
    else $msg = "Error: ".$conn->error;
}
$row = $conn->query("SELECT * FROM sellers WHERE seller_id=$id")->fetch_assoc();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Seller - CONSTRUCTHUB</title>
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
.whatsapp-field{border-left:4px solid #25D366 !important;background:rgba(37,211,102,0.1) !important;}
.whatsapp-field:focus{border-color:#25D366 !important;box-shadow:0 0 0 3px rgba(37,211,102,0.3) !important;}
button{background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#0f172a;font-weight:600;cursor:pointer;border:none;}
button:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(251,191,36,0.3);}
.msg{padding:1rem;border-radius:12px;margin-bottom:1rem;text-align:center;background:rgba(16,185,129,0.2);border:1px solid rgba(16,185,129,0.4);}
.back-link{display:inline-flex;align-items:center;gap:0.5rem;color:#cbd5e1;text-decoration:none;margin-top:1.5rem;transition:color 0.3s ease;}
.back-link:hover{color:#f59e0b;}
@media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}}
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
        <a href="view_sellers.php"><i class="fas fa-users"></i> View Sellers</a>
    </nav>
</header>

<main class="container">
    <h1><i class="fas fa-edit"></i> Edit Seller</h1>
    
    <div class="form-container">
        <?php if($msg): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input name="seller_name" placeholder="Seller Name" value="<?php echo htmlspecialchars($row['seller_name']); ?>" required>
            <input name="contact_number" placeholder="Contact Number" value="<?php echo htmlspecialchars($row['contact_number']); ?>">
            <input name="whatsapp_number" placeholder="WhatsApp Number" value="<?php echo htmlspecialchars($row['whatsapp_number']); ?>" class="whatsapp-field">
            <input name="address" placeholder="Address" value="<?php echo htmlspecialchars($row['address']); ?>">
            <button name="submit" type="submit"><i class="fas fa-save"></i> Update Seller</button>
        </form>
    </div>

    <a href="view_sellers.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Sellers List
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