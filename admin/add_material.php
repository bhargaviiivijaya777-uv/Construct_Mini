<?php
session_start(); if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$sellers = $conn->query("SELECT seller_id, seller_name FROM sellers ORDER BY seller_name");
$msg='';
if(isset($_POST['submit'])){
    $name = $conn->real_escape_string($_POST['material_name']);
    $price = floatval($_POST['price']);
    $qty = intval($_POST['quantity']);
    $seller_id = intval($_POST['seller_id']);
    $sql = "INSERT INTO materials (material_name, price, quantity, seller_id) VALUES ('$name',$price,$qty,$seller_id)";
    if($conn->query($sql)) $msg='Material added';
    else $msg='Error: '.$conn->error;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Add Material</title><link rel="stylesheet" href="../css/style.css"></head><body>
<main class="container">
  <h1>Add Material</h1><?php if($msg) echo "<p>$msg</p>"; ?>
  <form method="post">
    <input name="material_name" placeholder="Material name" required><br>
    <input name="price" placeholder="Price" required><br>
    <input name="quantity" placeholder="Quantity" required><br>
    <select name="seller_id" required>
      <?php while($s=$sellers->fetch_assoc()): ?>
        <option value="<?php echo $s['seller_id']; ?>"><?php echo htmlspecialchars($s['seller_name']); ?></option>
      <?php endwhile; ?>
    </select><br>
    <button name="submit" type="submit">Add Material</button>
  </form>
  <p><a href="dashboard.php">Back</a></p>
</main>
</body></html>
