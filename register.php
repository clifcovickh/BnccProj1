<?php

require 'functions.php';

    if(isset($_POST["register"])){
        if(register($_POST) > 0){
            echo "<script>
                alert('Registration successful!');
            </script>";
            header("Location: login.php");
        }else{
            echo mysqli_error($conn);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register page</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
    <h1>- Registration Form -</h1>
    <form action="" method="post">
        <!-- <ul style="list-style-type: none;">
            <li> -->
                <label for="name">Name</label>
                <input type="text" name = "name" id="name">
            <!-- </li>
            <li> -->
                <label for="username">Username</label>
                <input type="text" name = "username" id="username">
            <!-- </li>
            <li> -->
                <label for="password">Password</label>
                <input type="password" name = "password" id="password">
            <!-- </li>
            <li> -->
                <label for="password2">Confirm password</label>
                <input type="password" name = "password2" id="password2">
            <!-- </li>
            <li> -->
                <button type="submit" name="register">Register</button>
            <!-- </li>
        </ul> -->
    </form>
    </div>
</body>
</html>