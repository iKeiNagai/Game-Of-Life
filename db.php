<?php
// Database connection credentials (for admin use in your PHP script)
$host = "localhost";
$user = "root";  // or "your_username" (with appropriate permissions)
$pass = "";      // Empty if using XAMPP, or the password you set for 'root'
$dbname = "lifegame";

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
