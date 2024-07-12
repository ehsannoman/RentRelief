<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Get the user ID from the session
$email = $_SESSION['email'];
$userQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
$userQuery->bind_param("s", $email);
$userQuery->execute();
$userQuery->store_result();
$userQuery->bind_result($userId);
$userQuery->fetch();
$userQuery->close();

// Fetch posts for the logged-in user
$postQuery = $conn->prepare("
    SELECT * FROM posts WHERE u_id = ?
");
$postQuery->bind_param("i", $userId);
$postQuery->execute();
$postsResult = $postQuery->get_result();

// HTML Header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="main_content.css">

     <!-- Link to the new CSS file -->
</head>
    <body>
    <div class="blur-bg"></div> 

    <div class="content">
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            
        </div>

        <div class="sidebar">
            <ul>
                <li><a href="main.php">Posts</a></li>
                <li><a href="createpost.php">Create Post</a></li>
                <li><a href="myposts.php">My Posts</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="home.html">Logout</a></li>
            </ul>
        </div>
<body>

    <div class="main-content">
        <?php while ($post = $postsResult->fetch_assoc()): ?>
        <div class="post-card">
            <img src="<?php echo htmlspecialchars(explode(', ', $post['images'])[0]); ?>" alt="Post Image" class="post-image">
            <div class="post-details">
                <p>Location: <?php echo htmlspecialchars($post['area']); ?></p>
                <p>Rent Type: <?php echo htmlspecialchars($post['type']); ?></p>
                <p>Price: <?php echo htmlspecialchars($post['price']); ?></p>
                <button class="details-button" onclick="window.location.href='details.php?id=<?php echo $post['id']; ?>'">Details</button>
            </div>
        </div>
        <?php endwhile; ?>
        <?php $conn->close(); ?>
    </div>
</body>
</html>
