<?php
$host = "127.0.0.1:3307"; 
$db = "web_project_db";
$user = "root";
$pass = "";


$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
