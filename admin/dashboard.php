<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Determine user type
$isAdmin = isset($_SESSION['admin']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $isAdmin ? "Admin" : "Dashboard"; ?> - ConstructHub</title>
    <link rel="stylesheet" href="<?php echo $isAdmin ? '../css/style.css' : 'css/style.css'; ?>">
</head>
<body>
<main class="container">
    <?php if ($isAdmin): ?>
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></p>
        <ul>
            <li><a href="add_seller.php">Add Seller</a></li>
            <li><a href="view_sellers.php">View Sellers</a></li>
            <li><a href="add_material.php">Add Material</a></li>
            <li><a href="view_materials.php">View Materials</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    <?php else: ?>
        <h1>User Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        <p><a href="logout.php">Logout</a></p>
    <?php endif; ?>
</main>
</body>
</html>
