<?php
session_start();
require_once 'db.php'; // Connect to DB

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user session stats from DB using mysqli
$stmt = $conn->prepare("SELECT COUNT(*) as games_played, SUM(generations) as total_generations FROM game_sessions WHERE user_id = ?");
$stmt->bind_param("i", $user_id); // Bind the parameter
$stmt->execute();
$result = $stmt->get_result(); // Get the result
$stats = $result->fetch_assoc(); // Fetch data as associative array

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
    <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>

    <div class="dashboard">
        <p><strong>Games Played:</strong> <?= $games_played ?></p>
        <p><strong>Total Generations:</strong> <?= $total_generations ?></p>

        <a href="game.html"><button>▶️ Play Game</button></a>
        <a href="logout.php"><button>🚪 Logout</button></a>
    </div>
</body>
</html>
