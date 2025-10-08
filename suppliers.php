<?php
include('db_connect.php');
$res = $conn->query("SELECT * FROM sellers ORDER BY seller_name");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Suppliers — ConstructHub</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header class="topbar"><div class="brand"><span class="brand-emoji">🏗️</span><div><div class="brand-title">CONSTRUCTHUB</div></div></div><nav class="mainnav"><a href="index.php">Home</a></nav></header>
<main class="container">
  <h1>Suppliers</h1>
  <div class="suppliers-list">
    <?php while($s = $res->fetch_assoc()): ?>
      <div class="supplier-card">
        <h4><?php echo htmlspecialchars($s['seller_name']); ?></h4>
        <p>☎ <?php echo htmlspecialchars($s['contact_number']); ?></p>
        <p><?php echo htmlspecialchars($s['address']); ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</main>
</body>
</html>
