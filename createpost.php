<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:100,200,400|Source+Sans+Pro:700,400,300">
    <link rel="stylesheet" href="createpost.css">
</head>
<body>
    <div class="blur-bg"></div>
    
    <div class="content">
        
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="navbar-icons">
                <img src="notification.png" alt="Notifications" class="icon">
                <img src="user.png" alt="Profile" class="icon">
            </div>
        </div>

        <div class="sidebar">
            <ul>
                <li><a href="#">Posts</a></li>
                <li><a href="createpost.php">Create Post</a></li>
                <li><a href="#">My Posts</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Create a New Post</h2>
            <form action="submitpost.php" method="post" enctype="multipart/form-data">
                <div class="section">
                    <label for="images">Upload Images (max 3):</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" required>
                    
                    <label for="type">Type:</label>
                    <select id="type" name="type" required>
                        <option value="one seat">One Seat</option>
                        <option value="one room">One Room</option>
                        <option value="full flat">Full Flat</option>
                    </select>
                    
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required>
                    
                    <label for="person">Number of Persons:</label>
                    <input type="number" id="person" name="person" required>
                    
                    <label>Facilities:</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="facilities[]" value="wifi"> WiFi</label>
                        <label><input type="checkbox" name="facilities[]" value="washroom"> Washroom</label>
                        <label><input type="checkbox" name="facilities[]" value="balcony"> Balcony</label>
                        <label><input type="checkbox" name="facilities[]" value="maid"> Maid</label>
                        <label><input type="checkbox" name="facilities[]" value="parking"> Parking</label>
                        <label><input type="checkbox" name="facilities[]" value="lift"> Lift</label>
                        <label><input type="checkbox" name="facilities[]" value="water filter"> Water Filter</label>
                        <label><input type="checkbox" name="facilities[]" value="security"> Security</label>
                    </div>
                    
                    <label for="info">Additional Information:</label>
                    <textarea id="info" name="info" rows="4" cols="50"></textarea>
                </div>
                
                <div class="section">
                    <h3>Address Information</h3>
                    <label for="area">Area:</label>
                    <input type="text" id="area" name="area" required>
                    
                    <label for="road_no">Road No (optional):</label>
                    <input type="text" id="road_no" name="road_no">
                    
                    <label for="house_no">House No (optional):</label>
                    <input type="text" id="house_no" name="house_no">
                </div>
                
                <div class="section">
                    <h3>Contact Information</h3>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="contact_no">Contact No (optional):</label>
                    <input type="text" id="contact_no" name="contact_no">
                    
                    <label for="facebook">Facebook (optional):</label>
                    <input type="text" id="facebook" name="facebook">
                </div>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
