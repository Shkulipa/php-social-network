<?php

    include_once ("includes/connection.php");

    if(isset($_POST['sign_up'])){
        $first_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['first_name'])));
        $last_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['last_name'])));
        $u_pass = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_pass'])));
        $u_email = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_email'])));
        $u_country = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_country'])));
        $u_gender = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_gender'])));
        $u_birthday = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_birthday'])));
        $u_gender = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_gender'])));
        $status = "verified";
        $posts = "no";
        $newgid = sprintf('%05d', rand(0, 999999));

        $username = strtolower($first_name . "_" . "_" . $newgid);
        $check_username_query = "SELECT user_name FROM WHERE user_email='$u_email'";
        $run_username = mysqli_query($con, $check_username_query);

        if(strlen($u_pass) < 9) {
            echo "<script>alert('Password should be minimum 9 characters!')</script>>";
            exit();
        }

        $check_email = "select * from users where user_email='$u_email'";
        $run_email = mysqli_query($check_email);

        $check = mysqli_num_rows($run_email);

        if($check == 1) {
            echo "<script>alert('Email already exist, Please try using another email')</script>";
            echo "<script>window.open('signup.php', '_self')</script>";
            exit();
        }

        $rand = rand(1, 3);
        if($rand == 1) {
            $profile_pic = "profile-user.png";
        } else if ($rand == 2) {
            $profile_pic = "user1.png";
        } else {
            $profile_pic = "user2.png";
        }

        $insert = "INSERT INTO users (
                        first_name, 
                        last_name, 
                        user_name, 
                        describe_user, 
                        realtionship, 
                        user_pass, 
                        user_email,
                        user_country, 
                        user_gender, 
                        user_birthday, 
                        user_image, 
                        user_cover, 
                        user_reg_date, 
                        status,
                        posts,
                        recovery_account
                    )
                    VALUES (
                    '$first_name', 
                    '$last_name',
                    '$username',
                    'Hello Coding Cafe. This is my default status',
                    '...',
                    '$u_pass',
                    '$u_email',
                    '$u_country',
                    '$u_gender',
                    '$u_birthday',
                    '$profile_pic',
                    'default_cover.jpg',
                    NOW(),
                    '$status',
                    '$posts ',
                    'iwanttoputadingintheuniverse'
                    )";
        $query = mysqli_query($con, $insert)
                    or die('Ошибка при выполнении запроса к базе данных');;
        if ($query) {
            echo "<script>alert('Well Done $first_name, you are good to go.')</script>";
            echo "<script>window.open('signin.php', '_self')</script>";
        } else {
            echo "<script>alert('Registration failed, please try again')</script>";
            echo "<script>window.open('signup.php', '_self')</script>";
        }
    }
