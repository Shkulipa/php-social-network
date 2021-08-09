<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>

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
    #signup {
        width: 60%;
        border-radius: 30px;
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
                    <h3 style="text-align: center;"><strong>Join Coding Cafe</strong></h3>
                </div>

                <?php
                    include_once ('./includes/connection.php');

                    $first_name =  mysqli_real_escape_string($con, htmlentities(trim($_POST['first_name'])));
                    $last_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['last_name'])));
                    $u_pass = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_pass'])));
                    $u_email = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_email'])));
                    $u_country = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_country'])));
                    $u_gender = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_gender'])));
                    $u_birthday = mysqli_real_escape_string($con, htmlentities(trim($_POST['u_birthday'])));

                    $check_email = "select * from users where user_email='$u_email'";
                    $run_check_email = mysqli_query($con, $check_email);

                ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="1-part">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input type="text" class="form-control" placeholder="First name" name="first_name" value="<?php echo $first_name; ?>" required="required">
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?php echo $last_name; ?>" required="required">
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" placeholder="Password" name="u_pass" required="required" value="<?php echo $u_pass; ?>">
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" type="email" class="form-control" placeholder="Email" name="u_email" value="<?php echo $u_email;?>" required="required">
                    </div><br>
                    <div>
                        <?php
                            if(mysqli_num_rows($run_check_email) >= 1) {
                                echo "<b style='color: red;'>This email is already taken, please enter another</b>";
                            }
                        ?>
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span>
                        <select class="form-control" name="u_country" required="required">
                            <option <?php if(!isset($_POST['u_country']) && is_string(trim($_POST['u_country']))) {echo "selected";}?> disabled>Select your country</option>
                            <option value="USA" <?php if($_POST['u_country'] == 'USA' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>USA</option>
                            <option value="Russia" <?php if($_POST['u_country'] == 'Russia' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>Russia</option>
                            <option value="India" <?php if($_POST['u_country'] == 'India' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>India</option>
                            <option value="Japan" <?php if($_POST['u_country'] == 'Japan' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>Japan</option>
                            <option value="UK" <?php if($_POST['u_country'] == 'UK' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>UK</option>
                            <option value="France" <?php if($_POST['u_country'] == 'France' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>France</option>
                            <option value="Germany" <?php if($_POST['u_country'] == 'Germany' && is_string(trim($_POST['u_country']))) {echo "selected";}?>>Germany</option>
                        </select>
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span>
                        <select class="form-control input-dm" name="u_gender" required="required">
                            <option selected  disabled>Select your gender</option>
                            <option value="Male" <?php if($_POST['u_gender'] == 'Male' && is_string(trim($_POST['u_gender']))) {echo "selected";}?>>Male</option>
                            <option value="Female" <?php if($_POST['u_gender'] == 'Female' && is_string(trim($_POST['u_gender']))) {echo "selected";}?>>Female</option>
                        </select>
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="date" class="form-control" placeholder="Email" name="u_birthday" required="required" value="<?php echo $u_birthday; ?>">
                    </div><br>
                    <a style="text-decoration: none;float: right;color: #187FAB" data-toggle="tooltip" title="Signin" href="signin.php">Already have an account?</a><br><br>
                    <center>
                        <button id="signup" class="btn btn-info btn-lg" name="sign_up">Signup</button>
                        <?php
                            if(mysqli_num_rows($run_check_email) == 0) {
                                include("insert_user.php");
                            }
                        ?>
                    </center>
                </form>


            </div>
        </div>
    </div>

</body>
</html>
