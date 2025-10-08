<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$res = $conn->query("SELECT * FROM sellers ORDER BY seller_name");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>View Sellers</title></head><body>
<h2>Sellers</h2>
<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Name</th><th>Contact</th><th>Address</th><th>Actions</th></tr>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?php echo $r['seller_id']; ?></td>
      <td><?php echo htmlspecialchars($r['seller_name']); ?></td>
      <td><?php echo htmlspecialchars($r['contact_number']); ?></td>
      <td><?php echo htmlspecialchars($r['address']); ?></td>
      <td>
        <a href="edit_seller.php?id=<?php echo $r['seller_id']; ?>">Edit</a> |
        <a href="delete_seller.php?id=<?php echo $r['seller_id']; ?>" onclick="return confirm('Delete this seller?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
<p><a href="dashboard.php">Back</a></p>
</body></html>
