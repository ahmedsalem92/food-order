<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title> login - food order system </title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>

        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <!--- display the massage of login in display--->

            <?php
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if (isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
?>

<br><br>


            <!--- login form start here ---->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>
            <!--- login form End here ---->
            <br><br>

            <p class="text-center"> Created By - <a href="#">ahmed salem</a> </p>
        </div>

    </body>
</html>


<?php

    // check the submit botton is clicked or not

    if (isset($_POST['submit'])) {
        // process for login

        //1. get the data from login form
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,md5($_POST['password']));

        //2. check SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. execute the query
        $res = mysqli_query($conn, $sql);

        //4. count rows to check whether the user exists ot not
        $count = mysqli_num_rows($res);

        if ($count==1) {
            // user avalable and login sucess
            $_SESSION['login'] = "<div class='success'> Login Successful.</div>";
            $_SESSION['user'] = $username; // to check if the user login or not and logout will unset

            //redirect to home page/dashboard
            header('location:' . SITEURL . 'admin/');
        } else {
            // user not available and login fail
            $_SESSION['login'] = "<div class='error text-center'> Username or Password did not match </div>";
            //redirect to home page/dashboard
            header('location:' . SITEURL . 'admin/login.php');
        }
    }

?>