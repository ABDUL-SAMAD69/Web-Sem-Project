<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO blogs (title, category, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $category, $content);

    if ($stmt->execute()) {
        $message = "✅ Blog added successfully.";
    } else {
        $message = "❌ Error adding blog.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blog</title>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
        }

        .form-box {
            background: #f9f9f9;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        button,
        .back-button {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover,
        .back-button:hover {
            background-color: #219150;
            transform: scale(1.03);
        }

        .message {
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>📝 Add New Blog</h2>

        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="category" placeholder="Category" required>
            <textarea name="content" placeholder="Blog Content" rows="6" required></textarea>
            <button type="submit">Add Blog</button>
        </form>

        <a class="back-button" href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
