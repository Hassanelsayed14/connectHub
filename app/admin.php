<?php
session_start();
include("connection.php"); // Ensure your database connection is properly configured
include("functions.php"); // Include your utility functions
$user_data = check_login($con);
// Check if the current user is admin
$admin_id = "69157808262787"; // Define admin ID
$current_id = $_SESSION['user_id'];

// function is_admin($admin_id, $current_id) {
//     return $current_id == $admin_id;
// }

// // If the user is not an admin, redirect or display an error
// if (!is_admin($admin_id, $current_id)) {
//     die("Access denied. Admins only.");
// }

if (!isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    echo "Access denied: You are not an admin.";
    exit;
}

// Admin-specific logic here
echo "<p class='welcome-admin'>Welcome, Admin!</p>";
// Fetch all users
$users_query = "SELECT id, user_id, user_name FROM users ORDER BY user_name ASC";
$users_result = mysqli_query($con, $users_query);
if (!$users_result) {
    die("Error fetching users: " . mysqli_error($con));
}

// Fetch all posts
$posts_query = "SELECT posts.post_id, posts.content, posts.created_at, users.user_name 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.created_at DESC";
$posts_result = mysqli_query($con, $posts_query);
if (!$posts_result) {
    die("Error fetching posts: " . mysqli_error($con));
}

// Handle delete user request
if (isset($_POST['delete_user'])) {
    $user_id_to_delete = intval($_POST['delete_user']);
    $delete_user_query = "DELETE FROM users WHERE id = ?";
    $stmt = $con->prepare($delete_user_query);
    $stmt->bind_param("i", $user_id_to_delete);
    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
    $stmt->close();
}

// Handle delete post request
if (isset($_POST['delete_post'])) {
    $post_id_to_delete = intval($_POST['delete_post']);
    $delete_post_query = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $con->prepare($delete_post_query);
    $stmt->bind_param("i", $post_id_to_delete);
    if ($stmt->execute()) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post: " . mysqli_error($con);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Control Panel</title>
    
</head>
<body>
    <h1>Admin Control Panel</h1>

    <h2>Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['user_name']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="delete_user" value="<?php echo $user['id']; ?>">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Posts</h2>
    <table>
        <thead>
            <tr>
                <th>Post ID</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                <tr>
                    <td><?php echo $post['post_id']; ?></td>
                    <td><?php echo $post['content']; ?></td>
                    <td><?php echo $post['created_at']; ?></td>
                    <td><?php echo $post['user_name']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="delete_post" value="<?php echo $post['post_id']; ?>">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
