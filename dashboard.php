<?php
session_start();
include 'functions.php';

// Check if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if the form is submitted for adding a new link
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_link'])) {
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

    // Sanitize and get the new link
    $newLink = $conn->real_escape_string($_POST['new_link']);

    // Get date and time
    $dateTime = date('Y-m-d H:i:s');

    // Get user's IP address (IPv4 only)
    $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

    // Replace 'YOUR_ACTUAL_API_KEY' with your ipstack API key
    $ipstackApiKey = '1240f406e1cbf3b5d8e0ee342f108e8b';
    $ipLocation = getIpLocation($userIp, $ipstackApiKey);

    // Insert the new link into the database with additional information
    $sql = "INSERT INTO links (link, date_time, user_ip, ip_location) VALUES ('$newLink', '$dateTime', '$userIp', '$ipLocation')";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Link added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error adding link: ' . $conn->error . '</div>';
    }

    // Close the connection
    $conn->close();
}

// Fetch links from the database
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

// Fetch links from the database
$sql = "SELECT * FROM links";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Content -->
<div class="container mt-5">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Form for Updating Link -->
    <form method="post" action="dashboard.php" class="mb-4">
        <div class="form-group">
            <label for="new_link">New M3U8 Url:</label>
            <input type="text" class="form-control" name="new_link" id="new_link" required>
        </div>
        <button type="submit" class="btn btn-primary">OK</button>
    </form>

    <!-- Display Links in a Table -->
    <h3>Links</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Link</th>
                <th>Date & Time</th>
                <th>User IP</th>
                <th>IP Location</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Output links in the table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['link']}</td>";

                // Check if date_time, user_ip, and ip_location keys exist in the $row array
                if (isset($row['date_time'])) {
                    echo "<td>{$row['date_time']}</td>";
                } else {
                    echo "<td>Not Available</td>";
                }

                if (isset($row['user_ip'])) {
                    echo "<td>{$row['user_ip']}</td>";
                } else {
                    echo "<td>Not Available</td>";
                }

                if (isset($row['ip_location'])) {
                    echo "<td>{$row['ip_location']}</td>";
                } else {
                    echo "<td>Not Available</td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JavaScript dependencies via CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
