<?php
session_start();
if(isset($_SESSION['admin'])) header("Location: dashboard.php");
$msg='';
if(isset($_POST['login'])){
    $u = $_POST['username']; $p = $_POST['password'];
    if($u === 'admin' && $p === 'admin123'){
        $_SESSION['admin'] = $u;
        header("Location: dashboard.php"); exit;
    } else $msg = 'Invalid credentials';
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
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
.container{max-width:400px;margin:10vh auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
@keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
.login-card{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:3rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);position:relative;overflow:hidden;}
.login-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
@keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
h1{font-size:2.5rem;margin-bottom:2rem;text-align:center;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
@keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
.alert{background:rgba(220,38,38,0.2);color:#fca5a5;padding:1rem;border-radius:10px;border:1px solid rgba(220,38,38,0.4);margin-bottom:1.5rem;text-align:center;}
.form-group{margin-bottom:1.5rem;}
.form-control{width:100%;padding:1rem;border:2px solid rgba(255,255,255,0.2);border-radius:10px;background:rgba(255,255,255,0.1);color:white;font-size:1rem;transition:all 0.3s ease;}
.form-control:focus{outline:none;border-color:#f59e0b;background:rgba(255,255,255,0.15);transform:translateY(-2px);}
.form-control::placeholder{color:rgba(255,255,255,0.6);}
.btn{width:100%;padding:1rem;background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:10px;font-size:1.1rem;font-weight:600;cursor:pointer;transition:all 0.3s ease;position:relative;overflow:hidden;}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(245,158,11,0.4);}
.credential-note{text-align:center;margin-top:1.5rem;color:rgba(255,255,255,0.7);font-size:0.9rem;}
</style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:20%;left:10%;">🏗️</div>
<div class="floating-icon" style="top:70%;left:85%;animation-delay:3s;">🔨</div>
<div class="floating-icon" style="top:40%;left:15%;animation-delay:6s;">⚒️</div>

<main class="container">
    <div class="login-card">
        <h1><i class="fas fa-lock"></i> Admin Login</h1>
        
        <?php if($msg): ?>
            <div class="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <p class="credential-note">
            <i class="fas fa-info-circle"></i> Use: admin / admin123
        </p>
    </div>
</main>

<script>
window.addEventListener('load', function() {
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
        });
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
</body>
</html>