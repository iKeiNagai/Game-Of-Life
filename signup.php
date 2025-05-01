<?php
require_once 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

try{
    //prepares and executes query
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param("sss", $username, $email, $password);
    $statement->execute();

    $msg = "<p style='color: green'>Signup successful. <a href='login.html'>Login here</a></p>";
}catch(mysqli_sql_exception $e) {

    //checks for duplicates
    if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
        $msg = "<p style='color: red'>username or email already exists.</p>";
    }
}

//redirects user to same page
header("Location: signup.html?msg=". urlencode($msg));
exit();
?>