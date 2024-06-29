<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $person = $_POST['person'];
    $facilities = isset($_POST['facilities']) ? implode(', ', $_POST['facilities']) : '';
    $info = $_POST['info'];
    $area = $_POST['area'];
    $road_no = $_POST['road_no'];
    $house_no = $_POST['house_no'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $facebook = $_POST['facebook'];

    $uploadDir = 'uploads/';
    $images = [];
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['images']['name'][$key]);
        $targetFilePath = $uploadDir . $fileName;
        if (move_uploaded_file($tmpName, $targetFilePath)) {
            $images[] = $targetFilePath;
        } else {
            echo "Error uploading file: $fileName";
            exit();
        }
    }
    $images = implode(', ', $images);

    $stmt = $conn->prepare("INSERT INTO posts (type, price, person, facilities, info, area, road_no, house_no, email, contact_no, facebook, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdisssssssss", $type, $price, $person, $facilities, $info, $area, $road_no, $house_no, $email, $contact_no, $facebook, $images);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    echo "<script>
        alert('Post created successfully!');
        window.location.href = 'main.php';
    </script>";
}
?>
