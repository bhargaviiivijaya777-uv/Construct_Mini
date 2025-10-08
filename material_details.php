<?php
include('db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT m.*, s.seller_name, s.contact_number, s.address FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id WHERE m.material_id=$id LIMIT 1";
$res = $conn->query($sql);
$row = $res ? $res->fetch_assoc() : null;
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $row ? htmlspecialchars($row['material_name']) : 'Material'; ?> — ConstructHub</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="topbar"><div class="brand"><span class="brand-emoji">🏗️</span><div><div class="brand-title">CONSTRUCTHUB</div></div></div><nav class="mainnav"><a href="index.php">Home</a></nav></header>
  <main class="container">
    <?php if(!$row): ?>
      <p>Material not found. <a href="index.php">Back</a></p>
    <?php else: ?>
      <h1><?php echo htmlspecialchars($row['material_name']); ?></h1>
      <p>Price: ₹<?php echo $row['price']; ?></p>
      <p>Quantity: <?php echo $row['quantity']; ?></p>
      <h3>Seller</h3>
      <p><?php echo htmlspecialchars($row['seller_name']); ?></p>
      <p>Contact: <?php echo htmlspecialchars($row['contact_number']); ?></p>
      <p>Address: <?php echo htmlspecialchars($row['address']); ?></p>
      <p><a href="index.php">Back to Home</a></p>
    <?php endif; ?>
  </main>
</body>
</html>
