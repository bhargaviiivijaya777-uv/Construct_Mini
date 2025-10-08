<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$res = $conn->query("SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id = s.seller_id ORDER BY m.material_name");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>View Materials</title></head><body>
<h2>Materials</h2>
<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Name</th><th>Price</th><th>Qty</th><th>Seller</th><th>Actions</th></tr>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?php echo $r['material_id']; ?></td>
      <td><?php echo htmlspecialchars($r['material_name']); ?></td>
      <td><?php echo $r['price']; ?></td>
      <td><?php echo $r['quantity']; ?></td>
      <td><?php echo htmlspecialchars($r['seller_name']); ?></td>
      <td>
        <a href="edit_material.php?id=<?php echo $r['material_id']; ?>">Edit</a> |
        <a href="delete_material.php?id=<?php echo $r['material_id']; ?>" onclick="return confirm('Delete this material?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
<p><a href="dashboard.php">Back</a></p>
</body></html>
