<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch feedback
$stmt = $conn->prepare("SELECT f.rating, f.comment, b.title 
                        FROM feedback f
                        JOIN blogs b ON f.blog_id = b.id
                        WHERE f.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 30px;
        }

        .profile-box {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        p {
            text-align: center;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 14px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <h2>👤 Welcome, <?= htmlspecialchars($username) ?></h2>
    <p>This is your profile page. Below is the feedback you've submitted:</p>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Blog Title</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['rating'] ?>/5</td>
                    <td><?= htmlspecialchars($row['comment']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>You haven't submitted any feedback yet.</p>
    <?php endif; ?>

    <div class="actions">
        <a href="blogs.php" class="btn">⬅ Back to Blogs</a>
        <a href="logout.php" class="btn">🚪 Logout</a>
    </div>
</div>

</body>
</html>
