<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];

    // Validate email format
    if (strpos($email, '@aust.edu') !== false) {
        if ($password === $confirm_password) {
            // Check if email is already registered
            $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $result = $conn->query($email_check_query);
            if ($result->num_rows == 0) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (fullname, email, password, gender, department, semester)
                        VALUES ('$fullname', '$email', '$hashed_password', '$gender', '$department', '$semester')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='notification success'>Registration Successful! Redirecting to login...</div>";
                    echo "<script>
                            setTimeout(function(){
                                window.location.href = 'login.php';
                            }, 3000);
                          </script>";
                } else {
                    echo "<div class='notification error'>Registration failed: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='notification error'>Email is already registered!</div>";
            }
        } else {
            echo "<div class='notification error'>Passwords do not match!</div>";
        }
    } else {
        echo "<div class='notification error'>Email must end with @aust.edu</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Exo:100,200,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300" rel="stylesheet">
    <link rel="stylesheet" href="register.css">

</head>
<body>
    <div class="body">
        <div class="background"></div>
        <div class="header">
            <div>
                <img src="logo.png" alt="Site Random Logo" class="logo">
            </div>
        </div>
        <div class="register">
            <form action="register.php" method="post">
                <input type="text" placeholder="Full Name" name="fullname" required><br>
                <input type="email" placeholder="Edu Mail" name="email" required><br>
                <input type="password" placeholder="Password" name="password" required><br>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required><br>
                <select name="gender" required>
                    <option value="" disabled selected>Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select><br>
                <select name="department" required>
                    <option value="" disabled selected>Department</option>
                    <option value="EEE">EEE</option>
                    <option value="CSE">CSE</option>
                    <option value="CE">CE</option>
                    <option value="TE">TE</option>
                    <option value="ME">ME</option>
                    <option value="IPE">IPE</option>
                    <option value="ARC">ARC</option>
                    <option value="BBA">BBA</option>
                </select><br>
                <select name="semester" required>
                    <option value="" disabled selected>Semester</option>
                    <option value="1.1">1.1</option>
                    <option value="1.2">1.2</option>
                    <option value="2.1">2.1</option>
                    <option value="2.2">2.2</option>
                    <option value="3.1">3.1</option>
                    <option value="3.2">3.2</option>
                    <option value="4.1">4.1</option>
                    <option value="4.2">4.2</option>
                </select><br>
                <input type="submit" value="Register"><br>
            </form>
            <span>Already registered? <a href="login.php">Login here.</a></span>
        </div>
    </div>
</body>
</html>
