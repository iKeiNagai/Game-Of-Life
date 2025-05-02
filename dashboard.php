<?php
session_start();
require_once 'db.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$sql = "SELECT COUNT(*) as games_played, SUM(generation_count) as total_generations FROM game_sessions WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result(); 
$stats = $result->fetch_assoc(); 

$games_played = $stats['games_played'] ?? 0;
$total_generations = $stats['total_generations'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Conway's Game of Life</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="navbar">
        <span><?php echo "Role: " . $_SESSION['role']; ?></span>
        <?php if($_SESSION['role'] === 'admin') : ?>
        <button onclick="window.location.href='admin.php'">Manage Users</button>
        <?php endif; ?>
        <button onclick="window.location.href='dashboard.php'">Dashboard</button>
        <button onclick="window.location.href='game.php'">Game</button>
        <button onclick="window.location.href='change_role.php'">Change role</button>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>

    <div class="dashboard">
        <p><strong>Games Played:</strong> <?= $games_played ?></p>
        <p><strong>Total Generations:</strong> <?= $total_generations ?></p>

    </div>
</body>
</html>
