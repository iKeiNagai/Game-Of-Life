<?php
require_once 'db.php'; // Include database connection file

// Get POST data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];  // No hashing

// Prepare and execute SQL query to insert data into users table
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password);  // Storing password as plain text

if ($stmt->execute()) {
    // Successfully created the user
    $msg = "Signup successful. You can now <a href='login.html'>login</a>.";
} else {
    // Error: Failed to create user
    $msg = "Error: Could not create the account. Please try again.";
}

// Redirect user with the message
header("Location: signup.html?msg=" . urlencode($msg));
exit();
?>
