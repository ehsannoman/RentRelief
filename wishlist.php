<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$query = "SELECT posts.* FROM posts JOIN wishlist ON posts.id = wishlist.post_id WHERE wishlist.user_email=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:100,200,400">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300">
    <link rel="stylesheet" href="wishlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="blur-bg"></div>
    
    <div class="content">
        
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="navbar-icons">
                <a href="user.php"><img src="user.png" alt="Profile" class="icon"></a>
            </div>
        </div>

        <div class="sidebar">
            <ul>
                <li><a href="main.php"><i class="fas fa-rss"></i> Posts</a></li>
                <li><a href="createpost.php"><i class="fas fa-file-upload"></i> Create Post</a></li>
                <li><a href="mypost.php"><i class="fas fa-shopping-bag"></i> My Posts</a></li>
                <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="home.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <img src="<?php echo htmlspecialchars(explode(', ', $row['images'])[0]); ?>" alt="Post Image" class="post-image">
                    <div class="post-details">
                        <p>Location: <?php echo htmlspecialchars($row['area']); ?></p>
                        <p>Rent Type: <?php echo htmlspecialchars($row['type']); ?></p>
                        <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
                        <div class="button-group">
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="details-button">Details</a>
                            <form method="post" action="wishlist_action.php" class="wishlist-form">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="remove" class="wishlist-button active">Remove from Wishlist</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No items in your wishlist</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </div>
    </div>
</body>
</html>
