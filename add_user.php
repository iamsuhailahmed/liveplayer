<?php
// Hash the password
$password = password_hash('P@kistan786', PASSWORD_DEFAULT);

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

// Insert the user into the database
$sql = "INSERT INTO users (username, password) VALUES ('admin', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "User added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
