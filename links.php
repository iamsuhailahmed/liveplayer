<?php

// Your database connection details
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "update";

// Create a connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest M3U8 URL from the database
$sql = "SELECT link FROM links ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Check if there is a result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latestLink = $row['link'];
} else {
    $latestLink = "No links available.";
}

// Output JSON data
header('Content-Type: application/json');

// Convert the PHP array to JSON format
$linksData = [
    "link" => $latestLink
];

$jsonData = json_encode($linksData, JSON_PRETTY_PRINT);

// Output JSON data
echo $jsonData;
?>
