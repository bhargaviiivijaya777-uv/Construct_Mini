<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $conn->real_escape_string($_POST['seller_name']);
    $contact = $conn->real_escape_string($_POST['contact_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $sql = "UPDATE sellers SET seller_name='$name', contact_number='$contact', address='$address' WHERE seller_id=$id";
    if($conn->query($sql)) { $msg = "Updated"; }
    else $msg = "Error: ".$conn->error;
}
$row = $conn->query("SELECT * FROM sellers WHERE seller_id=$id")->fetch_assoc();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Seller</title></head><body>
<h2>Edit Seller</h2>
<?php if($msg) echo "<p>$msg</p>"; ?>
<form method="post">
  Name: <input type="text" name="seller_name" value="<?php echo htmlspecialchars($row['seller_name']); ?>" required><br>
  Contact: <input type="text" name="contact_number" value="<?php echo htmlspecialchars($row['contact_number']); ?>"><br>
  Address: <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>"><br>
  <input type="submit" value="Save">
</form>
<p><a href="view_sellers.php">Back</a></p>
</body></html>
