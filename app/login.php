<?php
// login.php
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
    
    if (!empty($username) && !empty($password)) {
        // Vulnerable query: Directly embedding user input into SQL query
        $query = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            // Set session and cookie
            $_SESSION['user_id'] = $user_data['user_id'];
            setcookie("role", $user_data['role'], time() + (86400 * 30), "/"); // 30-day cookie

            header("Location: index.php"); // Redirect to a protected page (e.g., dashboard)
            die;
        } else {
            $error_message = "Incorrect username or password. Please try again.";
        }
    } else {
        $error_message = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <!-- Display PHP error messages -->
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <form id="login-form" method="POST">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="signup.php" class="signup-link">Don't have an account? Sign up here</a>
</div>

</body>
</html>
