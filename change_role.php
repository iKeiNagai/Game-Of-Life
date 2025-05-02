<?php
session_start();
require_once 'db.php';

$currentrole = $_SESSION['role'];
$newrole = ($currentrole === 'user') ? 'admin' : 'user';

$_SESSION['role'] = $newrole;

$sql = "UPDATE users SET role = ? WHERE id = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("si",
    $newrole,
    $_SESSION['user_id']
);

$statement->execute();

header("Location: game.php");
exit();

?>