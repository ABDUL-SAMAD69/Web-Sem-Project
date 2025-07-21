<?php
include 'includes/db.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; 

    
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "❌ Username or email already exists.";
    } else {
        // Insert user with plain password
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "✅ Registration successful. You can now login.";
        } else {
            $message = "❌ Error during registration.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-box {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 90%;
            max-width: 450px;
        }

        h2 {
            margin-bottom: 25px;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            background-color: #27ae60;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #219150;
            transform: scale(1.05);
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #1d6fa5;
        }

        .message {
            margin-bottom: 15px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>📝 User Registration</h2>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
        </form>

        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
