<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:100,200,400|Source+Sans+Pro:700,400,300">
    <link rel="stylesheet" href="details.css">
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
        <div class="property-details">
            <?php
                include 'config.php';

                if (isset($_GET['id'])) {
                    $propertyId = $_GET['id'];
                    
                    $query = "SELECT * FROM posts WHERE id = $propertyId";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $property = mysqli_fetch_assoc($result);
            ?>
            <h1>Details</h1>
            <div class="image-carousel">
            <?php
                    // Display images
                    $images = explode(',', $property['images']);
                    foreach ($images as $image) {
                        $imagePath =  trim($image); // Trim to remove any extra spaces
                        if (file_exists($imagePath)) {
                            echo '<img src="' . $imagePath . '" alt="Property Image">';
                        } else {
                            echo '<p>Image not found: ' . $imagePath . '</p>';
                        }
                    }
                ?>
            </div>

            <div class="overview">
                <h2>Overview</h2>
                <ul>
                    <li>Location: <?php echo $property['area']; ?></li>
                    <li>Rent Type: <?php echo $property['type']; ?></li>
                    <li>Price: <?php echo $property['price']; ?></li>
                </ul>
            </div>

            <div class="description">
                <h2>Description</h2>
                <p><?php echo $property['info']; ?></p>
            </div>

            <div class="address">
                <h2>Address</h2>
                <ul>
                    <li>House: <?php echo $property['house_no']; ?></li>
                    <li>Road: <?php echo $property['road_no']; ?></li>
                    <li>Area: <?php echo $property['area']; ?></li>
                </ul>
                <button onclick="#">Open in Google Maps</button>
            </div>

            <div class="features">
                <h2>Features</h2>
                <ul>
                    <?php
                        $features = explode(',', $property['facilities']);
                        foreach ($features as $feature) {
                            echo '<li>' . $feature . '</li>';
                        }
                    ?>
                </ul>
            </div>

            <div class="contact-information">
                <h2>Contact Information</h2>
                <p>Email: <?php echo $property['email']; ?></p>
                <p>Phone: <?php echo $property['contact_no']; ?></p>
                <p>Facebook: <?php echo $property['facebook']; ?></p>
                <button onclick="#">Send Inquiry</button>
            </div>
            <?php
                    } else {
                        echo "<p>No property found with ID: $propertyId</p>";
                    }

                    mysqli_close($conn);
                } else {
                    echo "<p>No property ID specified.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
