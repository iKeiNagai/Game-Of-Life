<?php
session_start();
require_once 'db.php';

$orderByGames = isset($_GET['sort']) && $_GET['sort'] === 'games' ? 'ORDER BY game_count DESC' : '';

//query users
$query = "
    SELECT users.*, COUNT(game_sessions.id) AS game_count
    FROM users
    LEFT JOIN game_sessions ON users.id = game_sessions.user_id
    GROUP BY users.id
    $orderByGames
";
$users = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        table, th, td { 
            border: 1px solid black; 
            border-collapse: collapse; 
            padding: 8px; 
        }
    </style>
</head>
<body>
    <h2>Users</h2>
    <button onclick="window.location.href='?sort=games';">Sort by Most Games</button>
    <button onclick="window.location.href='?';">Sort by UserID</button>
    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Games</th><th>Action</th>
        </tr>
        <?php while($user = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['game_count'] ?></td>
                <td>Delete</td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>