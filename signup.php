<?php
require_once 'db.php'; 

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];  

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password);  

if ($stmt->execute()) {
    $msg = "Signup successful. You can now <a href='login.html'>login</a>.";
} else {
    $msg = "Error: Could not create the account. Please try again.";
}

header("Location: signup.html?msg=" . urlencode($msg));
exit();
?>
