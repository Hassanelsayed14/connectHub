<?php
session_start();
include("connection.php"); // Connect to the database
include("functions.php"); // Include any utility functions

// Fetch the user ID from the session (optional)
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
} else {
    header("Location: login.php");
    die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Posts</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="search.css">
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

<div class="container">
    <h1>Search Posts</h1>
    
    <!-- Search Form -->
    <form method="GET" action="search.php">
        <input type="text" name="query" placeholder="Search for posts" class="search-box" required>
        <button type="submit" class="submit">Search</button>
    </form>

    <?php
    // Check if there's a search query
    if (isset($_GET['query'])) {
        // Get the search query and sanitize it
        $query = $_GET['query'];
        
        // Search in the 'posts' table for matching content
        $sql = "SELECT * FROM posts WHERE content LIKE '%$query%'";
        $result = mysqli_query($con, $sql);

        echo '<div class="search-results">';
        
        // Check if there are results
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Search Results for '$query'</h2>";
            
            // Display each matching post
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>" . htmlspecialchars($row['content']) . "</p>";
            }
        } else {
            echo "<p class='error'>No results found for '$query'.</p>";
        }

        echo '</div>';
    }
    ?>
</div>

</body>
</html>
