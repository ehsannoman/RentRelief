<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
    <link rel="stylesheet" href="mypost.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="blur-bg"></div>
    <div class="navbar">
        <img src="logo.png" alt="Logo" class="logo">
        <div class="navbar-icons">
                <a href="user.php"><img src="user.png" alt="Profile" class="icon"></a>
        </div>
    </div>
    <div class="content">
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
            <div class="posts-container">
                <?php
                include 'config.php';
                session_start();
                if (!isset($_SESSION['email'])) {
                    header("Location: login.php");
                    exit();
                }
                $email = $_SESSION['email'];
                $query = "SELECT * FROM posts WHERE email=?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='post'>";
                            echo "<h3>" . htmlspecialchars($row['type']) . "</h3>";
                            echo "<form method='post' action='update_post.php'>";
                            echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($row['id']) . "'>";
                            echo "<label for='type'>Type:</label>";
                            echo "<input type='text' id='type' name='type' value='" . htmlspecialchars($row['type']) . "'>";
                            echo "<label for='price'>Price:</label>";
                            echo "<input type='text' id='price' name='price' value='" . htmlspecialchars($row['price']) . "'>";
                            echo "<label for='person'>Person:</label>";
                            echo "<input type='text' id='person' name='person' value='" . htmlspecialchars($row['person']) . "'>";
                            echo "<label for='facilities'>Facilities:</label>";
                            echo "<input type='text' id='facilities' name='facilities' value='" . htmlspecialchars($row['facilities']) . "'>";
                            echo "<label for='info'>Info:</label>";
                            echo "<textarea id='info' name='info'>" . htmlspecialchars($row['info']) . "</textarea>";
                            echo "<label for='area'>Area:</label>";
                            echo "<input type='text' id='area' name='area' value='" . htmlspecialchars($row['area']) . "'>";
                            echo "<label for='road_no'>Road No:</label>";
                            echo "<input type='text' id='road_no' name='road_no' value='" . htmlspecialchars($row['road_no']) . "'>";
                            echo "<label for='house_no'>House No:</label>";
                            echo "<input type='text' id='house_no' name='house_no' value='" . htmlspecialchars($row['house_no']) . "'>";
                            echo "<button type='submit'>Update</button>";
                            echo "<button type='submit' name='delete_post' value='" . htmlspecialchars($row['id']) . "'>Delete</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>You have no posts.</p>";
                    }
                    $stmt->close();
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
