<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $username = $_POST['user'];
        $password = $_POST['password'];

        require_once 'database.php';
        $conn = connectDB();

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            header("Location: ../home.html");
            exit();
        } else {
            $error = "Invalid username or password";
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="body"></div>
    <img src="logo.png" alt="Logo" class="logo">
    <div class="grad"></div>
    <br>
    <div class="login">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" placeholder="username" name="user"><br>
            <input type="password" placeholder="password" name="password"><br>
            <input type="submit" value="Login">
            <span>Not registered? <a href="register.php">Create an Account.</a></span>
        </form>
        <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
    </div>
</body>
</html>
