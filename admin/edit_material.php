<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$materials = $conn->query("SELECT * FROM sellers ORDER BY seller_name");
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $conn->real_escape_string($_POST['material_name']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $seller_id = intval($_POST['seller_id']);
    if($conn->query("UPDATE materials SET material_name='$name', price=$price, quantity=$quantity, seller_id=$seller_id WHERE material_id=$id")){
        $msg = "Updated";
    } else $msg = "Error: ".$conn->error;
}
$row = $conn->query("SELECT * FROM materials WHERE material_id=$id")->fetch_assoc();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Material</title></head><body>
<h2>Edit Material</h2>
<?php if($msg) echo "<p>$msg</p>"; ?>
<form method="post">
  Name: <input type="text" name="material_name" value="<?php echo htmlspecialchars($row['material_name']); ?>" required><br>
  Price: <input type="text" name="price" value="<?php echo $row['price']; ?>" required><br>
  Quantity: <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>" required><br>
  Seller:
  <select name="seller_id" required>
    <?php 
      $sellers = $conn->query("SELECT * FROM sellers ORDER BY seller_name");
      while($s = $sellers->fetch_assoc()): ?>
      <option value="<?php echo $s['seller_id']; ?>" <?php if($s['seller_id']==$row['seller_id']) echo 'selected'; ?>>
        <?php echo htmlspecialchars($s['seller_name']); ?>
      </option>
    <?php endwhile; ?>
  </select><br>
  <input type="submit" value="Save">
</form>
<p><a href="view_materials.php">Back</a></p>
</body></html>
