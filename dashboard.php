<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
            margin: 0;
        }

        .dashboard-box {
            background: #f8f8f8;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
        }

        a.dashboard-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        a.dashboard-btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .logout-link {
            margin-top: 30px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .logout-link:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="dashboard-box">
        <h2>👑 Welcome Admin, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

        <ul>
            <li><a class="dashboard-btn" href="add_blogs.php">➕ Add New Blog</a></li>
            <li><a class="dashboard-btn" href="manage_blogs.php">📝 Manage Blogs</a></li>
            <li><a class="dashboard-btn" href="view_feedback.php">💬 View User Feedback</a></li>
            <li><a class="dashboard-btn" href="manage_users.php">👥 Manage Users</a></li>
        </ul>

        <a class="logout-link" href="../logout.php">🚪 Logout</a>
    </div>
</body>
</html>
