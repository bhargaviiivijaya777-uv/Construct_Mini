<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login — ConstructHub</title>
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
  margin-bottom: 2rem;
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

/* Login Content */
.login-content {
  background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
  backdrop-filter: blur(10px);
  border-radius: 20px;
  padding: 3rem;
  box-shadow: var(--shadow-2xl);
  border: 1px solid rgba(255, 255, 255, 0.2);
  max-width: 600px;
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  animation: cardSlideIn 0.6s ease;
}

@keyframes cardSlideIn {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.login-content::before {
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

.login-content p {
  font-size: 1.2rem;
  line-height: 1.6;
  margin-bottom: 2rem;
  color: rgba(255, 255, 255, 0.9);
  text-align: center;
}

.login-content strong {
  color: #fbbf24;
  font-weight: 700;
}

/* Admin Button */
.admin-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 1.25rem 2.5rem;
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: white;
  text-decoration: none;
  border-radius: 15px;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  border: 2px solid rgba(255, 255, 255, 0.3);
  position: relative;
  overflow: hidden;
  margin: 0 auto;
  display: block;
  width: fit-content;
  animation: btnPulse 2s ease-in-out infinite;
}

@keyframes btnPulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.admin-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.5s;
}

.admin-btn:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
  animation: none;
}

.admin-btn:hover::before {
  left: 100%;
}

/* Features Grid */
.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.feature-card {
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
  backdrop-filter: blur(10px);
  border-radius: 15px;
  padding: 2rem;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
  animation: cardSlideIn 0.6s ease forwards;
  opacity: 0;
  transform: translateY(30px);
}

.feature-card:nth-child(1) { animation-delay: 0.2s; }
.feature-card:nth-child(2) { animation-delay: 0.4s; }
.feature-card:nth-child(3) { animation-delay: 0.6s; }

.feature-card:hover {
  transform: translateY(-8px);
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.feature-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
  color: white;
}

.feature-card p {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.9rem;
  margin: 0;
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
  
  h1 {
    font-size: 2.2rem;
  }
  
  .container {
    margin: 1rem auto;
    padding: 0 1rem;
  }
  
  .login-content {
    padding: 2rem;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
  }
  
  .admin-btn {
    padding: 1rem 2rem;
    font-size: 1rem;
  }
}
</style>
</head>
<body>
    <!-- Background Animations -->
    <div class="construction-grid"></div>
    <div class="floating-icon" style="top: 15%; left: 8%; animation-delay: 0s;">🏗️</div>
    <div class="floating-icon" style="top: 25%; left: 85%; animation-delay: 2s;">🔨</div>
    <div class="floating-icon" style="top: 65%; left: 12%; animation-delay: 4s;">⚒️</div>
    <div class="floating-icon" style="top: 75%; left: 75%; animation-delay: 6s;">🧱</div>
    <div class="floating-icon" style="top: 45%; left: 92%; animation-delay: 8s;">🏭</div>

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
        <h1>Login</h1>
        
        <div class="login-content">
            <p>Use <strong>Admin</strong> area for adding data:</p>
            <a href="admin/admin_login.php" class="admin-btn">
                <i class="fas fa-lock"></i>
                Admin Login
            </a>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Access</h3>
                <p>Protected admin panel with secure authentication</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h3>Data Management</h3>
                <p>Manage suppliers, products, and materials efficiently</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Analytics</h3>
                <p>Track performance and monitor business growth</p>
            </div>
        </div>
    </main>

    <script>
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

    // Add hover effects to feature cards
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.feature-card');
      cards.forEach(card => {
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