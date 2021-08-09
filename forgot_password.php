<?php
include_once ("includes/connection.php");

if (isset($_POST['submit'])) {
    $email =  mysqli_real_escape_string($con, htmlentities(trim($_POST['email'])));
    $recovery_account = mysqli_real_escape_string($con, htmlentities(trim($_POST['recovery_account'])));

    $select_user = "SELECT * FROM users WHERE user_email='$email' AND recovery_account='$recovery_account'";
    $query = mysqli_query($con, $select_user);
    $check_user = mysqli_num_rows($query);


    if($check_user == 1) {
        session_start();
        $_SESSION['user_email'] = $email;
        echo "<script>window.open('change_password.php', '_self')</script>";
    } else {
        echo  "<script>alert('Your Email or Best Friend name is incorrect')</script>";
    }
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
                    <b>Forgot Your Password.</b>
                </h3>
            </div>
            <div class="l_pass">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input class="form-control" type="email" name="email" placeholder="Enter your Email" value="<?php echo $email;?>"" required>
                    </div><br>
                    <hr>
                    <pre class="text">Enter your Best friend name down below?</pre>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </span>
                        <input id="msg" type="text" class="form-control" placeholder="Someone" name="recovery_account" required>
                    </div><br>
                    <a style="text-decoration: none; float: right; color: #187FAB;" data-toggle="tooltip" title="Signin" href="signin.php">Back to Sign in?</a><br><br>
                    <center>
                        <button id="signup" class="btn btn-info btn-lg" name="submit">Submit</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
