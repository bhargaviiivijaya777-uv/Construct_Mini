<?php
include('db_connect.php');
$results = [];
$title = 'Search';

// search by category or search text
if(isset($_GET['category'])){
    $cat = $conn->real_escape_string($_GET['category']);
    // materials table has no category column; we search by material_name instead
    $sql = "SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id
            WHERE m.material_name LIKE '%$cat%'";
    $title = "Category: ".htmlspecialchars($cat);
    $res = $conn->query($sql);
    if($res) $results = $res->fetch_all(MYSQLI_ASSOC);
} elseif(isset($_GET['search'])){
    $q = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id
            WHERE m.material_name LIKE '%$q%'";
    $title = "Search: ".htmlspecialchars($_GET['search']);
    $res = $conn->query($sql);
    if($res) $results = $res->fetch_all(MYSQLI_ASSOC);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?> — ConstructHub</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="topbar"><div class="brand"><span class="brand-emoji">🏗️</span><div><div class="brand-title">CONSTRUCTHUB</div></div></div><nav class="mainnav"><a href="index.php">Home</a></nav></header>
  <main class="container">
    <h2><?php echo $title; ?></h2>
    <?php if(count($results)): ?>
      <div class="materials-grid">
        <?php foreach($results as $m): ?>
          <article class="material">
            <h4><?php echo htmlspecialchars($m['material_name']); ?></h4>
            <p>Price: ₹<?php echo $m['price']; ?></p>
            <p>Qty: <?php echo $m['quantity']; ?></p>
            <p>Seller: <?php echo htmlspecialchars($m['seller_name']); ?></p>
            <p><a class="btn" href="material_details.php?id=<?php echo $m['material_id']; ?>">Details</a></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>No results found.</p>
    <?php endif; ?>
  </main>
</body>
</html>
