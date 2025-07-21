<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'user') {
        $user_id = $_SESSION['user_id'];
        $blog_id = $_POST['blog_id'];
        $rating = $_POST['rating'];
        $comment = trim($_POST['comment']);

        $stmt = $conn->prepare("INSERT INTO feedback (blog_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $blog_id, $user_id, $rating, $comment);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Feedback submitted successfully!');</script>";
        } else {
            echo "<script>alert('❌ Error submitting feedback.');</script>";
        }
    } else {
        echo "<script>alert('❌ Please login to leave feedback.');</script>";
    }
}


$result = $conn->query("SELECT b.*, u.username 
                        FROM blogs b 
                        LEFT JOIN users u ON b.created_by = u.id 
                        ORDER BY b.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }

        .btn-profile {
            display: inline-block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-profile:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .blog-box {
            background: white;
            padding: 20px;
            margin: 30px auto;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .blog-box h3 {
            margin-top: 0;
            color: #34495e;
        }

        .blog-box p {
            color: #555;
        }

        small {
            display: block;
            margin-top: 10px;
            color: #999;
        }

        .stars {
            cursor: pointer;
            font-size: 22px;
            color: lightgray;
            display: inline-block;
        }

        .stars .star.selected {
            color: gold;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        button[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        hr {
            margin: 40px 0;
        }
    </style>
</head>
<body>
    <h1>Welcome</h1>
    <h2>📝 Latest Blogs</h2>

    <div style="text-align: center;">
        <a href="profile.php" class="btn-profile">👤 My Profile</a>
    </div>

    <?php while($row = $result->fetch_assoc()): ?>
        <div class="blog-box">
            <h3><?= htmlspecialchars($row['title']) ?> (<?= htmlspecialchars($row['category']) ?>)</h3>
            <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <small>Posted by: <?= htmlspecialchars($row['username'] ?? 'Unknown') ?> on <?= $row['created_at'] ?></small>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'user'): ?>
                <form method="POST" action="">
                    <input type="hidden" name="blog_id" value="<?= $row['id'] ?>">

                    <!-- Rating -->
                    <div class="rating">
                        <label>Rate this blog:</label>
                        <div class="stars">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                        <input type="hidden" name="rating" class="rating-input" value="0">
                    </div>

                    <!-- Comment -->
                    <textarea name="comment" placeholder="Write your feedback here..." required></textarea><br>
                    <button type="submit" name="submit_feedback">Submit Feedback</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Login</a> to leave feedback.</p>
            <?php endif; ?>
        </div>
        <hr>
    <?php endwhile; ?>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const allStars = document.querySelectorAll(".stars");

            allStars.forEach(starGroup => {
                const stars = starGroup.querySelectorAll(".star");
                const input = starGroup.parentElement.querySelector(".rating-input");

                stars.forEach(star => {
                    star.addEventListener("click", () => {
                        const value = star.getAttribute("data-value");
                        input.value = value;

                        stars.forEach(s => {
                            s.classList.toggle("selected", s.getAttribute("data-value") <= value);
                        });
                    });
                });
            });
        });
    </script>
</body>
</html>
