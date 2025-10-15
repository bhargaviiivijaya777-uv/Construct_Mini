<?php
include('db_connect.php');
$res = $conn->query("SELECT * FROM sellers ORDER BY seller_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers — ConstructHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    :root {
      --primary: #1a56db;
      --secondary: #f59e0b;
      --whatsapp: #25d366;
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
      background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #475569);
      background-size: 400% 400%;
      animation: gradientShift 8s ease infinite;
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

    /* Construction Grid Background */
    .construction-grid {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(rgba(251, 191, 36, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(251, 191, 36, 0.1) 1px, transparent 1px);
      background-size: 50px 50px;
      animation: gridMove 20s linear infinite;
      z-index: -1;
    }

    @keyframes gridMove {
      0% { transform: translate(0, 0); }
      100% { transform: translate(50px, 50px); }
    }

    /* Floating Construction Icons */
    .floating-icon {
      position: absolute;
      font-size: 2rem;
      opacity: 0.1;
      animation: floatRandom 15s infinite linear;
      z-index: -1;
    }

    @keyframes floatRandom {
      0% { transform: translate(0, 0) rotate(0deg); }
      25% { transform: translate(100px, 50px) rotate(90deg); }
      50% { transform: translate(50px, 100px) rotate(180deg); }
      75% { transform: translate(-50px, 75px) rotate(270deg); }
      100% { transform: translate(0, 0) rotate(360deg); }
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

    /* Suppliers Grid */
    .suppliers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .supplier-card {
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

    .supplier-card::before {
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

    .supplier-card:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: var(--shadow-2xl);
    }

    /* Supplier-specific colors */
    .supplier-card:nth-child(6n+1) {
      background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
    }

    .supplier-card:nth-child(6n+2) {
      background: linear-gradient(135deg, rgba(234, 88, 12, 0.9), rgba(245, 158, 11, 0.7));
    }

    .supplier-card:nth-child(6n+3) {
      background: linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(16, 185, 129, 0.7));
    }

    .supplier-card:nth-child(6n+4) {
      background: linear-gradient(135deg, rgba(124, 58, 237, 0.9), rgba(139, 92, 246, 0.7));
    }

    .supplier-card:nth-child(6n+5) {
      background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(239, 68, 68, 0.7));
    }

    .supplier-card:nth-child(6n+6) {
      background: linear-gradient(135deg, rgba(13, 148, 136, 0.9), rgba(20, 184, 166, 0.7));
    }

    .supplier-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .supplier-name {
      font-size: 1.5rem;
      color: white;
      font-weight: 700;
      position: relative;
    }

    .supplier-name::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 40px;
      height: 3px;
      background: rgba(255, 255, 255, 0.8);
      transition: width 0.3s ease;
    }

    .supplier-card:hover .supplier-name::after {
      width: 100%;
    }

    .contact-info {
      margin: 1.5rem 0;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 0.75rem;
      padding: 0.75rem;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .supplier-card:hover .contact-item {
      transform: translateX(8px);
    }

    .contact-item i {
      width: 20px;
      color: rgba(255, 255, 255, 0.9);
    }

    .contact-item span {
      color: rgba(255, 255, 255, 0.9);
      font-weight: 500;
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
      width: 100%;
      text-align: center;
    }

    .btn:hover {
      transform: translateY(-3px);
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }

    .btn:disabled {
      background: rgba(107, 114, 128, 0.5);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .btn:disabled:hover {
      transform: none;
      box-shadow: none;
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
      width: 100%;
      text-align: center;
    }

    .whatsapp-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
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
      
      .suppliers-grid {
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
    }

    /* Card Animations */
    .supplier-card:nth-child(1) { animation-delay: 0.1s; }
    .supplier-card:nth-child(2) { animation-delay: 0.2s; }
    .supplier-card:nth-child(3) { animation-delay: 0.3s; }
    .supplier-card:nth-child(4) { animation-delay: 0.4s; }
    .supplier-card:nth-child(5) { animation-delay: 0.5s; }
    .supplier-card:nth-child(6) { animation-delay: 0.6s; }
    .supplier-card:nth-child(7) { animation-delay: 0.7s; }
    .supplier-card:nth-child(8) { animation-delay: 0.8s; }
    .supplier-card:nth-child(9) { animation-delay: 0.9s; }
    .supplier-card:nth-child(10) { animation-delay: 1.0s; }
    </style>
</head>
<body>
    <!-- New Background Animations -->
    <div class="construction-grid"></div>
    <div class="floating-icon" style="top: 10%; left: 5%; animation-delay: 0s;">🏗️</div>
    <div class="floating-icon" style="top: 20%; left: 80%; animation-delay: 2s;">🔨</div>
    <div class="floating-icon" style="top: 60%; left: 10%; animation-delay: 4s;">⚒️</div>
    <div class="floating-icon" style="top: 80%; left: 70%; animation-delay: 6s;">🧱</div>
    <div class="floating-icon" style="top: 40%; left: 90%; animation-delay: 8s;">🏭</div>

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
        <h1>Our Suppliers</h1>

        <div class="suppliers-grid">
            <?php while($s = $res->fetch_assoc()): ?>
                <div class="supplier-card">
                    <div class="supplier-header">
                        <h3 class="supplier-name">
                            <i class="fas fa-warehouse"></i> <?php echo htmlspecialchars($s['seller_name']); ?>
                        </h3>
                    </div>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($s['contact_number']); ?></span>
                        </div>
                        
                        <?php if(!empty($s['whatsapp_number'])): ?>
                            <div class="contact-item">
                                <i class="fab fa-whatsapp"></i>
                                <span><strong><?php echo htmlspecialchars($s['whatsapp_number']); ?></strong></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($s['address']); ?></span>
                        </div>
                    </div>

                    <?php if(!empty($s['whatsapp_number'])): ?>
                        <a href="https://wa.me/<?php echo $s['whatsapp_number']; ?>?text=Hi%2C%20I%20found%20your%20company%20on%20ConstructHub%20and%20would%20like%20to%20discuss%20construction%20materials." 
                           target="_blank" 
                           class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i> Start WhatsApp Chat
                        </a>
                    <?php else: ?>
                        <button class="btn" disabled>
                            <i class="fas fa-phone"></i> Contact via Phone
                        </button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/919876543210?text=Hi%2C%20I%20need%20help%20finding%20suppliers%20on%20ConstructHub" 
       class="floating-whatsapp" 
       target="_blank"
       title="Contact us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script>
    // Initialize card effects
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.supplier-card');
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