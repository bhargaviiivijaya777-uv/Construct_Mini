<?php
include('db_connect.php');
$res = $conn->query("SELECT m.*, s.seller_name, s.whatsapp_number FROM materials m LEFT JOIN sellers s ON m.seller_id=s.seller_id ORDER BY m.material_name");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Products — ConstructHub</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #1a56db;
  --secondary: #f59e0b;
  --whatsapp: #25d366;
  --light: #f8fafc;
  --dark: #1e293b;
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(-45deg, #1e293b, #334155, #475569, #64748b);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
  color: white;
  min-height: 100vh;
  position: relative;
  overflow-x: hidden;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Floating Particles */
.particle {
  position: absolute;
  border-radius: 50%;
  background: rgba(251, 191, 36, 0.3);
  animation: float 20s infinite linear;
  z-index: -1;
}

@keyframes float {
  0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
  10% { opacity: 1; }
  90% { opacity: 1; }
  100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
}

/* Header */
.topbar {
  background: rgba(30, 41, 59, 0.95);
  backdrop-filter: blur(20px);
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 1000;
  border-bottom: 1px solid rgba(251, 191, 36, 0.2);
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.brand-emoji {
  font-size: 2.5rem;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
  40% {transform: translateY(-5px);}
  60% {transform: translateY(-3px);}
}

.brand-title {
  font-weight: 800;
  font-size: 1.5rem;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.mainnav {
  display: flex;
  gap: 1.5rem;
}

.mainnav a {
  text-decoration: none;
  color: #cbd5e1;
  font-weight: 500;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  transition: all 0.3s ease;
  background: rgba(251, 191, 36, 0.1);
  border: 1px solid rgba(251, 191, 36, 0.2);
}

.mainnav a:hover {
  color: #f59e0b;
  background: rgba(251, 191, 36, 0.15);
  transform: translateY(-2px);
}

/* Main Content */
.container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 1.5rem;
  animation: fadeIn 0.8s ease;
  position: relative;
  z-index: 1;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

h1 {
  font-size: 3rem;
  margin-bottom: 3rem;
  text-align: center;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: titleGlow 3s ease-in-out infinite alternate;
}

@keyframes titleGlow {
  from { filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.4)); }
  to { filter: drop-shadow(0 0 20px rgba(251, 191, 36, 0.8)); }
}

/* Materials Grid */
.materials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.material {
  border-radius: 20px;
  padding: 2rem;
  box-shadow: var(--shadow-xl);
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
  animation: cardSlideIn 0.6s ease forwards;
  opacity: 0;
  transform: translateY(30px);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes cardSlideIn {
  to { opacity: 1; transform: translateY(0); }
}

.material::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  animation: borderFlow 3s linear infinite;
}

@keyframes borderFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.material:hover {
  transform: translateY(-12px) scale(1.03);
  box-shadow: var(--shadow-2xl);
}

/* Material-specific colors */
.material[data-material*="brick"] {
  background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(239, 68, 68, 0.7));
}

.material[data-material*="cement"] {
  background: linear-gradient(135deg, rgba(107, 114, 128, 0.9), rgba(156, 163, 175, 0.7));
}

.material[data-material*="steel"] {
  background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
}

.material[data-material*="tile"] {
  background: linear-gradient(135deg, rgba(124, 58, 237, 0.9), rgba(139, 92, 246, 0.7));
}

.material[data-material*="electr"] {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(251, 191, 36, 0.7));
}

.material[data-material*="plumb"] {
  background: linear-gradient(135deg, rgba(13, 148, 136, 0.9), rgba(20, 184, 166, 0.7));
}

.material[data-material*="sand"] {
  background: linear-gradient(135deg, rgba(180, 83, 9, 0.9), rgba(217, 119, 6, 0.7));
}

.material[data-material*="stone"] {
  background: linear-gradient(135deg, rgba(75, 85, 99, 0.9), rgba(107, 114, 128, 0.7));
}

.material[data-material*="wood"] {
  background: linear-gradient(135deg, rgba(146, 64, 14, 0.9), rgba(180, 83, 9, 0.7));
}

.material[data-material*="paint"] {
  background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(129, 140, 248, 0.7));
}

/* Default color for other materials */
.material:not([data-material*="brick"]):not([data-material*="cement"]):not([data-material*="steel"]):not([data-material*="tile"]):not([data-material*="electr"]):not([data-material*="plumb"]):not([data-material*="sand"]):not([data-material*="stone"]):not([data-material*="wood"]):not([data-material*="paint"]) {
  background: linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(16, 185, 129, 0.7));
}

.material h4 {
  font-size: 1.5rem;
  margin-bottom: 1.5rem;
  color: white;
  font-weight: 700;
  position: relative;
}

.material h4::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 40px;
  height: 3px;
  background: rgba(255, 255, 255, 0.8);
  transition: width 0.3s ease;
}

.material:hover h4::after {
  width: 100%;
}

.material p {
  margin-bottom: 0.75rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: rgba(255, 255, 255, 0.9);
  transition: transform 0.3s ease;
}

.material:hover p {
  transform: translateX(8px);
}

.material strong {
  color: rgba(255, 255, 255, 0.95);
  min-width: 80px;
  font-weight: 600;
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem 1.75rem;
  background: rgba(255, 255, 255, 0.2);
  color: white;
  text-decoration: none;
  border-radius: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn:hover {
  transform: translateY(-3px);
  background: rgba(255, 255, 255, 0.3);
  box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
}

.whatsapp-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem 1.75rem;
  background: linear-gradient(135deg, #25d366, #128c7e);
  color: white;
  text-decoration: none;
  border-radius: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.whatsapp-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
}

.whatsapp-btn-small {
  padding: 0.75rem 1.25rem;
  font-size: 0.8rem;
}

/* Badges */
.whatsapp-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(37, 211, 102, 0.2);
  color: white;
  padding: 0.75rem 1.25rem;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 600;
  margin-top: 1rem;
  border: 1px solid rgba(37, 211, 102, 0.4);
  animation: badgeGlow 2s ease-in-out infinite alternate;
}

@keyframes badgeGlow {
  from { box-shadow: 0 0 10px rgba(37, 211, 102, 0.4); }
  to { box-shadow: 0 0 20px rgba(37, 211, 102, 0.8); }
}

/* Action Buttons */
.material > div:last-child {
  margin-top: 1.5rem;
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

/* Floating WhatsApp */
.floating-whatsapp {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, #25d366, #128c7e);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-decoration: none;
  font-size: 1.75rem;
  box-shadow: var(--shadow-2xl);
  transition: all 0.3s ease;
  z-index: 1000;
  animation: pulse 2s infinite, floatUpDown 3s ease-in-out infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

@keyframes floatUpDown {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}

.floating-whatsapp:hover {
  transform: scale(1.15) translateY(-5px);
  box-shadow: 0 20px 40px rgba(37, 211, 102, 0.6);
  animation: none;
}

/* Responsive */
@media (max-width: 768px) {
  .topbar {
    flex-direction: column;
    padding: 1rem;
    gap: 1rem;
  }
  
  .mainnav {
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .materials-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  h1 {
    font-size: 2.2rem;
  }
  
  .container {
    margin: 1rem auto;
    padding: 0 1rem;
  }
  
  .material > div:last-child {
    flex-direction: column;
  }
}

/* Card Animations */
.material:nth-child(1) { animation-delay: 0.1s; }
.material:nth-child(2) { animation-delay: 0.2s; }
.material:nth-child(3) { animation-delay: 0.3s; }
.material:nth-child(4) { animation-delay: 0.4s; }
.material:nth-child(5) { animation-delay: 0.5s; }
.material:nth-child(6) { animation-delay: 0.6s; }
.material:nth-child(7) { animation-delay: 0.7s; }
.material:nth-child(8) { animation-delay: 0.8s; }
.material:nth-child(9) { animation-delay: 0.9s; }
.material:nth-child(10) { animation-delay: 1.0s; }
</style>
</head>
<body>
<header class="topbar">
  <div class="brand">
    <span class="brand-emoji">🏗️</span>
    <div>
      <div class="brand-title">CONSTRUCTHUB</div>
    </div>
  </div>
  <nav class="mainnav">
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
    <a href="suppliers.php"><i class="fas fa-truck"></i> Suppliers</a>
  </nav>
</header>

<main class="container">
  <h1>All Products</h1>
  <div class="materials-grid">
    <?php while($m = $res->fetch_assoc()): ?>
      <article class="material" data-material="<?php echo strtolower($m['material_name']); ?>">
        <h4><?php echo htmlspecialchars($m['material_name']); ?></h4>
        <p><strong>Price:</strong> ₹<?php echo $m['price']; ?></p>
        <p><strong>Qty:</strong> <?php echo $m['quantity']; ?></p>
        <p><strong>Seller:</strong> <?php echo htmlspecialchars($m['seller_name']); ?></p>
        
        <?php if(!empty($m['whatsapp_number'])): ?>
          <span class="whatsapp-badge"><i class="fab fa-whatsapp"></i> WhatsApp Available</span>
        <?php endif; ?>
        
        <div>
          <a class="btn" href="material_details.php?id=<?php echo $m['material_id']; ?>">
            <i class="fas fa-info-circle"></i> Details
          </a>
          
          <?php if(!empty($m['whatsapp_number'])): ?>
            <a href="https://wa.me/<?php echo $m['whatsapp_number']; ?>?text=Hi%2C%20I'm%20interested%20in%20<?php echo urlencode($m['material_name']); ?>%20(₹<?php echo $m['price']; ?>)%20on%20ConstructHub" 
               target="_blank" 
               class="whatsapp-btn whatsapp-btn-small">
              <i class="fab fa-whatsapp"></i> Chat
            </a>
          <?php endif; ?>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<a href="https://wa.me/919876543210?text=Hi%2C%20I%20need%20help%20with%20products%20on%20ConstructHub" 
   class="floating-whatsapp" 
   target="_blank"
   title="Contact us on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
// Create floating particles
function createParticles() {
  const body = document.body;
  const particleCount = 20;
  
  for (let i = 0; i < particleCount; i++) {
    const particle = document.createElement('div');
    particle.classList.add('particle');
    
    const size = Math.random() * 6 + 3;
    const left = Math.random() * 100;
    const animationDuration = Math.random() * 15 + 10;
    const animationDelay = Math.random() * 5;
    
    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;
    particle.style.left = `${left}vw`;
    particle.style.animationDuration = `${animationDuration}s`;
    particle.style.animationDelay = `${animationDelay}s`;
    
    body.appendChild(particle);
  }
}

// Initialize particles and card effects
document.addEventListener('DOMContentLoaded', function() {
  createParticles();
  
  const cards = document.querySelectorAll('.material');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-12px) scale(1.03)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0) scale(1)';
    });
  });
});

// Header scroll effect
window.addEventListener('scroll', function() {
  const topbar = document.querySelector('.topbar');
  if (window.scrollY > 50) {
    topbar.style.padding = '0.8rem 2rem';
    topbar.style.background = 'rgba(30, 41, 59, 0.98)';
  } else {
    topbar.style.padding = '1rem 2rem';
    topbar.style.background = 'rgba(30, 41, 59, 0.95)';
  }
});
</script>
</body>
</html>