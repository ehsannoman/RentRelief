<?php
session_start();
include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];

// Prepare the SQL query using a prepared statement
$wishlistQuery = "
    SELECT posts.*
    FROM posts
    JOIN wishlist ON posts.id = wishlist.p_id
    WHERE wishlist.u_id = (
        SELECT id 
        FROM users 
        WHERE email = ?
    );
";

$stmt = $conn->prepare($wishlistQuery);
$stmt->bind_param("s", $email); // "s" specifies the type of $email as string
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Query error: ' . $stmt->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="main_content.css">
    <link rel="stylesheet" href="wishlist.css">
</head>
<body>
    <div class="blur-bg"></div> 

    <div class="content">
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="navbar-icons">
                <a href="user.php"><img src="user.png" alt="Profile" class="icon"></a>
                <img src="notification.png" alt="Notifications" class="icon">
            </div>
        </div>

        <div class="sidebar">
            <ul>
                <li><a href="main.php">Posts</a></li>
                <li><a href="createpost.php">Create Post</a></li>
                <li><a href="#">My Posts</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post-card">
                <img src="<?php echo htmlspecialchars(explode(', ', $row['images'])[0]); ?>" alt="Post Image" class="post-image">
                <div class="post-details">
                    <p>Location: <?php echo htmlspecialchars($row['area']); ?></p>
                    <p>Rent Type: <?php echo htmlspecialchars($row['type']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
                    <button class="details-button" onclick="window.location.href='details.php?id=<?php echo $row['id']; ?>'">Details</button>
                </div>
            </div>
            <?php endwhile; ?>
            <?php $conn->close(); ?>
        </div>
    </div>
</body>
</html>
