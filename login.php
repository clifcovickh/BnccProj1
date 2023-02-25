<?php
session_start();

require 'functions.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            header("Location: task.php");
            exit;
        }
    }

    // $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login page</title>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
    <h1>Login Page</h1>

<?php if (isset($error)) :   ?>
    <p style="color : red; font-style : italic ;">Incorrect username or password </p>
<?php endif; ?>

<form action="" method="post">
    <!-- <ul style="list-style: none;">
        <li> -->
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        <!-- </li>
        <li> -->
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        <!-- </li>
        <li> -->
            <button type="submit" name="login" value="login">Login</button>
            <p class="account">Don't have an account ?<a href="register.php"> Register</a></p>

        <!-- </li>
    </ul> -->
</form>
    </div>
</body>

</html>