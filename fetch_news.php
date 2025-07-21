<?php
header('Content-Type: application/json');

$apiKey = "c350f858071d45c97e69843b456bab79";
$url = "https://gnews.io/api/v4/top-headlines?lang=en&country=pk&max=10&apikey=" . $apiKey;

$response = file_get_contents($url);
echo $response;
