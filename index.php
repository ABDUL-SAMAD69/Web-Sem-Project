<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to News & Blog Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h1 {
            font-size: 42px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 40px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 18px;
            margin: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .links {
            margin-top: 30px;
            font-size: 16px;
        }

        .links a {
            margin: 0 10px;
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: #1c6ea4;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Welcome to News & Blog Portal🤗</h1>
    <p>Your hub for latest news and blogs🧠</p>

    <a href="blogs.php" class="btn">📖 Read Blogs</a>
    <a href="news.php" class="btn">📰 View Latest News</a>

    <div class="links">
        <a href="login.php">Login</a> | 
        <a href="register.php">Signup</a>
    </div>

</body>
</html>
