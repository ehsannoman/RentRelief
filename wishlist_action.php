<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];
    $post_id = $_POST['post_id'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $insertQuery = "INSERT INTO wishlist (user_email, post_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("si", $email, $post_id);
        $insertStmt->execute();
        $insertStmt->close();
    } elseif ($action == 'remove') {
        $deleteQuery = "DELETE FROM wishlist WHERE user_email=? AND post_id=?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("si", $email, $post_id);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    $conn->close();
    header("Location: main.php");
    exit();
} else {
    header("Location: main.php");
    exit();
}
?>
