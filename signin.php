<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>

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
    .header{
        border: 0px solid #000;
        margin-bottom: 5px;
    }
    .well {
        background-color: #187FAB;
    }
    #signin {
        width: 60%;
        border-radius: 30px;
    }
    .overlap-text {
        position: relative;
    }
    .overlap-text a{
        position: absolute;
        top: 8px;
        right: 10px;
        font-size: 14px;
        text-decoration: none;
        font-family: 'Overpass Mono', monospace;
        letter-spacing: -1px;
    }
</style>
<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <center>
                    <h1 style="color: white;">Coding Cafe</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="main-content">
                <div class="header">
                    <h3 style="text-align: center;"><strong>Login to Coding Cafe</strong></h3>
                </div>
                <div class="1-part">
                    <form action="" method="post">
                        <input type="email" name="u_email" placeholder="Email" required="required" class="form-control input-md"><br>
                        <div class="overlap-text">
                            <input type="password" name="pass" placeholder="Password" required="required" class="form-control input-md">
                            <a style="text-decoration: none; float: right; color: #187FAB;" data-toggle="tooltip" title="Reset Password" href="forgot_password.php">Forgot?</a>
                        </div>
                        <a style="text-decoration: none;float: right;color: #187FAB; margin: 10px 0;" data-toggle="tooltip" title="Create Account!" href="signup.php">Dont have an account?</a><br><br>
                        <center>
                            <button id="signin" class="btn btn-info btn-lg" name="login">login</button>
                        </center>
                        <?php include("login.php") ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
