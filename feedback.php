<?php
session_start();
include('db_connect.php');

if(!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$message = '';

// Handle feedback submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $user_name = trim($_POST['user_name']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $material_bought = trim($_POST['material_bought']);
    $rating = intval($_POST['rating']);
    $feedback_text = trim($_POST['feedback_text']);

    if(empty($user_name) || empty($phone_number) || empty($address) || empty($material_bought) || empty($rating)) {
        $message = "❌ Please fill all required fields";
    } else {
        $sql = "INSERT INTO feedback (user_id, user_name, phone_number, address, material_bought, rating, feedback_text) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssis", $user_id, $user_name, $phone_number, $address, $material_bought, $rating, $feedback_text);

        if($stmt->execute()) {
            $message = "✅ Feedback submitted successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Get all feedback for display
$feedback_sql = "SELECT f.*, u.name as user_name FROM feedback f 
                 LEFT JOIN users u ON f.user_id = u.user_id 
                 ORDER BY f.created_at DESC";
$feedback_result = $conn->query($feedback_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback - ConstructHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            60% { transform: translateY(-3px); }
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
            font-size: 2.5rem;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: titleGlow 3s ease-in-out infinite alternate;
            text-align: center;
        }

        @keyframes titleGlow {
            from { filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.4)); }
            to { filter: drop-shadow(0 0 20px rgba(251, 191, 36, 0.8)); }
        }

        .feedback-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 968px) {
            .feedback-section {
                grid-template-columns: 1fr;
            }
        }

        .form-card, .table-card {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(59, 130, 246, 0.7));
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .form-card::before, .table-card::before {
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #f59e0b;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .rating-stars {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .star {
            font-size: 2rem;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .star:hover,
        .star.active {
            color: #fbbf24;
            transform: scale(1.2);
        }

        .btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
        }

        .message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
        }

        .success {
            background: rgba(16, 185, 129, 0.2);
            color: #a7f3d0;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .error {
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(220, 38, 38, 0.4);
        }

        .feedback-table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
            margin-top: 1rem;
        }

        .feedback-table th {
            background: rgba(251, 191, 36, 0.2);
            color: white;
            padding: 1.25rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid rgba(251, 191, 36, 0.3);
        }

        .feedback-table td {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
        }

        .feedback-table tr:hover td {
            background: rgba(255, 255, 255, 0.05);
        }

        .rating-stars-static {
            color: #fbbf24;
        }

        .no-feedback {
            text-align: center;
            padding: 2rem;
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
        }

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
            
            .container {
                margin: 1rem auto;
                padding: 0 1rem;
            }
            
            .form-card, .table-card {
                padding: 2rem;
            }
            
            .feedback-table {
                font-size: 0.9rem;
            }
            
            .feedback-table th,
            .feedback-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="construction-grid"></div>
    <div class="floating-icon" style="top: 10%; left: 5%;">🏗️</div>
    <div class="floating-icon" style="top: 30%; left: 80%; animation-delay: 2s;">🔨</div>
    <div class="floating-icon" style="top: 60%; left: 10%; animation-delay: 4s;">⚒️</div>

    <header class="topbar">
        <div class="brand">
            <span class="brand-emoji">🏗️</span>
            <div class="brand-title">CONSTRUCTHUB</div>
        </div>
        <nav class="mainnav">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="products.php"><i class="fas fa-boxes"></i> Products</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <main class="container">
        <h1><i class="fas fa-comments"></i> Customer Feedback</h1>

        <div class="feedback-section">
            <!-- Feedback Form -->
            <div class="form-card">
                <h2 style="margin-bottom: 2rem; color: white;"><i class="fas fa-edit"></i> Submit Your Feedback</h2>

                <?php if ($message): ?>
                    <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="user_name" class="form-control" placeholder="Your Name" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" required>
                    </div>

                    <div class="form-group">
                        <textarea name="address" class="form-control" placeholder="Your Address" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" name="material_bought" class="form-control" placeholder="Material Bought (e.g., Cement, Bricks, etc.)" required>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; color: white;">Rating:</label>
                        <div class="rating-stars" id="ratingStars">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>

                    <div class="form-group">
                        <textarea name="feedback_text" class="form-control" placeholder="Additional Feedback (Optional)"></textarea>
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            </div>

            <!-- Feedback Table -->
            <div class="table-card">
                <h2 style="margin-bottom: 2rem; color: white;"><i class="fas fa-list"></i> Recent Feedback</h2>

                <?php if($feedback_result && $feedback_result->num_rows > 0): ?>
                    <div style="overflow-x: auto;">
                        <table class="feedback-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Material</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($feedback = $feedback_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($feedback['user_name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($feedback['material_bought']); ?></td>
                                        <td>
                                            <div class="rating-stars-static">
                                                <?php 
                                                $rating = $feedback['rating'];
                                                for($i = 1; $i <= 5; $i++): 
                                                    echo $i <= $rating ? '★' : '☆';
                                                endfor; 
                                                ?>
                                                <small style="margin-left: 0.5rem;">(<?php echo $rating; ?>/5)</small>
                                            </div>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($feedback['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-feedback">
                        <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>No feedback submitted yet.</p>
                        <p>Be the first to share your experience!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Star rating functionality
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingInput');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;

                // Update stars appearance
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = this.getAttribute('data-rating');
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.style.color = '#fbbf24';
                    } else {
                        s.style.color = '#6b7280';
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const currentRating = ratingInput.value;
                stars.forEach(s => {
                    if (currentRating && s.getAttribute('data-rating') <= currentRating) {
                        s.style.color = '#fbbf24';
                    } else {
                        s.style.color = '#6b7280';
                    }
                });
            });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!ratingInput.value) {
                e.preventDefault();
                alert('Please select a rating');
                return false;
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const topbar = document.querySelector('.topbar');
            topbar.style.background = window.scrollY > 50 ? 'rgba(30,41,59,0.98)' : 'rgba(30,41,59,0.95)';
            topbar.style.padding = window.scrollY > 50 ? '0.8rem 2rem' : '1rem 2rem';
        });
    </script>
</body>
</html>