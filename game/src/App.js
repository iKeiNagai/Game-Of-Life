import React, { useState, useRef } from 'react';
import './App.css';

function App() {
  const [user, setUser] = useState({
    username: 'Player',
    avatar: 'avatar.jpg',
    stats: {
      gamesPlayed: 0,
      timePlayed: 0,
    },
  });

  const timerRef = useRef(null);

  // Start game logic
  const handleStartGame = () => {
    setUser(prev => ({
      ...prev,
      stats: {
        ...prev.stats,
        gamesPlayed: prev.stats.gamesPlayed + 1,
      },
    }));

    // Timer setup
    timerRef.current = setInterval(() => {
      setUser(prev => ({
        ...prev,
        stats: {
          ...prev.stats,
          timePlayed: prev.stats.timePlayed + 1,
        },
      }));
    }, 60000); // Increment time by 1 minute
  };

  // Stop game logic
  const handleStopGame = () => {
    if (timerRef.current) {
      clearInterval(timerRef.current);
      timerRef.current = null;
    }
    console.log("Game stopped");
  };

  // Reset game state
  const handleResetGame = () => {
    setUser({
      username: 'PlayerOne',
      avatar: '/my-avatar.jpg',
      stats: {
        gamesPlayed: 0,
        timePlayed: 0,
      },
    });
  };

  // Pattern selector (mock functionality for now)
  const handlePatternChange = (event) => {
    console.log(`Pattern selected: ${event.target.value}`);
  };

  return (
    <div className="App">
      <h1>Conway's Game of Life</h1>
      <div className="dashboard">
        <img
          src={user.avatar}
          alt="Player Avatar"
          className="avatar"
          width="150"
          height="150"
        />
        <h2>{user.username}</h2>
        <div>
          <p><strong>Games Played:</strong> {user.stats.gamesPlayed}</p>
          <p><strong>Time Played (minutes):</strong> {user.stats.timePlayed}</p>
        </div>

        {/* Pattern selection dropdown */}
        <div>
          <label htmlFor="patternSelect">Select Pattern: </label>
          <select id="patternSelect" onChange={handlePatternChange}>
            <option value="glider">Glider</option>
            <option value="blinker">Blinker</option>
            <option value="block">Block</option>
          </select>
        </div>

        {/* Buttons */}
        <div className="buttons">
          <button
            onClick={handleStartGame}
            className="btn-start"
          >
            Start Game
          </button>
          <button
            onClick={handleStopGame}
            className="btn-stop"
          >
            Stop Game
          </button>
          <button
            onClick={handleResetGame}
            className="btn-reset"
          >
            Reset Game
          </button>
        </div>
      </div>
    </div>
  );
}

export default App;
