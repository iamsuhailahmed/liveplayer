<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Your database connection details
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "update";

    // Create a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Authenticate user
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        }
    }

    // If authentication fails, redirect to login page
    header('Location: login.php');
    exit();

    $conn->close();
}
?>
