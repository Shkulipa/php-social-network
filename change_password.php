<?php
session_start();
include_once ("includes/connection.php");
if(!isset($_SESSION['user_email'])) {
    header("location: index.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Forgot Your Password</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--  Bootstrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<style>
    body {
        overflow-x: hidden;
    }
    .main-content {
        width: 50%;
        height: 40%;
        margin: 10px auto;
        background-color: #fff;
        border: 2px solid #e6e6e6;
        padding: 40px 50px;
    }
    .header {
        border: 0px solid #000;
        margin-bottom: 5px;
    }
    .well {
        background-color: #187FAB;
    }
    #signup {
        width: 60%;
        border-radius: 30px;
    }
</style>

<body>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <center><h1 style="color: white;"><b>Coding Cafe</b></h1></center>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="main-content">
            <div class="header">
                <h3 style="text-align: center">
                    <b>Change Your Password</b>
                </h3>
            </div>
            <div class="l_pass">
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input id="password" class="form-control" type="password" name="pass" placeholder="New password" required>
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input id="password" type="password" class="form-control" placeholder="RE-enter New password" name="pass1" required>
                    </div><br>
                    <center>
                        <button id="signup" class="btn btn-info btn-lg" name="change">Change Password</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['change'])) {
        $pass =  mysqli_real_escape_string($con, htmlentities(trim($_POST['pass'])));
        $pass1 = mysqli_real_escape_string($con, htmlentities(trim($_POST['pass1'])));
        $email = $_SESSION['user_email'];

        if($pass == $pass1) {
            if(strlen($pass) >= 6) {
                $select_user = "update users Set user_pass='$pass' where user_email='$email'";
                $query = mysqli_query($con, $select_user);

                if($query) {
                    echo  "<script>alert('Your password changed!')</script>";
                    echo  "<script>window.open('home.php', '_self')</script>";
                } else {
                    echo  "<script>alert('Something went wrong')</script>";
                    echo "<script>window.open('change_password.php', '_self')</script>";
                }
            } else {
                echo "<script>alert('Your password should be more than 6 characters')</script>";
                echo "<script>window.open('change_password.php', '_self')</script>";
            }
        } else {
            echo "<script>alert('Please enter the same password in both filed!')</script>";
            echo "<script>window.open('change_password.php', '_self')</script>";
        }
    }

?>

</body>
</html>