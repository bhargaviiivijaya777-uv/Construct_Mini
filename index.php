<?php
include('db_connect.php');

// Featured pick by name (your DB has 'Premium Bricks' & 'OPC Cement')
$featSql = "SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id
            WHERE m.material_name IN ('Premium Bricks','OPC Cement')";
$featRes = $conn->query($featSql);

// All materials
$allSql = "SELECT m.*, s.seller_name FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id ORDER BY m.material_name";
$allRes = $conn->query($allSql);

// categories (static)
$categories = ['Bricks','Cement','Steel','Tiles','Electrical','Plumbing'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>CONSTRUCTHUB — Construction Materials Marketplace</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">
      <span class="brand-emoji">🏗️</span>
      <div>
        <div class="brand-title">CONSTRUCTHUB</div>
        <div class="brand-sub">Construction Materials Marketplace</div>
      </div>
    </div>

    <nav class="mainnav">
      <a href="index.php">🏠 Home</a>
      <a href="products.php">📦 Products</a>
      <a href="suppliers.php">👥 Suppliers</a>
      <a href="about.php">📞 About</a>
      <a href="login.php">🔐 Login</a>
      <a href="register.php">✨ REGISTER</a>
    </nav>
  </header>

  <main class="container">
    <div class="search-row">
      <form action="search.php" method="get" class="search-form">
        <input type="text" name="search" placeholder="🔍 Search: Cement, Bricks, Steel..." />
        <button type="submit" class="btn-search">🔎</button>
      </form>
    </div>

    <section class="categories">
      <?php
        $map = ['Bricks'=>'🧱','Cement'=>'🏗️','Steel'=>'🔩','Tiles'=>'🎨','Electrical'=>'⚡','Plumbing'=>'🚰'];
        foreach($categories as $cat): ?>
        <a class="cat-card" href="search.php?category=<?php echo urlencode($cat); ?>">
          <div class="cat-emoji"><?php echo $map[$cat] ?? '📦'; ?></div>
          <div class="cat-title"><?php echo $cat; ?></div>
          <div class="cat-sub">&nbsp;</div>
        </a>
      <?php endforeach; ?>
    </section>

    <h2 class="section-title">⭐ Featured Products</h2>
    <section class="featured">
      <?php if($featRes && $featRes->num_rows>0): ?>
        <?php while($f = $featRes->fetch_assoc()): ?>
          <div class="product-card">
            <h3><?php echo htmlspecialchars($f['material_name']); ?></h3>
            <p class="price">₹<?php echo $f['price']; ?><?php echo (stripos($f['material_name'],'bag')!==false)?'/bag':''; ?></p>
            <p class="rating">⭐⭐⭐⭐☆</p>
            <p class="seller">Seller: <?php echo htmlspecialchars($f['seller_name']); ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No featured products yet.</p>
      <?php endif; ?>
    </section>

    <h2 class="section-title">📋 All Materials</h2>
    <section class="materials">
      <?php if($allRes && $allRes->num_rows>0): ?>
        <div class="materials-grid">
          <?php while($m = $allRes->fetch_assoc()): ?>
            <article class="material">
              <h4><?php echo htmlspecialchars($m['material_name']); ?></h4>
              <p>Price: ₹<?php echo $m['price']; ?></p>
              <p>Qty: <?php echo $m['quantity']; ?></p>
              <p>Seller: <?php echo htmlspecialchars($m['seller_name']); ?></p>
              <p><a class="btn" href="material_details.php?id=<?php echo $m['material_id']; ?>">Details</a></p>
            </article>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p>No materials available.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
