<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if the new link is provided
if (isset($_POST['new_link'])) {
    // Your database connection details
    $servername = "your_database_server";
    $dbusername = "your_database_username";
    $dbpassword = "your_database_password";
    $dbname = "your_database_name";

    // Create a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and get the new link
    $newLink = $conn->real_escape_string($_POST['new_link']);

    // Insert the new link into the database
    $sql = "INSERT INTO links (link) VALUES ('$newLink')";
    if ($conn->query($sql) === TRUE) {
        echo '<p class="text-center">Link added successfully!</p>';
    } else {
        echo '<p class="text-center">Error adding link: ' . $conn->error . '</p>';
    }

    // Close the connection
    $conn->close();
} else {
    echo '<p class="text-center">Please provide a new link.</p>';
}

// Add "Home" and "View Link" buttons with redirects
echo '<br><a href="dashboard.php" class="btn btn-primary mx-2">Home</a>';
echo '<a href="links.php" class="btn btn-danger mx-2">View Links</a>';
?>
