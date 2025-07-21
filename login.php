<?php
include 'includes/db.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $stored_password, $role);
        $stmt->fetch();

        if ($password === $stored_password) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $message = "❌ Invalid email or password.";
        }
    } else {
        $message = "❌ No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        .login-box {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 25px;
            color: #2c3e50;
        }

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
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
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
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Login</h2>
        
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>

        <p>Not registered yet? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
