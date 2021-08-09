<?php
include_once ("includes/connection.php");

if (isset($_POST['login'])) {
    $u_email =  mysqli_real_escape_string($con, htmlentities(trim($_POST['u_email'])));
    $pass =  mysqli_real_escape_string($con, htmlentities(trim($_POST['pass'])));

    if( (!empty($u_email) && !empty($pass)) && (is_string($u_email) && (is_string($u_email) || is_numeric($u_email))) ) {
        $select_user = "SELECT * FROM users WHERE user_email='$u_email' AND user_pass='$pass' AND status='verified'";
        $data = mysqli_query($con, $select_user);
        $check_user = mysqli_num_rows($data);

        if($check_user == 1 && is_string($u_email) && is_string($pass)) {
            $_SESSION['user_email'] = $u_email;
            echo "<script>window.open('home.php', '_self')</script>";
        } else {
            echo  "<script>alert('Your Email or Password is incorrect')</script>";
        }
    } else {
        echo  "<script>alert('Fill in all the fields, or enter correct values')</script>";
    }
}