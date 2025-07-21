<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$result = $conn->query("SELECT feedback.id, users.username, blogs.title, feedback.rating, feedback.comment
                        FROM feedback
                        JOIN users ON feedback.user_id = users.id
                        JOIN blogs ON feedback.blog_id = blogs.id");

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Feedback</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background-color: #f5f5f5;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:hover {
            background-color: #f0f8ff;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <h2>📋 User Feedback</h2>

    <table>
        <tr>
            <th>User</th>
            <th>Blog</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= $row['rating'] ?>/5</td>
                <td><?= htmlspecialchars($row['comment']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a class="btn-back" href="dashboard.php">Back to Dashboard</a>

</body>
</html>
