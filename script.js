const rows = 15;
const cols = 15;
let grid = [];
let interval = null;

const gridContainer = document.getElementById("grid-container");

function createGrid() {
  gridContainer.innerHTML = "";
  grid = [];

  for (let r = 0; r < rows; r++) {
    let row = [];
    for (let c = 0; c < cols; c++) {
      const cell = document.createElement("div");
      cell.classList.add("cell");
      cell.dataset.row = r;
      cell.dataset.col = c;
      cell.addEventListener("click", toggleCell);
      gridContainer.appendChild(cell);
      row.push(0);
    }
    grid.push(row);
  }
}

function toggleCell(e) {
  const cell = e.target;
  const r = parseInt(cell.dataset.row);
  const c = parseInt(cell.dataset.col);
  grid[r][c] = grid[r][c] ? 0 : 1;
  cell.classList.toggle("alive");
}

function getNeighbors(r, c) {
  let count = 0;
  for (let i = -1; i <= 1; i++) {
    for (let j = -1; j <= 1; j++) {
      if (i === 0 && j === 0) continue;
      const nr = r + i;
      const nc = c + j;
      if (nr >= 0 && nr < rows && nc >= 0 && nc < cols) {
        count += grid[nr][nc];
      }
    }
  }
  return count;
}

function nextGeneration() {
  const next = grid.map(arr => [...arr]);

  for (let r = 0; r < rows; r++) {
    for (let c = 0; c < cols; c++) {
      const alive = grid[r][c];
      const neighbors = getNeighbors(r, c);

      if (alive && (neighbors < 2 || neighbors > 3)) {
        next[r][c] = 0;
      } else if (!alive && neighbors === 3) {
        next[r][c] = 1;
      }
    }
  }

  grid = next;
  updateGrid();
}

function updateGrid() {
  const cells = document.querySelectorAll(".cell");
  cells.forEach(cell => {
    const r = parseInt(cell.dataset.row);
    const c = parseInt(cell.dataset.col);
    cell.classList.toggle("alive", grid[r][c] === 1);
  });
}

function startGame() {
  if (!interval) {
    interval = setInterval(nextGeneration, 200);
  }
}

function stopGame() {
  clearInterval(interval);
  interval = null;
}

function resetGrid() {
  stopGame();
  createGrid();
}

createGrid();


function fastForward(n) {
  for (let i = 0; i < n; i++) {
    nextGeneration();
  }
}

function loadPattern() {
  resetGrid();
  const pattern = document.getElementById("patternSelect").value;
  const midRow = Math.floor(rows / 2);
  const midCol = Math.floor(cols / 2);

  const patterns = {
    block: [[0,0],[0,1],[1,0],[1,1]],
    boat: [[0,0],[0,1],[1,0],[1,2],[2,1]],
    beehive: [[0,1],[0,2],[1,0],[1,3],[2,1],[2,2]],
    blinker: [[0,0],[0,1],[0,2]],
    beacon: [[0,0],[0,1],[1,0],[1,1],[2,2],[2,3],[3,2],[3,3]],
  };

  const cells = patterns[pattern];
  if (!cells) return;

  cells.forEach(([r, c]) => {
    const newR = midRow + r;
    const newC = midCol + c;
    if (newR < rows && newC < cols) {
      grid[newR][newC] = 1;
      const cell = document.querySelector(`.cell[data-row='${newR}'][data-col='${newC}']`);
      if (cell) cell.classList.add("alive");
    }
  });
}
