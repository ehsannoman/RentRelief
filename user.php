<?php
session_start();

// Assuming you have session handling for user authentication
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Include necessary files and database connection
include 'config.php';

// Fetch user details from database
$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email=?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $gender = $row['gender'];
        $department = $row['department'];
        $semester = $row['semester'];
        // You can fetch more fields as needed
    }
    $stmt->close();
}

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_fullname = $_POST['fullname'];
    $new_gender = $_POST['gender'];
    $new_department = $_POST['department'];
    $new_semester = $_POST['semester'];

    // Update query
    $update_query = "UPDATE users SET fullname=?, gender=?, department=?, semester=? WHERE email=?";
    if ($stmt = $conn->prepare($update_query)) {
        $stmt->bind_param("sssss", $new_fullname, $new_gender, $new_department, $new_semester, $email);
        if ($stmt->execute()) {
            // Update successful, fetch updated details
            $fullname = $new_fullname;
            $gender = $new_gender;
            $department = $new_department;
            $semester = $new_semester;
            // Optionally, show a success message
            $update_msg = "Profile updated successfully!";
        } else {
            // Update failed
            $update_error = "Failed to update profile: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $fullname; ?></h1>
        
        <?php
        // Display update messages or errors if any
        if (isset($update_msg)) {
            echo "<p class='success'>" . $update_msg . "</p>";
        }
        if (isset($update_error)) {
            echo "<p class='error'>" . $update_error . "</p>";
        }
        ?>

        <div class="profile">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="fullname">Full Name:</label><br>
                <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>"><br><br>

                <label for="gender">Gender:</label><br>
                <select id="gender" name="gender">
                    <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                </select><br><br>

                <label for="department">Department:</label><br>
                <input type="text" id="department" name="department" value="<?php echo $department; ?>"><br><br>

                <label for="semester">Semester:</label><br>
                <input type="text" id="semester" name="semester" value="<?php echo $semester; ?>"><br><br>

                <input type="submit" value="Update Profile">
            </form>
        </div>
        
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
