<?php
session_start(); 
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$msg='';
$seller_name = $contact_number = $whatsapp_number = $address = '';

if(isset($_POST['submit'])){
    $name = $conn->real_escape_string($_POST['seller_name']);
    $contact = $conn->real_escape_string($_POST['contact_number']);
    $whatsapp = $conn->real_escape_string($_POST['whatsapp_number']);
    $address = $conn->real_escape_string($_POST['address']);
    
    $seller_name = $_POST['seller_name'];
    $contact_number = $_POST['contact_number'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $address = $_POST['address'];
    
    $contact_valid = true;
    $whatsapp_valid = true;
    
    if(!empty($contact)) {
        $clean_contact = preg_replace('/\D/', '', $contact);
        if(strlen($clean_contact) !== 10) {
            $msg = 'Error: Contact number must be exactly 10 digits';
            $contact_valid = false;
        } else {
            $contact = $clean_contact;
        }
    }
    
    if(!empty($whatsapp) && $contact_valid) {
        $clean_whatsapp = preg_replace('/\D/', '', $whatsapp);
        if(strlen($clean_whatsapp) !== 10) {
            $msg = 'Error: WhatsApp number must be exactly 10 digits';
            $whatsapp_valid = false;
        } else {
            $whatsapp = $clean_whatsapp;
        }
    }
    
    if($contact_valid && $whatsapp_valid) {
        if($conn->query("INSERT INTO sellers (seller_name, contact_number, whatsapp_number, address) VALUES ('$name','$contact','$whatsapp','$address')")) {
            $msg = 'Seller added successfully';
            $seller_name = $contact_number = $whatsapp_number = $address = '';
        } else {
            $msg = 'Error: '.$conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Seller</title>
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
.form-card{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);position:relative;overflow:hidden;}
.form-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
@keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
h1{font-size:2rem;margin-bottom:2rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
@keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
.alert{background:rgba(16,185,129,0.2);color:#a7f3d0;padding:1rem;border-radius:10px;border:1px solid rgba(16,185,129,0.4);margin-bottom:1.5rem;text-align:center;}
.alert.error{background:rgba(220,38,38,0.2);color:#fca5a5;border-color:rgba(220,38,38,0.4);}
.form-group{margin-bottom:1.5rem;}
.form-control{width:100%;padding:1rem;border:2px solid rgba(255,255,255,0.2);border-radius:10px;background:rgba(255,255,255,0.1);color:white;font-size:1rem;transition:all 0.3s ease;}
.form-control:focus{outline:none;border-color:#f59e0b;background:rgba(255,255,255,0.15);transform:translateY(-2px);}
.form-control::placeholder{color:rgba(255,255,255,0.6);}
.whatsapp-field{border-left:4px solid #25d366;background:rgba(37,211,102,0.05);}
.btn{width:100%;padding:1rem;background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:10px;font-size:1.1rem;font-weight:600;cursor:pointer;transition:all 0.3s ease;margin-top:1rem;}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(245,158,11,0.4);}
.back-link{display:inline-flex;align-items:center;gap:0.5rem;color:#cbd5e1;text-decoration:none;margin-top:1.5rem;transition:color 0.3s ease;}
.back-link:hover{color:#f59e0b;}
@media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}.form-card{padding:2rem;}}
</style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:20%;left:10%;">🏗️</div>
<div class="floating-icon" style="top:70%;left:85%;animation-delay:3s;">🔨</div>
<div class="floating-icon" style="top:40%;left:15%;animation-delay:6s;">⚒️</div>

<header class="topbar">
    <div class="brand">
        <span class="brand-emoji">🏗️</span>
        <div>
            <div class="brand-title">CONSTRUCTHUB</div>
        </div>
    </div>
    <nav class="mainnav">
        <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </nav>
</header>

<main class="container">
    <div class="form-card">
        <h1><i class="fas fa-user-plus"></i> Add Seller</h1>
        
        <?php if($msg): ?>
            <div class="alert <?php echo strpos($msg, 'Error') !== false ? 'error' : ''; ?>">
                <i class="fas fa-<?php echo strpos($msg, 'Error') !== false ? 'exclamation-triangle' : 'check-circle'; ?>"></i> 
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <input type="text" name="seller_name" placeholder="Seller Name" class="form-control" value="<?php echo htmlspecialchars($seller_name); ?>" required>
            </div>
            
            <div class="form-group">
                <input type="text" name="contact_number" placeholder="Contact Number (10 digits)" class="form-control" value="<?php echo htmlspecialchars($contact_number); ?>">
            </div>
            
            <div class="form-group">
                <input type="text" name="whatsapp_number" placeholder="WhatsApp Number (10 digits)" class="form-control whatsapp-field" value="<?php echo htmlspecialchars($whatsapp_number); ?>">
            </div>
            
            <div class="form-group">
                <input type="text" name="address" placeholder="Address" class="form-control" value="<?php echo htmlspecialchars($address); ?>">
            </div>
            
            <button type="submit" name="submit" class="btn">
                <i class="fas fa-plus"></i> Add Seller
            </button>
        </form>

        <a href="dashboard.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</main>

<script>
window.addEventListener('scroll', function() {
    const topbar = document.querySelector('.topbar');
    topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
    topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});

document.querySelector('form').addEventListener('submit', function(e) {
    const contact = document.querySelector('input[name="contact_number"]').value;
    const whatsapp = document.querySelector('input[name="whatsapp_number"]').value;
    
    if(contact.trim() !== '') {
        const cleanContact = contact.replace(/\D/g, '');
        if(cleanContact.length !== 10) {
            alert('Contact number must be exactly 10 digits');
            e.preventDefault();
            return;
        }
    }
    
    if(whatsapp.trim() !== '') {
        const cleanWhatsapp = whatsapp.replace(/\D/g, '');
        if(cleanWhatsapp.length !== 10) {
            alert('WhatsApp number must be exactly 10 digits');
            e.preventDefault();
            return;
        }
    }
});
</script>
</body>
</html>