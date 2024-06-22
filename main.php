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
    <div class="blur-bg"></div> <!-- Div for blurred background -->
    
    <div class="content">
        <!-- Your existing content here -->
        <!-- Navbar -->
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="navbar-icons">
                <img src="notification.png" alt="Notifications" class="icon">
                <img src="profile.png" alt="Profile" class="icon">
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="#">Posts</a></li>
                <li><a href="#">Create Post</a></li>
                <li><a href="#">My Posts</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Example post card -->
            <div class="post-card">
                <img src="image1.jpg" alt="Post Image" class="post-image">
                <div class="post-details">
                    <p>Location: Mohanagar</p>
                    <p>Rent Type: Single Room</p>
                    <button class="details-button">Details</button>
                    <img src="wishlist.png" alt="Add to Wishlist" class="wishlist-icon">
                </div>
            </div>
            <!-- Repeat the post-card div for more posts -->
        </div>
    </div>
</body>
</html>
