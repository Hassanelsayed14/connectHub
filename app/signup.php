<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to index.php if already logged in
    exit;
}

include("connection.php");
include("functions.php");

$error_message = ""; // Variable to hold error messages

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        
        // Check if username already exists
        $check_query = "SELECT * FROM users WHERE user_name = '$username' LIMIT 1";
        $result = mysqli_query($con, $check_query);
        
        if (mysqli_num_rows($result) > 0) {
            // Username already exists
            $error_message = "This username is already taken. Please choose a different one.";
        } else {
            // Username is unique, proceed with the registration
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$username', '$password')";
            
            if (mysqli_query($con, $query)) {
                header("Location: login.php"); // Redirect to login page after successful signup
                die;
            } else {
                $error_message = "An error occurred during registration. Please try again.";
            }
        }
    } else {
        $error_message = "Please enter valid information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="signup.css">
</head>
<body>

<div class="signup-container">
    <h2>Signup</h2>
    <!-- Display PHP error messages -->
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <form id="signup-form" method="POST">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <a href="login.php" class="login-link">Already have an account? Login here</a>
</div>

</body>
</html>
