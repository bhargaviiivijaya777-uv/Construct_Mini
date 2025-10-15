<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>About — ConstructHub</title>
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
.brand-sub{font-size:0.9rem;color:#cbd5e1;margin-top:2px;}
.mainnav{display:flex;gap:1.5rem;}
.mainnav a{text-decoration:none;color:#cbd5e1;font-weight:500;padding:0.75rem 1.25rem;border-radius:12px;transition:all 0.3s ease;background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.2);}
.mainnav a:hover{color:#f59e0b;background:rgba(251,191,36,0.15);transform:translateY(-2px);}
.container{max-width:1200px;margin:2rem auto;padding:0 1.5rem;animation:fadeIn 0.8s ease;position:relative;z-index:1;}
@keyframes fadeIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
h1{font-size:2.5rem;margin-bottom:1rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:titleGlow 3s ease-in-out infinite alternate;}
@keyframes titleGlow{from{filter:drop-shadow(0 0 10px rgba(251,191,36,0.4));}to{filter:drop-shadow(0 0 20px rgba(251,191,36,0.8));}}
.about-card{background:linear-gradient(135deg,rgba(30,64,175,0.9),rgba(59,130,246,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.2);margin-bottom:2.5rem;position:relative;overflow:hidden;}
.about-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
@keyframes borderFlow{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
.about-text{font-size:1.2rem;color:rgba(255,255,255,0.9);margin-bottom:1.5rem;line-height:1.6;}
.features-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:2rem;margin:3rem 0;}
.feature-card{background:linear-gradient(135deg,rgba(255,255,255,0.15),rgba(255,255,255,0.05));backdrop-filter:blur(10px);border-radius:20px;padding:2rem;border:1px solid rgba(255,255,255,0.2);transition:all 0.4s ease;animation:cardSlideIn 0.6s ease forwards;opacity:0;transform:translateY(30px);}
@keyframes cardSlideIn{to{opacity:1;transform:translateY(0);}}
.feature-card:hover{transform:translateY(-8px);background:linear-gradient(135deg,rgba(255,255,255,0.2),rgba(255,255,255,0.1));}
.feature-icon{font-size:2.5rem;margin-bottom:1rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.feature-card h3{font-size:1.4rem;margin-bottom:1rem;color:#fbbf24;font-weight:600;}
.feature-card p{color:rgba(255,255,255,0.9);font-size:1rem;line-height:1.6;}
.benefits-list{margin:1rem 0;padding-left:1rem;}
.benefits-list li{color:rgba(255,255,255,0.8);margin-bottom:0.5rem;line-height:1.5;}
.highlight{color:#fbbf24;font-weight:600;}

/* Contact Section Styles */
.contact-section{margin:3rem 0;}
.contact-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem;margin-top:2rem;}
.contact-card{background:linear-gradient(135deg,rgba(16,185,129,0.9),rgba(5,150,105,0.7));backdrop-filter:blur(10px);border-radius:20px;padding:2.5rem;text-align:center;border:1px solid rgba(255,255,255,0.2);transition:all 0.4s ease;position:relative;overflow:hidden;}
.contact-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(135deg,#fbbf24,#f59e0b);animation:borderFlow 3s linear infinite;}
.contact-card:hover{transform:translateY(-8px);box-shadow:0 25px 50px -12px rgba(0,0,0,0.3);}
.contact-icon{font-size:3rem;margin-bottom:1.5rem;background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.contact-card h3{font-size:1.5rem;margin-bottom:1rem;color:white;font-weight:600;}
.contact-info{font-size:1.1rem;color:rgba(255,255,255,0.9);margin-bottom:1rem;}
.contact-link{display:inline-flex;align-items:center;gap:0.5rem;padding:1rem 2rem;background:rgba(255,255,255,0.2);color:white;text-decoration:none;border-radius:12px;font-weight:600;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.3);margin-top:1rem;}
.contact-link:hover{background:rgba(255,255,255,0.3);transform:translateY(-3px);}
.whatsapp-contact{background:linear-gradient(135deg,#25d366,#128c7e);border:1px solid rgba(37,211,102,0.5);}
.whatsapp-contact:hover{background:linear-gradient(135deg,#128c7e,#25d366);}
.email-contact{background:linear-gradient(135deg,#ea4335,#d93025);border:1px solid rgba(234,67,53,0.5);}
.email-contact:hover{background:linear-gradient(135deg,#d93025,#ea4335);}
.phone-contact{background:linear-gradient(135deg,#4285f4,#1a73e8);border:1px solid rgba(66,133,244,0.5);}
.phone-contact:hover{background:linear-gradient(135deg,#1a73e8,#4285f4);}

/* Business Hours */
.hours-list{list-style:none;padding:0;margin:1.5rem 0;}
.hours-list li{display:flex;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid rgba(255,255,255,0.1);}
.hours-list li:last-child{border-bottom:none;}
.hours-day{color:rgba(255,255,255,0.9);}
.hours-time{color:#fbbf24;font-weight:600;}

@media (max-width:768px){.topbar{flex-direction:column;padding:1rem;gap:1rem;}.mainnav{gap:0.5rem;flex-wrap:wrap;justify-content:center;}.container{margin:1rem auto;padding:0 1rem;}.features-grid{grid-template-columns:1fr;gap:1.5rem;}.contact-grid{grid-template-columns:1fr;}}
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
            <div class="brand-sub">Construction Materials Marketplace</div>
        </div>
    </div>
    <nav class="mainnav">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
    </nav>
</header>

<main class="container">
    <div class="about-card">
        <h1><i class="fas fa-info-circle"></i> About ConstructHub</h1>
        <p class="about-text">ConstructHub connects buyers and contractors with local suppliers of construction materials — bricks, cement, steel, tiles and more.</p>
    </div>

    <div class="features-grid">
        <!-- Row 1 -->
        <div class="feature-card" style="animation-delay:0.1s">
            <div class="feature-icon"><i class="fas fa-lightbulb"></i></div>
            <h3>The ConstructHub Vision</h3>
            <p>For constructing new houses, you need to buy various materials like <span class="highlight">bricks, cement, sand, steel, tiles, plumbing materials, electrical fittings, and more</span>. Traditionally, these are available in different places across the city.</p>
            <p>ConstructHub brings <span class="highlight">all construction materials together in one digital marketplace</span>, making the procurement process efficient and hassle-free.</p>
        </div>

        <div class="feature-card" style="animation-delay:0.2s">
            <div class="feature-icon"><i class="fas fa-users"></i></div>
            <h3>Target Market</h3>
            <p>ConstructHub serves a diverse range of customers in the construction ecosystem:</p>
            <div class="benefits-list">
                <li>🏢 <span class="highlight">Construction Companies</span> - Large-scale project requirements</li>
                <li>👷 <span class="highlight">Contractors & Builders</span> - Regular material procurement</li>
                <li>🏠 <span class="highlight">DIY Homeowners</span> - Home renovation and improvement</li>
                <li>🔨 <span class="highlight">Individual Builders</span> - Small to medium construction projects</li>
                <li>🏗️ <span class="highlight">Real Estate Developers</span> - Bulk material sourcing</li>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="feature-card" style="animation-delay:0.3s">
            <div class="feature-icon"><i class="fas fa-trophy"></i></div>
            <h3>Competitive Advantages</h3>
            <p>ConstructHub stands out in the market with unique differentiators:</p>
            <div class="benefits-list">
                <li>⚡ <span class="highlight">Time Efficiency</span> - 70% faster procurement process</li>
                <li>💵 <span class="highlight">Cost Savings</span> - Competitive pricing through multiple suppliers</li>
                <li>🛡️ <span class="highlight">Quality Assurance</span> - Verified and rated suppliers</li>
                <li>📱 <span class="highlight">Digital Convenience</span> - Mobile-first platform access</li>
                <li>🌍 <span class="highlight">Local Focus</span> - Tailored for regional market needs</li>
            </div>
        </div>

        <div class="feature-card" style="animation-delay:0.4s">
            <div class="feature-icon"><i class="fas fa-rocket"></i></div>
            <h3>Future Expansion</h3>
            <p>The platform has significant growth potential with planned features:</p>
            <div class="benefits-list">
                <li>🔧 <span class="highlight">Equipment Rental</span> - Construction tools and machinery</li>
                <li>👷‍♂️ <span class="highlight">Labor Services</span> - Skilled workforce marketplace</li>
                <li>📐 <span class="highlight">Architect Services</span> - Design and planning integration</li>
                <li>🏢 <span class="highlight">B2B Marketplace</span> - Business-to-business transactions</li>
                <li>🌐 <span class="highlight">Regional Expansion</span> - Multi-city and national growth</li>
            </div>
        </div>
    </div>

    <!-- Contact Us Section -->
    <div class="contact-section">
        <div class="about-card">
            <h1><i class="fas fa-address-book"></i> Contact Us</h1>
            <p class="about-text">Get in touch with us for any inquiries, support, or partnership opportunities. We're here to help you with all your construction material needs.</p>
            
            <div class="contact-grid">
                <!-- WhatsApp Contact -->
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp Business</h3>
                    <p class="contact-info">Quick responses for orders & inquiries</p>
                    <div class="contact-info">+91 8466973477</div>
                    <a href="https://wa.me/918466973477?text=Hi%20ConstructHub%2C%20I%20need%20help%20with%20construction%20materials" 
                       target="_blank" 
                       class="contact-link whatsapp-contact">
                        <i class="fab fa-whatsapp"></i> Start Chat on WhatsApp
                    </a>
                </div>

                <!-- Email Contact -->
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email Support</h3>
                    <p class="contact-info">Detailed inquiries & partnerships</p>
                    <div class="contact-info">support@constructhub.com</div>
                    <a href="mailto:support@constructhub.com?subject=Inquiry%20from%20ConstructHub%20Website" 
                       class="contact-link email-contact">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                </div>

                <!-- Phone Contact -->
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Phone Support</h3>
                    <p class="contact-info">Direct customer service</p>
                    <div class="contact-info">+91 98765 43210</div>
                    <a href="tel:8466973477" class="contact-link phone-contact">
                        <i class="fas fa-phone"></i> Call Now
                    </a>
                </div>

                <!-- Office Address -->
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                   <!-- <h3>Office Address</h3>
                    <p class="contact-info">Visit our headquarters</p>
                    <div class="contact-info">
                        ConstructHub Building<br>
                        123 Construction Street<br>
                        Industrial Area, City - 500001<br>
                        Andhra Pradesh, India
                    </div>
                    <div class="hours-list">
                        <li><span class="hours-day">Monday - Friday</span><span class="hours-time">9:00 AM - 6:00 PM</span></li>
                        <li><span class="hours-day">Saturday</span><span class="hours-time">10:00 AM - 4:00 PM</span></li>
                        <li><span class="hours-day">Sunday</span><span class="hours-time">Closed</span></li>
                    </div>
                </div>
            </div>-->

            <!-- Additional Contact Information -->
            <div style="margin-top: 3rem; text-align: center;">
                <h3 style="color: #fbbf24; margin-bottom: 1rem;">Other Ways to Connect</h3>
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; color: #fbbf24; margin-bottom: 0.5rem;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div style="font-weight: 600;">Customer Care</div>
                        <div style="color: rgba(255,255,255,0.8);">1800-123-4567</div>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; color: #fbbf24; margin-bottom: 0.5rem;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div style="font-weight: 600;">Live Chat</div>
                        <div style="color: rgba(255,255,255,0.8);">Available 24/7</div>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; color: #fbbf24; margin-bottom: 0.5rem;">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div style="font-weight: 600;">Delivery Support</div>
                        <div style="color: rgba(255,255,255,0.8);">+91 98765 43211</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
window.addEventListener('scroll', function() {
    const topbar = document.querySelector('.topbar');
    topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
    topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
});

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.feature-card, .contact-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});

// Add click tracking for contact links
document.querySelectorAll('.contact-link').forEach(link => {
    link.addEventListener('click', function() {
        const contactType = this.textContent.trim();
        console.log(`Contact method clicked: ${contactType}`);
        // You can add analytics tracking here
    });
});
</script>
</body>
</html>