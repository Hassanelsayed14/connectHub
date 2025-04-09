<?php 
// feed.php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

if (isset($_SESSION['user_id'])) {
    // Fetch the user ID from the database using the session 'user_id'
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the query to get the user details
    $query = "SELECT id FROM users WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
}

$query = "SELECT users.user_name, posts.content, posts.created_at 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="feed.css">
</head>
<body>

<!-- Navigation Bar -->
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

<!-- Feed Section -->
<h1>Feed</h1>

<div class="feed">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <!-- Removed htmlspecialchars to allow HTML and JavaScript injection -->
                <h3><?php echo $post['user_name']; ?></h3>
                <span id="post-date"><?php echo $post['created_at']; ?></span>
                <p><?php echo $post['content']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available.</p>
    <?php endif; ?>
</div>
<footer>
        <p>&copy; 2024 ConnectHub. All rights reserved.</p>
    </footer>
</body>
</html>
