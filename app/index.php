<?php
// index.php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

if (isset($_SESSION['user_id'])) {
    // Fetch the user ID from the database using the session 'user_id'
    $user_id = $_SESSION['user_id'];
    
    

    // Prepare and execute the query to get the user details
    $query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);
    $username = $user_data['user_name'];
    //................................................................
    $query = "SELECT id FROM users WHERE user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);
    $id= $user_data["id"];
    // echo $id;


    // $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    // $result = mysqli_query($con, $query);
    // $user_id = mysqli_fetch_assoc($result);
} else {
    header("Location: home.php");
    die;
}
?>

<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ConnectHub</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        <div class="hero-section">
        <section class="welcome-section">
            <h1>Welcome back, <?php echo htmlspecialchars($username); ?>!</h1>
        </section>

        <section class="quick-stats">
            <div class="stat-card">
                <div class="stat-number">
                <?php
$query = "SELECT COUNT(*) FROM posts WHERE user_id = ?";
$stmt = $con->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $id); // Assuming $id holds the user_id
    $stmt->execute();
    $stmt->bind_result($post_count);
    $stmt->fetch();
    $stmt->close();
    echo '<p class="post-count">' . "Your Posts ". "| " . $post_count . " |" . '</p>';
} else {
    echo "Error preparing the query: " . $con->error;
}
?>
<br>
                </div>
                <!-- <div class="stat-label"><h2>Your Posts</h2></div> -->
                <!-- <br> -->
                
                <?php
$query = "SELECT * FROM posts WHERE user_id = '$id'";
$result = mysqli_query($con, $query);

if ($result) {
    while ($user_posts = mysqli_fetch_assoc($result)) {
        $posts = $user_posts['content']; // Replace 'content' with your actual column name
        echo "✎ " . $posts . "<br>" . "<br>"; // Print each post and add a line break
    }
} else {
    echo "Error: " . mysqli_error($con);
}
?>

            </div>
            <div class="stat-card">
                <div class="stat-number">

                </div>
                <div class="stat-label"><p>Friends</p></div>
                <br>

                <?php
                $query = "SELECT user_name FROM users";
                $result = $con->query($query);

                while ($row = $result->fetch_assoc()) {
                echo $row['user_name'] . "<br>";
                }


?>
            </div>
        </section>
        </div>
        <h2 id="actions-title">What would you like to do today?</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                <hr><i class="fa-regular fa-pen-to-square fa-2xl" style="color: #ffffff;"></i><hr>
                </div>
                <h3></i>Share Your Thoughts</h3>
                <p>Create a new post to share with your friends and followers.</p>
                <div class="action-buttons">
                    <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-primary">Create Post</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    <hr>
                    <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #ffffff;"></i>
                    <hr>
                </div>
    <h3>Search Posts</h3>
    <p>Explore posts that match your interests or find specific content.</p>
    <div class="action-buttons">
        <a href="search.php" class="btn btn-primary">Search Posts</a>
    </div>
</div>


            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    <hr>
                    <i class="fa-solid fa-globe fa-2xl" style="color: #ffffff;"></i>
                    <hr>
                </div>
                <h3>Explore The Feed</h3>
                <p>Check What Is Going On From Your Friends In Feed Page.</p>
                <div class="action-buttons">
                    <a href="feed.php" class="btn btn-primary">Go To Feed</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    <hr>
                    <i class="fa-solid fa-gear fa-2xl" style="color: #ffffff;"></i>
                    <hr>
                </div>
    <h3>Manage Your Account</h3>
    <p>Update your profile information, privacy settings, and preferences.</p>
    <div class="action-buttons">
        <a href="settings.php" class="btn btn-primary">Go To Settings</a>
    </div>
</div>

<div class="dashboard-card">
    <div class="dashboard-card-icon">
        <hr>
        <i class="fa-solid fa-user fa-2xl" style="color: #ffffff;"></i>
        <hr>
    </div>
    <h3>View Your Profile</h3>
    <p>Check and showcase your personal information and posts.</p>
    <div class="action-buttons">
        <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-primary">Go To Profile</a>
    </div>
    
</div>

<div class="dashboard-card">
    <div class="dashboard-card-icon">
        <hr>
        <i class="fa-solid fa-puzzle-piece fa-2xl" style="color: #ffffff;"></i>
        <hr>
    </div>
    <h3>Play The Ultimate Puzzle Game</h3>
    <p>Test your problem-solving skills and challenge your mind in our exciting puzzle game. Discover hidden paths and unlock new levels!</p>
    <div class="action-buttons">
        <a href="game.php" class="btn btn-primary">Start Game</a>
    </div>
</div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 ConnectHub. All rights reserved.</p>
    </footer>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
</body>
</html>