<?php
include('db_connect.php');
$res = $conn->query("SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id ORDER BY m.material_name");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Products — ConstructHub</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header class="topbar"><div class="brand"><span class="brand-emoji">🏗️</span><div><div class="brand-title">CONSTRUCTHUB</div></div></div><nav class="mainnav"><a href="index.php">Home</a></nav></header>
<main class="container">
  <h1>All Products</h1>
  <div class="materials-grid">
    <?php while($m = $res->fetch_assoc()): ?>
      <article class="material">
        <h4><?php echo htmlspecialchars($m['material_name']); ?></h4>
        <p>Price: ₹<?php echo $m['price']; ?></p>
        <p>Qty: <?php echo $m['quantity']; ?></p>
        <p>Seller: <?php echo htmlspecialchars($m['seller_name']); ?></p>
        <p><a class="btn" href="material_details.php?id=<?php echo $m['material_id']; ?>">Details</a></p>
      </article>
    <?php endwhile; ?>
  </div>
</main>
</body>
</html>
