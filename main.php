<?php
session_start();
include 'config.php';

$query = "SELECT * FROM posts";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:100,200,400|Source+Sans+Pro:700,400,300">
    <link rel="stylesheet" href="main.css">
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
                <li><a href="#">Posts</a></li>
                <li><a href="createpost.php">Create Post</a></li>
                <li><a href="#">My Posts</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="home.html">Logout</a></li>
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
                    <img src="wishlist.png" alt="Add to Wishlist" class="wishlist-icon">
                </div>
            </div>
            <?php endwhile; ?>
            <?php $conn->close(); ?>
        </div>
    </div>
</body>
</html>
