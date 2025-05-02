<?php
session_start();
require_once 'db.php';

$currentUser = $_SESSION['user_id'];
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


//delete user
if(isset($_POST['delete_user'])){
    $userId = (int)$_POST['user_id'];
    $sql = "DELETE FROM users WHERE id = $userId";
    mysqli_query($conn, $sql);
}

//delete session
if (isset($_POST['delete_session'])) {
    $sessionId = (int)$_POST['session_id'];
    $sql = "DELETE FROM game_sessions WHERE id = $sessionId";
    mysqli_query($conn, $sql);
}

if (isset($_POST['update_pattern'])) {
    $sessionId = (int)$_POST['session_id'];
    $pattern = mysqli_real_escape_string($conn, $_POST['pattern_name']);
    mysqli_query($conn, "UPDATE game_sessions SET pattern_name = '$pattern' WHERE id = $sessionId");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
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
    
    <div class="container">
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
                    <td>
                        <?php if ( $currentUser != $user['id']): ?>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button name="delete_user" onclick="return confirm('Delete user?')">Delete</button>
                            </form>
                        <?php endif;?>
                    </td>
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
                    <td colspan="4" class="session"> 
                        <b> Pattern:</b> <span id="pattern-name-<?= $session['id'] ?>" > <?= $session['pattern_name'] ?></span>

                        <b> Status: </b> <?= $session['status'] ?>
                        <b> Gen: </b> <?= $session['generation_count'] ?>
                    </td>
                    <td>
                        Start:<span class="format-datetime" data-datetime="<?= $session['created_at'] ?>"></span><br> 
                        End:<span class="format-datetime" data-datetime="<?= $session['ended_at'] ?>"></span>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="session_id" value="<?= $session['id'] ?>">
                            <button name="delete_session" onclick="return confirm('Delete session?')">Delete</button>
                        </form>

                        <button onclick="updatePattern(<?= $session['id'] ?>)">Update</button>
                        <form id="update-form-<?= $session['id'] ?>" method="POST" style="display:none;">
                            <input type="hidden" name="session_id" value="<?= $session['id'] ?>">
                            <input type="hidden" name="pattern_name" id="pattern-input-<?= $session['id'] ?>">
                            <input type="hidden" name="update_pattern" value="1">
                        </form>
                    </td>
                </tr>

                <?php endwhile; endif;?>

            <?php endwhile;?>
        </table>
    </div>
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

    function updatePattern(sessionId) {
        const span = document.getElementById('pattern-name-' + sessionId);
        const current = span.innerText;
        const newPattern = prompt("Enter new pattern name:", current);
        if (newPattern !== null && newPattern.trim() !== "") {
            document.getElementById('pattern-input-' + sessionId).value = newPattern;
            document.getElementById('update-form-' + sessionId).submit();
        }
    }
    </script>
</body>
</html>