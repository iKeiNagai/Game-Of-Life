<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $data = json_decode(file_get_contents("php://input"), true); 
  if (!$data) exit();

  header('Content-Type: application/json');
  echo json_encode(['received' => $data]);

  $sql = "INSERT INTO game_sessions (pattern_name, status, generation_count, created_at, ended_at, user_id) VALUES (?, ?, ?, ?, ?, ?)";
  $statement = $conn->prepare($sql);
  $statement->bind_param("ssissi",
    $data['pattern_name'],
    $data['status'],
    $data['generation_count'],
    $data['created_at'],
    $data['ended_at'],
    $_SESSION['user_id']
  );

  $statement->execute();
  exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Conway's Game of Life</title>
  <link rel="stylesheet" href="style.css"/>
  
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
  <div id="gamecontainer">
    <div id="grid-container"></div>
    <div class="box">
      <h1 class="title">The Game of Life</h1>
      <p id="generationCounter">Generation: 0</p>
      <button onclick="startGame()" >Start Game</button>
      <button onclick="stopGame()" >Stop Game</button>
      <button onclick="nextGeneration()">Next Generation</button>
      <button onclick="fastForward(23)"> +23 Generations</button>
      <button onclick="resetGrid()">Reset</button>
      <button onclick="saveGame()">Save Result</button>
      <select id="patternSelect" onchange="loadPattern()">
        <option value="block"> Block</option>
        <option value="boat"> Boat</option>
        <option value="beehive"> Beehive</option>
        <option value="blinker"> Blinker</option>
        <option value="beacon"> Beacon</option>
      </select>
    </div>
  </div>

  <script src="script.js"></script>

</body>
</html>
