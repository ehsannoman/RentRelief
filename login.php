<?php
session_start();

include 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $username = $_POST['user'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $error = "Please enter both username and password";
        } else {
            // Validate credentials
            $query = "SELECT * FROM users WHERE email=?";
            if ($stmt = $conn->prepare($query)) {
                // Bind parameters
                $stmt->bind_param("s", $username);
                // Execute the statement
                $stmt->execute();
                // Get result
                $result = $stmt->get_result();
                // Check if user exists
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['email'] = $row['email'];
                        header("Location: main.php"); // Redirect to main.php
                        exit();
                    } else {
                        $error = "Invalid username or password";
                    }
                } else {
                    $error = "Invalid username or password";
                }
                // Close statement
                $stmt->close();
            } else {
                $error = "Oops! Something went wrong.";
            }
        }
    } else {
        $error = "Please enter both username and password";
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
            <input type="text" placeholder="username" name="user" value="<?php if(isset($_POST['user'])) echo $_POST['user']; ?>"><br>
            <input type="password" placeholder="password" name="password"><br>
            <input type="submit" value="Login">
            <span>Not registered? <a href="register.php">Create an Account.</a></span>
        </form>
        <?php if (!empty($error)) { echo '<h3 style="color:darkred font, font-style: italic;">' . $error . '</h3>'; } ?>
    </div>
</body>
</html>
