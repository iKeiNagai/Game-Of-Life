<?php
session_start();

//check if valid session
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
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
