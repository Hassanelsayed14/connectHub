<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in and fetch user data
$user_data = check_login($con);




if (isset($_SESSION['user_id'])) {
    // Fetch the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Fetch current user data (including current profile picture) from the database
    $query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1"; // Vulnerable to SQL Injection
    $result = mysqli_query($con, $query);
        // Prepare and execute the query to get the user details
        $queryx = "SELECT id FROM users WHERE user_id = ?";
        $stmt = $con->prepare($queryx);
        $stmt->bind_param("i", $user_id); // "i" for integer
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
    
    // Check if the query ran successfully
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
    
    $user_data = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Update username
        if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
            $new_username = $_POST['new_username']; // No sanitization or validation
            $update_username = "UPDATE users SET user_name = '$new_username' WHERE user_id = '$user_id'"; // Vulnerable to SQL Injection
            if (!mysqli_query($con, $update_username)) {
                die("Failed to update username: " . mysqli_error($con));
            }
            $message = "Username updated successfully!";
        }

        // Update password (No hashing, insecure storage)
        if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
            $new_password = $_POST['new_password']; // No sanitization or hashing
            $update_password = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'"; // Storing password in plain text
            if (!mysqli_query($con, $update_password)) {
                die("Failed to update password: " . mysqli_error($con));
            }
            $message = "Password updated successfully!";
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            // Get file info
            $file_name = $_FILES['profile_picture']['name'];
            $file_tmp = $_FILES['profile_picture']['tmp_name'];
            $file_size = $_FILES['profile_picture']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'php', 'exe', 'html']; // Allowing risky file types

            // Check file size (2MB limit)
            if ($file_size > 2097152) {
                $message = "File size exceeds the 2MB limit.";
            }

            // Check if the file type is allowed (even though we allow some risky extensions)
            if (!in_array($file_ext, $allowed_extensions)) {
                $message = "Invalid file type. Only JPG, JPEG, PNG, GIF, PHP, EXE, and HTML are allowed.";
            } else {
                // Create a new unique file name based on time
                $new_file_name = time() . '.' . $file_ext;
                $upload_path = "uploads/" . $new_file_name;

                // Move the uploaded file to the 'uploads' directory
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Log the new file name for debugging
                    error_log("New file uploaded: " . $new_file_name);

                    // Update the database with the new file name (profile picture path)
                    $update_picture = "UPDATE users SET profile_picture = '$new_file_name' WHERE user_id = '$user_id'"; // Linking profile picture with user_id

                    if (mysqli_query($con, $update_picture)) {
                        $message = "Profile picture updated successfully!";
                    } else {
                        // Log any error with the update query
                        error_log("Failed to update profile_picture: " . mysqli_error($con));
                        $message = "Failed to update profile picture in the database.";
                    }
                } else {
                    $message = "Failed to upload the file.";
                }
            }
        }
    }
} else {
    $message = "User is not logged in!";
}
$profile_picture = isset($user_data['profile_picture']) ? $user_data['profile_picture'] : 'default.jpg';
$query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$result = mysqli_query($con, $query);
$user_data = mysqli_fetch_assoc($result);

$p="SELECT profile_picture from users where id = '$id'";
$resultp = mysqli_query($con, $p);
$user_pic = mysqli_fetch_assoc($resultp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="settings.css">
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
<div class="settings-container">
    <h2>Update Your Settings</h2>

    <!-- Display the current profile picture -->
    <img src="uploads/<?php echo $user_pic['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">

    <!-- Display messages -->
    <?php if (isset($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Form for updating username -->
    <form method="POST">
        <input type="text" name="new_username" placeholder="New Username" value="<?php echo $user_data['user_name']; ?>" required>
        <button type="submit">Update Username</button>
    </form>

    <!-- Form for updating password -->
    <form method="POST">
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit">Update Password</button>
    </form>

    <!-- Form for updating profile picture -->
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Update Profile Picture</button>
    </form>
</div>

</body>
</html>
