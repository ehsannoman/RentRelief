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


<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];

    // Add your validation and database insertion code here
    // For demonstration purposes, we'll just print the collected data
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Full Name: $fullname</p>";
    echo "<p>Edu Mail: $email</p>";
    echo "<p>Gender: $gender</p>";
    echo "<p>Department: $department</p>";
    echo "<p>Semester: $semester</p>";
}
?>
