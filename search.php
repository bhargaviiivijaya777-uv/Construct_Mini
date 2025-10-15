<?php
include('db_connect.php');
$results = [];
$title = 'Search';

if(isset($_GET['category'])){
    $cat = $conn->real_escape_string($_GET['category']);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',sans-serif;background:linear-gradient(-45deg,#0f172a,#1e293b,#334155,#475569);background-size:400% 400%;animation:gradientShift 8s ease infinite;color:white;min-height:100vh;position:relative;overflow-x:hidden;}
  @keyframes gradientShift{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
  .construction-grid{position:fixed;top:0;left:0;width:100%;height:100%;background-image:linear-gradient(rgba(251,191,36,0.1) 1px,transparent 1px),linear-gradient(90deg,rgba(251,191,36,0.1) 1px,transparent 1px);background-size:50px 50px;animation:gridMove 20s linear infinite;z-index:-1;}
  @keyframes gridMove{0%{transform:translate(0,0);}100%{transform:translate(50px,50px);}}
  .floating-icon{position:absolute;font-size:2rem;opacity:0.1;animation:floatRandom 15s infinite linear;z-index:-1;}
  @keyframes floatRandom{0%{transform:translate(0,0) rotate(0deg);}25%{transform:translate(100px,50px) rotate(90deg);}50%{transform:translate(50px,100px) rotate(180deg);}75%{transform:translate(-50px,75px) rotate(270deg);}100%{transform:translate(0,0) rotate(360deg);}}
  .topbar{background:rgba(30,41,59,0.95);backdrop-filter:blur(20px);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;border-bottom:1px solid rgba(251,191,36,0.2);}
  .brand{display:flex;align-items:center;gap:12px;}
  .brand-emoji{font-size:2.5rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:bounce 2s infinite;}
  @keyframes bounce{0%,20%,50%,80%,100%{transform:translateY(0);}40%{transform:translateY(-5px);}60%{transform:translateY(-3px);}}
  .brand-title{font-weight:800;font-size:1.5rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
  .mainnav{display:flex;gap:1.5rem;}
  .mainnav a{text-decoration:none;color:#cbd5e1;font-weight:500;padding:0.75rem 1.25rem;border-radius:12px;transition:all 0.3s ease;background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.2);}
  .mainnav a:hover{color:#f59e0b;background:rgba(251,191,36,0.15);transform:translateY(-2px);}
  .container{max-width:1200px;margin:2rem auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
  @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
  h1{font-size:2.5rem;margin-bottom:2rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
  @keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
  .results-count{margin-bottom:2rem;color:rgba(255,255,255,0.8);font-size:1.1rem;}
  .materials-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2rem;margin-top:2rem;}
  .material{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2rem;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);border:1px solid rgba(255,255,255,0.2);transition:all 0.4s ease;position:relative;overflow:hidden;animation:cardSlideIn 0.6s ease forwards;opacity:0;transform:translateY(30px);}
  @keyframes cardSlideIn{to{opacity:1;transform:translateY(0);}}
  .material::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
  @keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
  .material:hover{transform:translateY(-8px);box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);}
  .material h4{font-size:1.25rem;margin-bottom:1rem;color:white;font-weight:700;}
  .material p{margin-bottom:0.5rem;color:rgba(255,255,255,0.9);}
  .material strong{color:white;}
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.875rem 1.5rem;background:rgba(255,255,255,0.2);color:white;text-decoration:none;border-radius:12px;font-weight:600;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.3);margin-top:1rem;}
  .btn:hover{transform:translateY(-3px);background:rgba(255,255,255,0.3);box-shadow:0 10px 25px rgba(255,255,255,0.2);}
  .no-results{text-align:center;padding:3rem;color:rgba(255,255,255,0.7);font-size:1.1rem;}
  @media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.materials-grid{grid-template-columns:1fr;gap:1.5rem;}.container{margin:1rem auto;padding:0 1rem;}}
  </style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:10%;left:5%;">🏗️</div>
<div class="floating-icon" style="top:30%;left:80%;animation-delay:2s;">🔨</div>
<div class="floating-icon" style="top:60%;left:10%;animation-delay:4s;">⚒️</div>

<header class="topbar">
  <div class="brand">
    <span class="brand-emoji">🏗️</span>
    <div>
      <div class="brand-title">CONSTRUCTHUB</div>
    </div>
  </div>
  <nav class="mainnav">
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
  </nav>
</header>

<main class="container">
  <h1><?php echo $title; ?></h1>
  
  <?php if(count($results)): ?>
    <div class="results-count">
      <i class="fas fa-search"></i> Found <?php echo count($results); ?> result(s)
    </div>
    <div class="materials-grid">
      <?php foreach($results as $m): ?>
        <article class="material" data-material="<?php echo strtolower($m['material_name']); ?>">
          <h4><?php echo htmlspecialchars($m['material_name']); ?></h4>
          <p><strong>Price:</strong> ₹<?php echo $m['price']; ?></p>
          <p><strong>Qty:</strong> <?php echo $m['quantity']; ?></p>
          <p><strong>Seller:</strong> <?php echo htmlspecialchars($m['seller_name']); ?></p>
          <a class="btn" href="material_details.php?id=<?php echo $m['material_id']; ?>">
            <i class="fas fa-info-circle"></i> Details
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="no-results">
      <i class="fas fa-search" style="font-size:3rem;margin-bottom:1rem;opacity:0.5;"></i>
      <p>No results found for your search.</p>
    </div>
  <?php endif; ?>
</main>

<script>
window.addEventListener('scroll', function() {
  const topbar = document.querySelector('.topbar');
  topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
  topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});

document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.material');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});
</script>
</body>
</html>