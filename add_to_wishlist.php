<?php
session_start();
include 'config.php';

echo $postId;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $postId = $_POST['post_id'];


    $checkQuery = $conn->prepare("SELECT * FROM wishlist WHERE u_id = (SELECT id FROM users WHERE email = ?) AND p_id = ?");
    $checkQuery->bind_param("ii", $email, $postId);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $userQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $userQuery->bind_param("s", $email);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $userId = $userResult->fetch_assoc()['id'];

    if ($result->num_rows > 0) {
        echo 'Item already in wishlist.';
    } else {
        // Insert the new wishlist item
        $insertQuery = $conn->prepare("INSERT INTO wishlist (u_id, p_id) VALUES (?, ?)");
        $insertQuery->bind_param("ii", $userId, $postId);
        if ($insertQuery->execute()) {
            echo 'success';
        } else {
            echo 'Error adding to wishlist.';
        }
    }

    $checkQuery->close();
    $insertQuery->close();
    $conn->close();
}
?>
