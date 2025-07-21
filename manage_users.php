<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id AND role = 'user'");
}

$result = $conn->query("SELECT * FROM users WHERE role = 'user'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
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

        .delete-link {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .delete-link:hover {
            color: #c0392b;
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

    <h2>👥 Manage Registered Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a class="delete-link" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">🗑 Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a class="btn-back" href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
