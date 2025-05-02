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
            
            <?php
                $sql = "
                    SELECT * FROM game_sessions 
                    WHERE user_id = {$user['id']}";
                $sessions = mysqli_query($conn,$sql);

                if (mysqli_num_rows($sessions) > 0):
                    while($session = mysqli_fetch_assoc($sessions)):
            ?>
            
            <tr>
                <td colspan="4"> 
                    Pattern: <?= $session['pattern_name'] ?>
                    Status: <?= $session['status'] ?>
                    Gen: <?= $session['generation_count'] ?>
                </td>
                <td>
                    Start:<span class="format-datetime" data-datetime="<?= $session['created_at'] ?>"></span><br> 
                    End:<span class="format-datetime" data-datetime="<?= $session['ended_at'] ?>"></span>
                </td>
                <td>DELETE/UPDATE</td>
            </tr>

            <?php endwhile; endif;?>

        <?php endwhile;?>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const formatDates = document.querySelectorAll('.format-datetime');

        formatDates.forEach(el => {
            const raw = el.dataset.datetime;
            const date = new Date(raw);

            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const yy = String(date.getFullYear()).slice(2);
            const hh = String(date.getHours()).padStart(2, '0');
            const min = String(date.getMinutes()).padStart(2, '0');

            el.textContent = `${mm}/${yy} ${hh}:${min}`;
        });
    });
    </script>
</body>
</html>