<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$rent_types = isset($_GET['rent_type']) ? $_GET['rent_type'] : [];

switch ($sort) {
    case 'price_asc':
        $orderBy = "ORDER BY price ASC";
        break;
    case 'price_desc':
        $orderBy = "ORDER BY price DESC";
        break;
    case 'newest':
        $orderBy = "ORDER BY reg_date DESC";
        break;
    default:
        $orderBy = "";
}

$filter = "";
if ($min_price !== '' && $max_price !== '') {
    $filter .= "AND price BETWEEN $min_price AND $max_price ";
}

if (!empty($rent_types)) {
    $rent_type_filter = implode("','", $rent_types);
    $filter .= "AND type IN ('$rent_type_filter') ";
}

$query = "SELECT * FROM posts WHERE 1=1 $filter $orderBy";
$result = $conn->query($query);

$wishlistQuery = "SELECT post_id FROM wishlist WHERE user_email=?";
$wishlistStmt = $conn->prepare($wishlistQuery);
$wishlistStmt->bind_param("s", $email);
$wishlistStmt->execute();
$wishlistResult = $wishlistStmt->get_result();
$wishlist = [];
while ($row = $wishlistResult->fetch_assoc()) {
    $wishlist[] = $row['post_id'];
}
$wishlistStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:100,200,400|Source+Sans+Pro:700,400,300">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="blur-bg"></div> 
    
    <div class="content">
        
        <div class="navbar">
            <img src="logo.png" alt="Logo" class="logo">
            <div class="navbar-icons">
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                        <i class="bi bi-sort-up"></i> Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="main.php?sort=price_asc">Price: Low to High</a>
                        <a class="dropdown-item" href="main.php?sort=price_desc">Price: High to Low</a>
                        <a class="dropdown-item" href="main.php?sort=newest">Newest</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <div class="dropdown-menu p-3" aria-labelledby="navbarDropdownMenuLink">
                        <form method="get" action="main.php">
                            <div class="form-group">
                                <label for="min_price">Min Price</label>
                                <input type="number" class="form-control" id="min_price" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                            </div>
                            <div class="form-group">
                                <label for="max_price">Max Price</label>
                                <input type="number" class="form-control" id="max_price" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                            </div>
                            <div class="form-group">
                                <label>Rent Type</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rent_type[]" value="one seat" <?php echo in_array('one seat', $rent_types) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="rent_type">One Seat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rent_type[]" value="one room" <?php echo in_array('one room', $rent_types) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="rent_type">One Room</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rent_type[]" value="full flat" <?php echo in_array('full flat', $rent_types) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="rent_type">Full Flat</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    </div>
                </div>
                <a href="user.php" class="btn btn-sq-sm btn-danger">
                    <i class="fa fa-user fa-2x"></i><br/>
                </a> 
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
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post-card">
                <img src="<?php echo htmlspecialchars(explode(', ', $row['images'])[0]); ?>" alt="Post Image" class="post-image">
                <div class="post-details">
                    <p>Location: <?php echo htmlspecialchars($row['area']); ?></p>
                    <p>Rent Type: <?php echo htmlspecialchars($row['type']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
                    <div class="button-group">
                        <button class="details-button" onclick="window.location.href='details.php?id=<?php echo $row['id']; ?>'">Details</button>
                        <form method="post" action="wishlist_action.php">
                            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                            <?php if (in_array($row['id'], $wishlist)): ?>
                                <button type="submit" name="action" value="remove" class="wishlist-button active">
                                    <i class="fa fa-star"></i>
                                </button>
                            <?php else: ?>
                                <button type="submit" name="action" value="add" class="wishlist-button">
                                    <i class="fa fa-star"></i>
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php $conn->close(); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
