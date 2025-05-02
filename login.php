<?php
require_once 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$msg = "";

// Prepare and execute SQL query to fetch user data
$sql = "SELECT * FROM users WHERE username = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("s", $username);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc(); // Get the user data
    
    // Compare the plain text password
    if ($password == $user['password']) {
        // Set session variables for the logged-in user
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect to the game page
        header("Location: game.php");
        exit();
    } else {
        $msg = "<p style='color:red'>Incorrect password</p>";
    }
} else {
    $msg = "<p style='color:red'>User not found</p>";
}

header("Location: login.html?msg=" . urlencode($msg));
exit();
?>
