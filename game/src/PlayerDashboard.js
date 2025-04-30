import React from 'react';

const PlayerDashboard = ({ username, avatar, stats, onStartGame, onJoinGame }) => {
  return (
    <div className="p-4 rounded-xl shadow-lg bg-white space-y-4">
      <div className="flex items-center space-x-4">
        <img
          src={avatar}
          alt="Avatar"
          className="w-16 h-16 rounded-full border-2 border-blue-500"
        />
        <div>
          <h2 className="text-xl font-semibold">{username}</h2>
          <p className="text-gray-600">Games Played: {stats.gamesPlayed}</p>
          <p className="text-gray-600">Time Played: {stats.timePlayed} mins</p>
        </div>
      </div>

      <div className="flex space-x-4">
        <button
          onClick={onStartGame}
          className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
        >
          Start Game
        </button>
        <button
          onClick={onJoinGame}
          className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Join Game
        </button>
      </div>
    </div>
  );
};

export default PlayerDashboard;
