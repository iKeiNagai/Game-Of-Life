# Game-Of-Life

This project is based on Conway's Game of Life, a cellular automaton that uses simple rules to generate complex patterns.

Users can create accounts, log in, interact with the game, save game sessions, and view their progress. An admin panel is provided for managing users and game sessions.

## Technologies Used

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Server: Codd (GSU)

## Features

1. Homepage

    - Welcomes user with an introduction to Conway's Game of Life
    - Includes options to log in or sign up

2. User Authentication

    - New users can create an account
    - Registered users can log in using credentials

3. Game

    - Provides an interactive grid for Conway's Game of Life.
    - Users can:
        - Start and stop the game
        - Reset the grid
        - Run the next generations
        - Save session metadata with custom pattern name

4. Dashboard

    - Displays a summary of games played and generations

5. Admin Panel

    - Accesible only to admin users
    - Admins can:
        - View or Delete user accounts
        - View, Edit, or Delete game session records