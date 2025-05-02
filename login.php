<?php
require_once 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$msg = "";

$sql = "SELECT * FROM users WHERE username = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("s",$username);
$statement->execute();
$result = $statement->get_result();

if($result-> num_rows == 1){
    $user = $result->fetch_assoc(); 
    
    if($password == $user['password']) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header("Location: game.php");
        exit();
    } else {
        $msg = "<p style='color:red'>Incorrect password</p>";
    }
} else {
    $msg = "<p style='color:red'>User not Found</p>";
}

header("Location: login.html?msg=" . urlencode($msg));
exit();
?>