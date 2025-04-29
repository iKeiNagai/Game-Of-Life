<?php
$host = "localhost";
$user = "your_username";
$pass = "your_username";
$dbname = "your_username";

$conn = new mysqli($host, $user, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$msg = "";

//prepare,execute and get results
$sql = "SELECT * FROM users WHERE username = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("s",$username);
$statement->execute();
$result = $statement->get_result();

if($result-> num_rows == 1){
    $user = $result->fetch_assoc(); //turns results into arr
    
    if($password == $user['password']) {
        header("Location: game.html");
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