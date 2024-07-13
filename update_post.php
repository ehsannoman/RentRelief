<?php
include 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_post'])) {
        // Handle post deletion
        $post_id = $_POST['delete_post'];
        $delete_query = "DELETE FROM posts WHERE id=?";
        if ($stmt = $conn->prepare($delete_query)) {
            $stmt->bind_param("i", $post_id);
            if ($stmt->execute()) {
                header("Location: mypost.php");
                exit();
            } else {
                echo "Error deleting post: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        // Handle post update
        $post_id = $_POST['post_id'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $person = $_POST['person'];
        $facilities = $_POST['facilities'];
        $info = $_POST['info'];
        $area = $_POST['area'];
        $road_no = $_POST['road_no'];
        $house_no = $_POST['house_no'];

        $update_query = "UPDATE posts SET type=?, price=?, person=?, facilities=?, info=?, area=?, road_no=?, house_no=? WHERE id=?";
        if ($stmt = $conn->prepare($update_query)) {
            $stmt->bind_param("sdssssssi", $type, $price, $person, $facilities, $info, $area, $road_no, $house_no, $post_id);
            if ($stmt->execute()) {
                header("Location: mypost.php");
                exit();
            } else {
                echo "Error updating post: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
