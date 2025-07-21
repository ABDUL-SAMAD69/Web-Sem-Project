<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$message = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM blogs WHERE id = $id");
    $message = "🗑 Blog deleted successfully.";
}


$edit_id = isset($_GET['edit']) ? $_GET['edit'] : null;
$edit_data = null;

if ($edit_id) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_blog'])) {
    $blog_id = $_POST['blog_id'];
    $new_content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE blogs SET content = ? WHERE id = ?");
    $stmt->bind_param("si", $new_content, $blog_id);

    if ($stmt->execute()) {
        $message = "✅ Blog updated successfully.";
        // Reset edit state
        $edit_id = null;
        $edit_data = null;
    } else {
        $message = "❌ Failed to update blog.";
    }
}

$result = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .edit-form {
            margin-top: 30px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        textarea {
            width: 100%;
            height: 120px;
            margin-top: 8px;
            padding: 8px;
        }
        button {
            padding: 10px 18px;
            background: #2980b9;
            color: white;
            border: none;
            margin-top: 10px;
            border-radius: 5px;
        }
        .msg {
            background: #eafaf1;
            border-left: 6px solid green;
            padding: 10px;
            margin-bottom: 15px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
      }

        .back-btn:hover {
            background-color: #219150;
            transform: translateY(-2px);
      }

        
    </style>
</head>
<body>

<h2>🛠 Manage Blogs</h2>

<?php if ($message): ?>
    <div class="msg"><?= $message ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>">✏ Edit</a> |
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this blog?')">🗑 Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if ($edit_data): ?>
    <div class="edit-form">
        <h3>Edit Blog Content: <i><?= htmlspecialchars($edit_data['title']) ?></i></h3>
        <form method="POST">
            <input type="hidden" name="blog_id" value="<?= $edit_data['id'] ?>">
            <textarea name="content" required><?= htmlspecialchars($edit_data['content']) ?></textarea><br>
            <button type="submit" name="update_blog">Update Blog</button>
        </form>
    </div>
<?php endif; ?>

<br><br>
<a href="dashboard.php" class="back-btn">Back to Dashboard</a>


</body>
</html>
