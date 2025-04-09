<?php
// game.php

session_start();
include("connection.php");
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

$response = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['url'])) {
    $url = $_POST['url'];
    $response = @file_get_contents($url); // SSRF vulnerability for demonstration
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play The Game</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="game.css">
    
</head>
<body>
<nav class="navbar">
    <a class="nav-brand" href="home.php">ConnectHub</a>
    <div class="nav-links">
        <a href="admin.php">Admin</a>
        <a href="feed.php">Feed</a>
        <a href="search.php">Search</a>
        <a href="settings.php">Settings</a>
        <a href="profile.php?id=<?php echo $id; ?>">Profile</a>
        <a href="logout.php">Logout</a>
        </div>
    </nav>
    <h1>Play The Ultimate Puzzle Game</h1>
    <div class="game-container">
        <p>Enter a URL below to unlock hidden content and solve the puzzle! Be careful where you explore.</p>

        <form method="POST" action="game.php">
            <label for="url">Enter URL:</label>
            <input type="text" name="url" id="url" placeholder="http://example.com" required>
            <button type="submit">Submit</button>
        </form>

        <?php if (!empty($response)): ?>
            <div class="game-response">
                <h2>Response from the URL:</h2>
                <pre><?php echo htmlspecialchars($response); ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
