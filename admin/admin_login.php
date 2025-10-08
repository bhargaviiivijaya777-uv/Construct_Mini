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
<html><head><meta charset="utf-8"><title>Admin Login</title><link rel="stylesheet" href="../css/style.css"></head><body>
<main class="container">
  <h1>Admin Login</h1>
  <?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
  <form method="post"><input name="username" placeholder="username"><br><input name="password" placeholder="password" type="password"><br><button name="login" type="submit">Login</button></form>
  <p>Use admin / admin123</p>
</main>
</body></html>
