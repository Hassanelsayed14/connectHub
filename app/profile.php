<?php 
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

// Fetch ID from URL or fallback to logged-in user
$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];

// Fetch user data based on id
$query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$result = mysqli_query($con, $query);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    die("User not found.");
}

$username = $user_data['user_name'];
$profile_picture = isset($user_data['profile_picture']) ? $user_data['profile_picture'] : 'default.jpg';
$profile_description = isset($user_data['profile_description']) ? $user_data['profile_description'] : '';

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new_post'])) {
    // Remove mysqli_real_escape_string to allow HTML and script injections
    $post_content = $_POST['post_content'];
    
    // Vulnerable SQL query
    $insert_post = "INSERT INTO posts (user_id, content) VALUES ('$id', '$post_content')";
    
    // Execute the query
    mysqli_query($con, $insert_post);
    
    // Success message
    $message = "Post added successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Profile</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="profile.css">
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

<div class="profile-container">
    <h2><?php echo htmlspecialchars($username); ?>'s Profile</h2>
    <img src="uploads/<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
    <p><?php echo htmlspecialchars($profile_description); ?></p>

    <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

    <form method="POST">
        <textarea id="post-content" name="post_content" placeholder="What's on your mind?" required></textarea>
        <button type="submit" name="new_post">Add Post</button>
    </form>
</div>

</body>
</html>
