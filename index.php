<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit();
}

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CONSTRUCTHUB — Construction Materials Marketplace</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #475569);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite, backgroundPulse 20s ease-in-out infinite;
      min-height: 100vh;
      color: white;
      overflow-x: hidden;
      position: relative;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes backgroundPulse {
      0% { background-size: 400% 400%; }
      50% { background-size: 450% 450%; }
      100% { background-size: 400% 400%; }
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
      z-index: 0;
      pointer-events: none;
    }

    @keyframes gridMove {
      0% { transform: translate(0, 0); }
      100% { transform: translate(50px, 50px); }
    }

    /* Enhanced Floating Icons */
    .floating-icon {
      position: fixed;
      font-size: 3rem;
      opacity: 0.1;
      animation: enhancedFloat 20s infinite ease-in-out;
      z-index: 0;
      pointer-events: none;
    }

    @keyframes enhancedFloat {
      0%, 100% { 
        transform: translate(0, 0) rotate(0deg) scale(1);
        opacity: 0.1;
      }
      25% { 
        transform: translate(100px, -50px) rotate(90deg) scale(1.1);
        opacity: 0.15;
      }
      50% { 
        transform: translate(50px, 100px) rotate(180deg) scale(1.2);
        opacity: 0.1;
      }
      75% { 
        transform: translate(-100px, 50px) rotate(270deg) scale(1.1);
        opacity: 0.15;
      }
    }

    /* Enhanced Sparkle Effect */
    .sparkle {
      position: fixed;
      width: 4px;
      height: 4px;
      background: rgba(251, 191, 36, 0.8);
      border-radius: 50%;
      animation: enhancedSparkle 8s infinite;
      opacity: 0;
      z-index: 0;
      pointer-events: none;
    }

    @keyframes enhancedSparkle {
      0% { 
        opacity: 0; 
        transform: translateY(0) scale(0) rotate(0deg);
      }
      10% { 
        opacity: 1; 
        transform: translateY(-20px) scale(1) rotate(180deg);
      }
      90% { 
        opacity: 1; 
        transform: translateY(-80vh) scale(1.5) rotate(720deg);
      }
      100% { 
        opacity: 0; 
        transform: translateY(-100vh) scale(0) rotate(900deg);
      }
    }

    /* Particle Effect */
    .particle {
      position: fixed;
      width: 6px;
      height: 6px;
      background: rgba(251, 191, 36, 0.3);
      border-radius: 50%;
      animation: particleFloat 12s infinite linear;
      z-index: 0;
      pointer-events: none;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) rotate(360deg);
        opacity: 0;
      }
    }

    /* Header Styles */
    .topbar {
      background: rgba(30, 41, 59, 0.98);
      backdrop-filter: blur(20px);
      padding: 1rem 2rem;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      position: sticky;
      top: 0;
      z-index: 1000;
      animation: slideDown 0.6s ease-out;
      border-bottom: 2px solid rgba(251, 191, 36, 0.3);
      transition: all 0.3s ease;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    @keyframes slideDown {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .brand-emoji {
      font-size: 2.5rem;
      animation: bounce 2s ease-in-out infinite;
      filter: drop-shadow(0 4px 12px rgba(251, 191, 36, 0.4));
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
      60% { transform: translateY(-5px); }
    }

    .brand-title {
      font-size: 1.8rem;
      font-weight: 800;
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
      animation: titleGlow 3s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
      from { filter: drop-shadow(0 0 5px rgba(251, 191, 36, 0.3)); }
      to { filter: drop-shadow(0 0 15px rgba(245, 158, 11, 0.6)); }
    }

    .brand-sub {
      font-size: 0.9rem;
      color: #cbd5e1;
      font-weight: 400;
    }

    .mainnav {
      display: flex;
      gap: 0.8rem;
      flex-wrap: wrap;
    }

    .mainnav a {
      text-decoration: none;
      color: #cbd5e1;
      padding: 0.7rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      background: rgba(251, 191, 36, 0.1);
      border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .mainnav a::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transition: left 0.3s ease;
      z-index: -1;
    }

    .mainnav a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s ease;
    }

    .mainnav a:hover::before {
      left: 0;
    }

    .mainnav a:hover::after {
      transform: scaleX(1);
    }

    .mainnav a:hover {
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(251, 191, 36, 0.4);
    }

    .mainnav a:last-child {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      color: #1e293b;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      position: relative;
      z-index: 10;
    }

    /* Search Bar */
    .search-row {
      margin: 3rem 0;
      animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .search-form {
      display: flex;
      max-width: 700px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      border: 2px solid rgba(255, 255, 255, 0.2);
      position: relative;
    }

    .search-form:hover,
    .search-form:focus-within {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 35px 90px rgba(251, 191, 36, 0.4);
    }

    .search-form input {
      flex: 1;
      border: none;
      padding: 1.2rem 1.5rem;
      font-size: 1.1rem;
      font-family: inherit;
      outline: none;
      background: transparent;
      color: white;
    }

    .search-form input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    /* Typing animation for search placeholder */
    @keyframes typing {
      from { width: 0; }
      to { width: 100%; }
    }

    @keyframes blink {
      0%, 100% { border-color: transparent; }
      50% { border-color: #fbbf24; }
    }

    .search-form input::placeholder {
      animation: typing 3s steps(40, end), blink 1s step-end infinite;
      overflow: hidden;
      white-space: nowrap;
      border-right: 2px solid;
    }

    .btn-search {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      border: none;
      padding: 0 2rem;
      font-size: 1.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
      color: #1e293b;
      position: relative;
      overflow: hidden;
      font-weight: 600;
    }

    .btn-search:hover {
      transform: scale(1.1) rotate(10deg);
    }

    /* Categories */
    .categories {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1.5rem;
      margin: 3rem 0;
      animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .cat-card {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 2rem 1.5rem;
      text-align: center;
      text-decoration: none;
      color: white;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      border: 2px solid transparent;
      animation: cardSlideIn 0.6s ease forwards;
      opacity: 0;
      transform: translateY(30px);
    }

    @keyframes cardSlideIn {
      to { opacity: 1; transform: translateY(0); }
    }

    .cat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .cat-card:hover::before {
      opacity: 1;
    }

    .cat-card:hover {
      transform: translateY(-15px) scale(1.05) rotate(2deg);
      box-shadow: 0 25px 60px rgba(251, 191, 36, 0.4);
      border-color: rgba(251, 191, 36, 0.5);
    }

    .cat-emoji {
      font-size: 3.5rem;
      margin-bottom: 1rem;
      animation: wiggle 3s ease-in-out infinite;
      position: relative;
      z-index: 1;
      display: inline-block;
    }

    @keyframes wiggle {
      0%, 100% { transform: rotate(0deg); }
      25% { transform: rotate(-15deg) scale(1.1); }
      75% { transform: rotate(15deg) scale(1.1); }
    }

    .cat-card:hover .cat-emoji {
      animation: emojiPop 0.6s ease-out;
    }

    @keyframes emojiPop {
      0% { transform: scale(1) rotate(0deg); }
      50% { transform: scale(1.3) rotate(10deg); }
      100% { transform: scale(1.2) rotate(0deg); }
    }

    .cat-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: white;
      position: relative;
      z-index: 1;
    }

    .cat-sub {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
      position: relative;
      z-index: 1;
    }

    /* WhatsApp Section */
    .whatsapp-promo {
      background: linear-gradient(135deg, #25D366, #128C7E, #075E54);
      background-size: 200% 200%;
      animation: gradientShift 8s ease infinite;
      color: white;
      padding: 3rem;
      border-radius: 25px;
      margin: 3rem 0;
      text-align: center;
      box-shadow: 0 20px 60px rgba(37, 211, 102, 0.4);
      animation: fadeInUp 0.8s ease-out 0.6s both, gradientShift 8s ease infinite;
      position: relative;
      overflow: hidden;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .whatsapp-promo::before {
      content: '💬';
      position: absolute;
      font-size: 20rem;
      opacity: 0.08;
      top: -5rem;
      right: -5rem;
      animation: spin 20s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .whatsapp-promo h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      position: relative;
      z-index: 1;
      animation: titleGlow 3s ease-in-out infinite alternate;
    }

    .whatsapp-promo > p {
      font-size: 1.3rem;
      margin-bottom: 2rem;
      opacity: 0.95;
      position: relative;
      z-index: 1;
    }

    .whatsapp-features {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
      position: relative;
      z-index: 1;
    }

    .whatsapp-feature {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      padding: 2rem;
      border-radius: 15px;
      min-width: 150px;
      transition: all 0.4s ease;
      border: 2px solid rgba(255, 255, 255, 0.3);
      animation: featureFloat 3s ease-in-out infinite;
      position: relative;
      overflow: hidden;
    }

    @keyframes featureFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .whatsapp-feature:nth-child(1) { animation-delay: 0s; }
    .whatsapp-feature:nth-child(2) { animation-delay: 0.5s; }
    .whatsapp-feature:nth-child(3) { animation-delay: 1s; }

    .whatsapp-feature:hover {
      background: rgba(255, 255, 255, 0.35);
      transform: translateY(-10px) scale(1.1);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .whatsapp-feature-emoji {
      font-size: 3rem;
      margin-bottom: 0.5rem;
      animation: bounce 2s ease-in-out infinite;
    }

    .whatsapp-feature-text {
      font-size: 1.1rem;
      font-weight: 600;
    }

    /* Section Title */
    .section-title {
      font-size: 2.5rem;
      font-weight: 800;
      text-align: center;
      margin: 3rem 0 2rem;
      color: white;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 0.8s ease-out 0.8s both, titleGlow 3s ease-in-out infinite alternate;
      position: relative;
      overflow: hidden;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: -100%;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #fbbf24, transparent);
      animation: wave 3s ease-in-out infinite;
    }

    @keyframes wave {
      0% { left: -100%; }
      50% { left: 100%; }
      100% { left: 100%; }
    }

    /* Featured Products */
    .featured {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 4rem;
      animation: fadeInUp 0.8s ease-out 1s both;
    }

    .product-card {
      background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
      backdrop-filter: blur(10px);
      border-radius: 25px;
      padding: 2.5rem;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      border: 2px solid rgba(255, 255, 255, 0.3);
      animation: cardSlideIn 0.6s ease forwards;
      opacity: 0;
      transform: translateY(30px);
    }

    .product-card::after {
      content: '⭐';
      position: absolute;
      font-size: 12rem;
      top: -4rem;
      right: -4rem;
      opacity: 0.05;
      transition: all 0.5s ease;
    }

    .product-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.1), rgba(59, 130, 246, 0.1));
      opacity: 0;
      transition: all 0.5s ease;
      transform: rotate(45deg);
    }

    .product-card:hover::before {
      opacity: 1;
      top: -10%;
      left: -10%;
    }

    .product-card:hover::after {
      transform: rotate(15deg) scale(1.2);
      opacity: 0.1;
    }

    .product-card:hover {
      transform: translateY(-15px) scale(1.03);
      box-shadow: 0 30px 80px rgba(251, 191, 36, 0.4);
      border-color: rgba(251, 191, 36, 0.5);
    }

    .product-card h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: white;
      position: relative;
      z-index: 1;
    }

    .price {
      font-size: 2rem;
      font-weight: 800;
      color: #fbbf24;
      margin: 1rem 0;
      position: relative;
      z-index: 1;
      animation: priceGlow 2s ease-in-out infinite, priceBounce 3s ease-in-out infinite;
    }

    @keyframes priceGlow {
      0%, 100% { text-shadow: 0 0 10px rgba(251, 191, 36, 0.3); }
      50% { text-shadow: 0 0 20px rgba(251, 191, 36, 0.6); }
    }

    @keyframes priceBounce {
      0%, 20%, 50%, 80%, 100% { 
        transform: scale(1); 
      }
      40% { 
        transform: scale(1.2); 
      }
      60% { 
        transform: scale(1.1); 
      }
    }

    .rating {
      font-size: 1.5rem;
      margin: 1rem 0;
      position: relative;
      z-index: 1;
    }

    .seller {
      font-size: 1rem;
      color: rgba(255, 255, 255, 0.8);
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 2px solid rgba(255, 255, 255, 0.2);
      font-weight: 600;
      position: relative;
      z-index: 1;
    }

    /* Ripple Effect */
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .topbar {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
      }
      
      .mainnav {
        justify-content: center;
      }
    }

    @media (max-width: 768px) {
      .topbar {
        padding: 1rem;
        flex-direction: column;
        gap: 1rem;
      }

      .brand-emoji {
        font-size: 2rem;
      }

      .brand-title {
        font-size: 1.5rem;
      }

      .mainnav {
        gap: 0.5rem;
        justify-content: center;
      }

      .mainnav a {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
      }

      .container {
        padding: 1rem;
        margin: 1rem auto;
      }

      .search-form input {
        padding: 1rem;
        font-size: 1rem;
        width: 200px;
      }

      .categories {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
      }

      .cat-emoji {
        font-size: 2.5rem;
      }

      .whatsapp-promo {
        padding: 2rem 1rem;
      }

      .whatsapp-promo h2 {
        font-size: 1.8rem;
      }

      .section-title {
        font-size: 2rem;
      }

      .featured {
        grid-template-columns: 1fr;
      }
      
      .whatsapp-features {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <div class="construction-grid"></div>
  
  <!-- Floating Icons -->
  <div class="floating-icon" style="top: 10%; left: 5%;">🏗️</div>
  <div class="floating-icon" style="top: 20%; left: 85%; animation-delay: 2s;">🔨</div>
  <div class="floating-icon" style="top: 60%; left: 10%; animation-delay: 4s;">🧱</div>
  <div class="floating-icon" style="top: 75%; left: 80%; animation-delay: 6s;">⚒️</div>
  <div class="floating-icon" style="top: 40%; left: 60%; animation-delay: 8s;">💰</div>
  <div class="floating-icon" style="top: 85%; left: 30%; animation-delay: 10s;">🚚</div>
  <div class="floating-icon" style="top: 45%; left: 90%; animation-delay: 12s;">⭐</div>
  
  <!-- Sparkles -->
  <div class="sparkle" style="left: 10%; animation-delay: 0s;"></div>
  <div class="sparkle" style="left: 25%; animation-delay: 2s;"></div>
  <div class="sparkle" style="left: 50%; animation-delay: 4s;"></div>
  <div class="sparkle" style="left: 75%; animation-delay: 6s;"></div>
  <div class="sparkle" style="left: 90%; animation-delay: 8s;"></div>

  <!-- Enhanced Particles -->
  <div class="particle" style="left: 15%; animation-delay: 0s;"></div>
  <div class="particle" style="left: 30%; animation-delay: 1s;"></div>
  <div class="particle" style="left: 45%; animation-delay: 2s;"></div>
  <div class="particle" style="left: 60%; animation-delay: 3s;"></div>
  <div class="particle" style="left: 75%; animation-delay: 4s;"></div>
  <div class="particle" style="left: 90%; animation-delay: 5s;"></div>

  <header class="topbar">
    <div class="brand">
      <span class="brand-emoji">🏗️</span>
      <div>
        <div class="brand-title">CONSTRUCTHUB</div>
        <div class="brand-sub">Construction Materials Marketplace</div>
      </div>
    </div>

    <nav class="mainnav">
      <a href="index.php"><i class="fas fa-home"></i> Home</a>
      <a href="products.php"><i class="fas fa-box"></i> Products</a>
      <a href="suppliers.php"><i class="fas fa-users"></i> Suppliers</a>
      <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
      <a href="feedback.php"><i class="fas fa-comments"></i> Feedback</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </header>

  <main class="container">
    <div class="search-row">
      <form action="search.php" method="get" class="search-form">
        <input type="text" name="search" placeholder="🔍 Search: Cement, Bricks, Steel..." />
        <button type="submit" class="btn-search">Search</button>
      </form>
    </div>

    <section class="categories">
      <?php
        $map = ['Bricks'=>'🧱','Cement'=>'🏗️','Steel'=>'🔩','Tiles'=>'🎨','Electrical'=>'⚡','Plumbing'=>'🚰'];
        $delay = 0;
        foreach($categories as $cat): ?>
        <a class="cat-card" href="search.php?category=<?php echo urlencode($cat); ?>" style="animation-delay: <?php echo $delay; ?>s;">
          <div class="cat-emoji"><?php echo $map[$cat] ?? '📦'; ?></div>
          <div class="cat-title"><?php echo $cat; ?></div>
          <div class="cat-sub">Browse Products</div>
        </a>
      <?php $delay += 0.1; endforeach; ?>
    </section>

    <!-- WhatsApp Promotion Section -->
    <section class="whatsapp-promo">
        <h2><i class="fab fa-whatsapp"></i> Instant WhatsApp Connection</h2>
        <p>Connect directly with suppliers via WhatsApp for quick quotes and fast responses!</p>
        <div class="whatsapp-features">
            <div class="whatsapp-feature">
                <div class="whatsapp-feature-emoji">⚡</div>
                <div class="whatsapp-feature-text">Instant Replies</div>
            </div>
            <div class="whatsapp-feature">
                <div class="whatsapp-feature-emoji">💰</div>
                <div class="whatsapp-feature-text">Best Prices</div>
            </div>
            <div class="whatsapp-feature">
                <div class="whatsapp-feature-emoji">🚚</div>
                <div class="whatsapp-feature-text">Fast Delivery</div>
            </div>
        </div>
    </section>

    <h2 class="section-title"><i class="fas fa-star"></i> Featured Products</h2>
    <section class="featured">
      <?php if($featRes && $featRes->num_rows>0): 
        $prodDelay = 0;
        while($f = $featRes->fetch_assoc()): ?>
          <div class="product-card" style="animation-delay: <?php echo $prodDelay; ?>s;">
            <h3><?php echo htmlspecialchars($f['material_name']); ?></h3>
            <p class="price">₹<?php echo $f['price']; ?><?php echo (stripos($f['material_name'],'bag')!==false)?'/bag':''; ?></p>
            <p class="rating">⭐⭐⭐⭐☆</p>
            <p class="seller"><i class="fas fa-store"></i> Seller: <?php echo htmlspecialchars($f['seller_name']); ?></p>
          </div>
      <?php $prodDelay += 0.2; endwhile; ?>
      <?php else: ?>
        <div class="product-card">
          <h3>No Featured Products</h3>
          <p class="price">Coming Soon</p>
          <p class="rating">⭐⭐⭐⭐⭐</p>
          <p class="seller">Stay tuned for updates</p>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <script>
    // Enhanced scroll effect for topbar
    window.addEventListener('scroll', function() {
      const topbar = document.querySelector('.topbar');
      const scrolled = window.scrollY > 50;
      
      topbar.style.background = scrolled ? 'rgba(30, 41, 59, 1)' : 'rgba(30, 41, 59, 0.98)';
      topbar.style.padding = scrolled ? '0.8rem 2rem' : '1rem 2rem';
      topbar.style.boxShadow = scrolled ? '0 12px 40px rgba(0, 0, 0, 0.4)' : '0 8px 32px rgba(0, 0, 0, 0.3)';
    });

    // Enhanced stagger animation for cards with intersection observer
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.cat-card, .product-card');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.animationPlayState = 'running';
          }
        });
      }, { threshold: 0.1 });

      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.style.animationPlayState = 'paused';
        observer.observe(card);
      });

      // Parallax effect for floating icons
      window.addEventListener('scroll', function() {
        const floatingIcons = document.querySelectorAll('.floating-icon');
        const scrolled = window.pageYOffset;
        
        floatingIcons.forEach((icon, index) => {
          const speed = 0.5 + (index * 0.1);
          const yPos = -(scrolled * speed);
          const currentTransform = icon.style.transform;
          icon.style.transform = `translateY(${yPos}px) ${currentTransform}`;
        });
      });
    });

    // Add ripple effect to buttons
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-search') || e.target.closest('.mainnav a')) {
        const button = e.target.classList.contains('btn-search') ? e.target : e.target.closest('.mainnav a');
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
          position: absolute;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.6);
          transform: scale(0);
          animation: ripple 0.6s linear;
          pointer-events: none;
          width: ${size}px;
          height: ${size}px;
          left: ${x}px;
          top: ${y}px;
        `;
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
      }
    });
  </script>
</body>
</html>