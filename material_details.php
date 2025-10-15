<?php
include('db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT m.*, s.seller_name, s.contact_number, s.whatsapp_number, s.address 
        FROM materials m 
        LEFT JOIN sellers s ON m.seller_id=s.seller_id 
        WHERE m.material_id=$id LIMIT 1";
$res = $conn->query($sql);
$row = $res ? $res->fetch_assoc() : null;
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $row ? htmlspecialchars($row['material_name']) : 'Material'; ?> — ConstructHub</title>
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
  .container{max-width:800px;margin:2rem auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
  @keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
  h1{font-size:2.5rem;margin-bottom:2rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
  @keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
  .card{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);margin-bottom:2.5rem;position:relative;overflow:hidden;}
  .card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
  @keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
  .section-title{font-size:1.5rem;margin-bottom:2rem;color:white;font-weight:600;border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:0.5rem;}
  .info-grid{display:flex;flex-direction:column;gap:1.5rem;}
  .info-item{display:flex;align-items:flex-start;gap:1rem;color:rgba(255,255,255,0.9);line-height:1.6;}
  .info-item strong{color:white;min-width:180px;font-weight:600;font-size:1.1rem;}
  .info-item .value{flex:1;font-size:1.1rem;}
  .divider{height:2px;background:rgba(255,255,255,0.1);margin:2rem 0;border-radius:1px;}
  .badge{display:inline-flex;align-items:center;gap:0.5rem;background:rgba(37,211,102,0.2);color:white;padding:1rem 1.5rem;border-radius:50px;font-size:1rem;font-weight:600;border:1px solid rgba(37,211,102,0.4);animation:badgeGlow 2s ease-in-out infinite alternate;}
  @keyframes badgeGlow{from{box-shadow:0 0 10px rgba(37,211,102,0.4);}to{box-shadow:0 0 20px rgba(37,211,102,0.8);}}
  .btn-group{display:flex;gap:1.5rem;margin-top:2.5rem;flex-wrap:wrap;}
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:0.75rem;padding:1.25rem 2rem;color:white;text-decoration:none;border-radius:12px;font-weight:600;transition:all 0.3s ease;border:none;font-size:1.1rem;}
  .btn:hover{transform:translateY(-3px);box-shadow:0 15px 30px rgba(0,0,0,0.3);}
  .whatsapp-btn{background:linear-gradient(135deg,#25d366,#128c7e);}
  .whatsapp-btn:hover{box-shadow:0 15px 30px rgba(37,211,102,0.4);}
  .quick-order{background:linear-gradient(135deg,#f59e0b,#d97706);}
  .quick-order:hover{box-shadow:0 15px 30px rgba(245,158,11,0.4);}
  .nav-buttons{display:flex;gap:1.5rem;margin-top:2.5rem;}
  .nav-btn{display:inline-flex;align-items:center;justify-content:center;gap:0.75rem;padding:1rem 2rem;background:rgba(255,255,255,0.15);color:white;text-decoration:none;border-radius:12px;font-weight:600;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.3);}
  .nav-btn:hover{transform:translateY(-2px);background:rgba(255,255,255,0.25);}
  @media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}.btn-group,.nav-buttons{flex-direction:column;}.info-item{flex-direction:column;gap:0.5rem;}.info-item strong{min-width:auto;}}
  </style>
</head>
<body>
<div class="construction-grid"></div>
<div class="floating-icon" style="top:15%;left:8%;">🏗️</div>
<div class="floating-icon" style="top:25%;left:85%;animation-delay:2s;">🔨</div>
<div class="floating-icon" style="top:65%;left:12%;animation-delay:4s;">⚒️</div>

<header class="topbar">
  <div class="brand">
    <span class="brand-emoji">🏗️</span>
    <div>
      <div class="brand-title">CONSTRUCTHUB</div>
    </div>
  </div>
  <nav class="mainnav">
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
    <a href="products.php"><i class="fas fa-boxes"></i> Products</a>
  </nav>
</header>

<main class="container">
  <?php if(!$row): ?>
    <div class="card">
      <h1>Material Not Found</h1>
      <p>Sorry, the material you're looking for doesn't exist.</p>
      <div class="nav-buttons">
        <a href="index.php" class="nav-btn"><i class="fas fa-home"></i> Back to Home</a>
      </div>
    </div>
  <?php else: ?>
    <h1><?php echo htmlspecialchars($row['material_name']); ?></h1>
    
    <div class="card">
      <div class="section-title">
        <i class="fas fa-info-circle"></i> Product Details
      </div>
      <div class="info-grid">
        <div class="info-item">
          <strong><i class="fas fa-tag"></i> Price:</strong>
          <span class="value">₹<?php echo $row['price']; ?></span>
        </div>
        
        <div class="info-item">
          <strong><i class="fas fa-cubes"></i> Available Quantity:</strong>
          <span class="value">
            <?php 
            // Display quantity with proper unit
            $quantity = htmlspecialchars($row['quantity']);
            $unit = htmlspecialchars($row['unit']);
            
            // If quantity already contains unit text, just display it
            if (preg_match('/[a-zA-Z]/', $quantity)) {
                echo $quantity;
            } else {
                // Otherwise, format with the unit
                echo $quantity . ' ' . $unit;
            }
            ?>
          </span>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="section-title">
        <i class="fas fa-warehouse"></i> Supplier Information
      </div>
      <div class="info-grid">
        <div class="info-item">
          <strong><i class="fas fa-building"></i> Company:</strong>
          <span class="value"><?php echo htmlspecialchars($row['seller_name']); ?></span>
        </div>
        
        <div class="info-item">
          <strong><i class="fas fa-phone"></i> Contact:</strong>
          <span class="value"><?php echo htmlspecialchars($row['contact_number']); ?></span>
        </div>
        
        <?php if(!empty($row['whatsapp_number'])): ?>
          <div class="divider"></div>
          
          <div class="info-item">
            <span class="badge"><i class="fab fa-whatsapp"></i> WhatsApp Available</span>
          </div>
          
          <div class="info-item">
            <strong><i class="fab fa-whatsapp"></i> WhatsApp:</strong>
            <span class="value"><?php echo htmlspecialchars($row['whatsapp_number']); ?></span>
          </div>
          
          <div class="btn-group">
            <a href="https://wa.me/<?php echo $row['whatsapp_number']; ?>?text=Hi%2C%20I%20am%20interested%20in%20<?php echo urlencode($row['material_name']); ?>%20(₹<?php echo $row['price']; ?>)%20on%20ConstructHub" 
               target="_blank" class="btn whatsapp-btn">
              <i class="fab fa-whatsapp"></i> Contact via WhatsApp
            </a>
            
            <a href="https://wa.me/<?php echo $row['whatsapp_number']; ?>?text=Hi%2C%20I%20want%20to%20buy%20<?php echo urlencode($row['material_name']); ?>%20immediately.%20Please%20share%20delivery%20options." 
               target="_blank" class="btn quick-order">
              <i class="fas fa-shipping-fast"></i> Quick Order
            </a>
          </div>
        <?php else: ?>
          <div class="info-item">
            <i class="fas fa-phone"></i> Contact via phone for inquiries
          </div>
        <?php endif; ?>
        
        <div class="divider"></div>
        
        <div class="info-item">
          <strong><i class="fas fa-map-marker-alt"></i> Address:</strong>
          <span class="value"><?php echo htmlspecialchars($row['address']); ?></span>
        </div>
      </div>
    </div>

    <div class="nav-buttons">
      <a href="products.php" class="nav-btn"><i class="fas fa-arrow-left"></i> Back to Products</a>
      <a href="index.php" class="nav-btn"><i class="fas fa-home"></i> Home</a>
    </div>
  <?php endif; ?>
</main>

<script>
window.addEventListener('scroll', function() {
  const topbar = document.querySelector('.topbar');
  topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
  topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});
</script>
</body>
</html>