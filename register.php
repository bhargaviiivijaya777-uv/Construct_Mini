<?php
include 'db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $contact_number = trim($_POST['contact_number']);
    $address = trim($_POST['address']);

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        $message = "❌ Please fill all required fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email format";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_sql = "SELECT user_id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "❌ Email already registered";
        } else {
            // Insert new user
            $sql = "INSERT INTO users (name, email, password, user_type, contact_number, address) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $email, $hashed_password, $user_type, $contact_number, $address);

            if ($stmt->execute()) {
                $message = "✅ Registration successful! You can now login.";
                // Clear form
                $name = $email = $contact_number = $address = '';
            } else {
                $message = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - ConstructHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .required::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <h2>Register for ConstructHub</h2>
    <form method="POST">
        <label class="required">Full Name</label>
        <input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
        
        <label class="required">Email</label>
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        
        <label class="required">Password</label>
        <input type="password" name="password" required>
        
        <label class="required">User Type</label>
        <select name="user_type" required>
            <option value="">Select User Type</option>
            <option value="customer">Customer (Buyer)</option>
            <option value="vendor">Vendor (Seller)</option>
        </select>
        
        <label>Contact Number</label>
        <input type="tel" name="contact_number" value="<?php echo isset($contact_number) ? htmlspecialchars($contact_number) : ''; ?>" placeholder="Optional">
        
        <label>Address</label>
        <textarea name="address" placeholder="Optional"><?php echo isset($address) ? htmlspecialchars($address) : ''; ?></textarea>
        
        <button type="submit">Register</button>
    </form>
    
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <p style="text-align: center;">Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>