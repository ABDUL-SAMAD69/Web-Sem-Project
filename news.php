<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Latest News</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7fa;
            padding: 40px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin: 0 10px 30px 10px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        #news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .news-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            transition: transform 0.2s;
        }

        .news-card:hover {
            transform: scale(1.02);
        }

        .news-card img {
            width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .news-card h3 {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }

        .news-card p {
            font-size: 14px;
            color: #555;
        }

        .news-card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
        }

        .news-card a:hover {
            text-decoration: underline;
        }

        #loader {
            display: none;
            text-align: center;
            margin: 30px 0;
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<body>

    <h2>📰 Latest News</h2>

    <div style="text-align: center;">
        <button class="btn" onclick="fetchNews()">📡 Fetch Latest News</button>
        <a href="index.php" class="btn">🏠 Back to Home</a>
    </div>

    <div id="loader">
        <div class="spinner"></div>
        <p>Loading news...</p>
    </div>

    <div id="news-container"></div>

    <script>
        function fetchNews() {
            document.getElementById("loader").style.display = "block";
            document.getElementById("news-container").innerHTML = "";

            fetch("api/fetch_news.php")
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("news-container");
                    document.getElementById("loader").style.display = "none";
                    container.innerHTML = "";

                    data.articles.forEach(article => {
                        container.innerHTML += `
                            <div class="news-card">
                                <h3>${article.title}</h3>
                                <img src="${article.image}" alt="News Image">
                                <p>${article.description}</p>
                                <a href="${article.url}" target="_blank">Read more ➜</a>
                            </div>
                        `;
                    });
                })
                .catch(err => {
                    alert("❌ Failed to fetch news.");
                    console.error(err);
                    document.getElementById("loader").style.display = "none";
                });
        }
    </script>

</body>
</html>
