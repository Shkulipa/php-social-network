<?php
session_start();
if(!isset($_SESSION['user_email'])) {
    header("location: index.php");
}
include_once ("includes/header.php");
?>
<!doctype html>
<html lang="en">
<head>
    <title>Edit Account Settings</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--  Bootstrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!--  mystyle  -->
    <link rel="stylesheet" href="./style/style.css">
</head>
<style>
    body {
        overflow-x: hidden;
    }
</style>
<body>
<br>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <form action="" method="post" enctype="multipart/form-data">
            <table class="table table-bordered table-hover">
                <tr align="center">
                    <td colspan="6" class="active">
                        <h2>Edit Your Profile</h2>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Change Your First name</td>
                    <td>
                        <input class="form-control" type="text" name="first_name" required value="<?php echo $first_name;?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Change Your Last name</td>
                    <td>
                        <input class="form-control" type="text" name="last_name" required value="<?php echo $last_name;?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Change Your User name</td>
                    <td>
                        <input class="form-control" type="text" name="user_name" required value="<?php echo $user_name;?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Description</td>
                    <td>
                        <input class="form-control" type="text" name="describe_user" value="<?php echo $describe_user;?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Relationship</td>
                    <td>
                        <select class="form-control" name="realtionship">
                            <option><?php echo $relationship_status; ?></option>
                            <option>Engaged</option>
                            <option>Married</option>
                            <option>Single</option>
                            <option>In an Relationship</option>
                            <option>it's Complicated</option>
                            <option>Separated</option>
                            <option>Widowed</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Password</td>
                    <td>
                        <input class="form-control" type="password" name="user_pass" id="myPass" required value="<?php echo $user_pass;?>">
                        <input id="showPassword" type="checkbox"><b>Show Password</b>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Email</td>
                    <td>
                        <input class="form-control" type="email" name="user_email" required value="<?php echo $user_email;?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Country</td>
                    <td>
                        <select class="form-control" name="user_country">
                            <option><?php echo $user_country; ?></option>
                            <option>USA</option>
                            <option>Ukraine</option>
                            <option>Pakistan</option>
                            <option>India</option>
                            <option>Brazil</option>
                            <option>Mexico</option>
                            <option>UK</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Gender</td>
                    <td>
                        <select class="form-control" name="user_gender">
                            <option><?php echo $user_gender; ?></option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Birthday</td>
                    <td>
                        <input class="form-control input-md" type="date" name="user_birthday" required value="<?php echo $user_birthday;?>">
                    </td>
                </tr>

                <!-- recover password option -->
                <tr>
                    <td style="font-weight: bold;">Forgot your password?</td>
                    <td>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Turn On</button>

                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="recovery.php?id=<?php echo $user_id; ?>" method="post">
                                            <b>What is your School Best Friend Name?</b>
                                            <textarea class="form-control" name="content" placeholder="Someone" cols="83" rows="4"></textarea><br>
                                            <input class="btn btn-default" type="submit" name="sub" value="Submit" style="width: 100px;"><br><br>
                                            <pre>Answer the above question we will ask this question if you forgot your <br>password.</pre>
                                        </form>
                                        <?php
                                            if(isset($_POST['sub'])) {
                                                $bfn = mysqli_real_escape_string($con, htmlentities(trim($_POST['content'])));

                                                if($bfn == '') {
                                                    echo "<script>alert('please enter something')</script>>";
                                                    echo "<script>window.open('edit_profile.php?u_id=$user_id', '_self')</script>";

                                                    exit();
                                                } else {
                                                    $update = "update users set recovery_account='$bfn' where user_id='$user_id'";
                                                    $run = mysqli_query($con , $update);

                                                    if ($run) {
                                                        echo "<script>alert('Working...')</script>";
                                                        echo "<script>window.open('edit_profile.php?u_id=$user_id', '_self')</script>";
                                                    } else {
                                                        echo "<script>alert('Error while Updating information')</script>";
                                                        echo "<script>window.open('edit_profile.php?u_id=$user_id', '_self')</script>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="6">
                        <input type="submit" class="btn btn-info" name="update" style="width: 250px;" value="update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="col-sm-2"></div>
</div>

<?php
if(isset($_POST['update'])) {
    $first_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['first_name'])));
    $last_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['last_name'])));
    $user_name = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_name'])));
    $describe_user = mysqli_real_escape_string($con, htmlentities(trim($_POST['describe_user'])));
    $realtionship = mysqli_real_escape_string($con, htmlentities(trim($_POST['realtionship'])));
    $user_pass = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_pass'])));
    $user_email = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_email'])));
    $user_country = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_country'])));
    $user_gender = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_gender'])));
    $user_birthday = mysqli_real_escape_string($con, htmlentities(trim($_POST['user_birthday'])));

    $update = "update users set
                    first_name = '$first_name',
                    last_name = '$last_name',
                    user_name = '$user_name',
                    describe_user = '$describe_user',
                    realtionship = '$realtionship',
                    user_pass = '$user_pass',
                    user_email = '$user_email',
                    user_country = '$user_country',
                    user_gender = '$user_gender',
                    user_birthday = '$user_birthday' where user_id='$user_id'";

    $run = mysqli_query($con, $update);

    if($run) {
        echo "<script>alert('Your Profile Updated')</script>";
        echo "<script>window.open('edit_profile.php?u_id=$user_id', '_self')</script>";
    }
}
?>

<script>

    document.getElementById("showPassword").addEventListener("click", function() {
        if (document.getElementById('myPass').getAttribute('type') === 'password') {
            document.getElementById('myPass').setAttribute('type', 'text');
        } else {
            document.getElementById('myPass').setAttribute('type','password');
        };
    });
</script>

</body>
</html>