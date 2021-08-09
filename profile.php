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
    <title><?php echo $user_name ?></title>
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
    body{
        overflow-x: hidden;
    }

    .inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .inputfile + label {
        font-size: 1.25em;
        font-weight: 700;
        color: white;
        background-color: black;
        display: inline-block;
    }

    .inputfile:focus + label,
    .inputfile + label:hover {
        background-color: red;
    }

    .inputfile:focus + label {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }
    #cover-img {
        width: 100%;
        height: 100%;
        max-height: 400px;
    }
    #profile-img {
        position: absolute;
        top: 160px;
        left: 40px;
    }
    #update_profile {
        position: relative;
        top: 100px;
        cursor: pointer;
        left: 93px;
        border-radius: 4px;
        background-color: rgba(0,0,0,0.1);
        transform: translate( -50%, -50%);
    }
    #button_profile {
        position: absolute;
        top: 90%;
        left: 50%;
        cursor: pointer;
        transform: translate( -50%, -50%);
    }
    .label_profile {
        position: absolute;
        left: 50%;
        top: 60%;
        transform: translate( -50%, -50%);
        width: 100%;
        text-align: center;
    }
    #own_posts {
        border:5px solid #e6e6e6;
        padding: 40px 50px;
        margin: 0 30px;
    }

    #posts-img {
        height: 300px;
        width: 100%;
    }
</style>
<body>
<div class="row">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-8">
        <?php
            echo "
                <div>
                    <div>
                        <img id='cover-img' src='cover/$user_cover' class='img-rounded' alt='cover'>
                    </div>
                    <form action='profile.php?u_id=$user_id' method='post' enctype='multipart/form-data'>
                        <ul class='nav pull-left' style='position: absolute; top: 10px; left: 40px;'> 
                            <li class='dropdownm'>
                                <button class='dropdown-toggle btn btn-default' data-toggle='dropdown'>Change Cover</button>
                                <div class='dropdown-menu'>
                                    <center>
                                        <p>Click <b>Select Cover</b> and then click the<br> <b>Update Cover</b></p>
                                        <label class='btn btn-info' for='cover'>Select cover </label>
                                        <input type='file' name='u_cover' size='60' id='cover' class='inputfile'>
                                        <br><br>
                                        <button name='submit' class='btn btn-info'>Update Cover</button>
                                    </center>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
                <div id='profile-img'>
                    <img src='users/$user_image' alt='Profile' class='img-circle' width='180px' height='180px'>
                     <form action='profile.php?u_id=$user_id' method='post' enctype='multipart/form-data'>
                        <label class='label_profile' for='update_profile'>Select image profile </label>
                        <input type='file' name='u_image' size='60' id='update_profile' class='inputfile'>
                        <br><br>
                        <button id='button_profile' name='update' class='btn btn-info'>Update Profile</button>
                     </form>
                </div><br>
            ";
        ?>
        <?php
            if(isset($_POST['submit'])) {
                $u_cover = strval(mysqli_real_escape_string($con, htmlentities(trim($_FILES['u_cover']['name']))));
                $image_type =  strval(htmlentities(trim($_FILES['u_cover']['type'])));
                $image_tmp =  strval(htmlentities(trim($_FILES['u_cover']['tmp_name'])));
                $random_number = rand(1,100);


                if($u_cover == '') {
                    echo "<script>alert('Please Select Cover Image')</script>";
                    echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    exit();
                } else if ($image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/gif') {
                    move_uploaded_file($image_tmp, "cover/$u_cover.$random_number");
                    $update = "UPDATE users SET user_cover='$u_cover.$random_number' WHERE user_id='$user_id'";
                    $run = mysqli_query($con, $update);

                    if ($run) {
                        echo "<script>alert('Your Cover Updated')</script>";
                        echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    }
                } else {
                    echo "<script>alert('Upload a picture format: jpeg, png or gif')</script>";
                    echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    exit();
                }
            }
        ?>
    </div>
    <?php
        if(isset($_POST['update'])) {
            $u_image = strval(mysqli_real_escape_string($con, htmlentities(trim($_FILES['u_image']['name']))));
            $image_tmp = strval(htmlentities(trim($_FILES['u_image']['tmp_name'])));
            $image_type =  strval(htmlentities(trim($_FILES['u_image']['type'])));
            $random_number = rand(1,100);

            if($u_image == '') {
                echo "<script>alert('Please Select Profile Image')</script>";
                echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                exit();
            } else if ($image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/gif') {
                move_uploaded_file($image_tmp, "users/$u_image.$random_number");
                $update = "UPDATE users SET user_image='$u_image.$random_number' WHERE user_id='$user_id'";
                $run = mysqli_query($con, $update);

                if ($run) {
                    echo "<script>alert('Your Profile Cover Updated')</script>";
                    echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                }
            } else {
                echo "<script>alert('Upload a picture format: jpeg, png or gif')</script>";
                echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                exit();
            }
        }
    ?>
    <div class="col-sm-2">

    </div>
</div>
<div class="row">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-2" style="background-color: #e6e6e6;text-align: center; left: 0.9%; border-radius: 4px;">
        <?php
            echo "
                <center><h2><b>About</b></h2></center>
                <center><h4><b>$first_name $last_name</b></h4></center>
                <p><b><i style='color: grey;'>$describe_user</i></b></p><br>
                <p><b>Relationship status:</b> $relationship_status</p>
                <p><b>Lives in:</b> $user_country</p>
                <p><b>Member Since:</b> $register_date</p>
                <p><b>Gender:</b> $user_gender</p>
                <p><b>Date of Birth:</b> $user_birthday</p>
            ";
        ?>
    </div>
    <div class="col-sm-6">
        <?php
            global $con;
            if(isset($_GET['u_id'])) {
                $u_id = mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['u_id']))));
            }

            if($_SESSION['user_email'] == '') {
                echo "<script>window.open('user_profile.php?u_id=$u_id')</script>";
                exit();
            }

            while ($row_posts = mysqli_fetch_array($run_posts)) {
                $post_id = $row_posts['post_id'];
                $user_id = $row_posts['user_id'];
                $content = $row_posts['post_content'];
                $upload_image = $row_posts['upload_image'];
                $post_date = $row_posts['post_date'];

                $user = "select * from users where user_id='$user_id' AND posts='yes'";

                $run_user = mysqli_query($con, $user);
                $row_user = mysqli_fetch_array($run_user);

                $user_name = $row_user['user_name'];
                $user_image = $row_user['user_image'];



                if($content == "No" && strlen($upload_image) >= 1) {
                    echo "
                        <div id='own_posts'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3>
                                        <a style='text-decoration:none; cursor:pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4>
                                        <small style='color:black;'>Update a post on <strong>$post_date</small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <img id='posts-img' src='imagepost/$upload_image' style='height:350px' alt=''>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-success'>View</button>
                            </a>
                            <a href='edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-info'>Edit</button>
                            </a>
                            <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-danger'>Delete</button>
                            </a>
                        </div><br><br>
                    ";
                } else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
                    echo "
                        <div id='own_posts'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3>
                                        <a style='text-decoration:none; cursor:pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4>
                                        <small style='color:black;'>Update a post on <strong>$post_date</small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <h3><p>" . nl2br($content) . "</p></h3>
                                    <img id='posts-img' src='imagepost/$upload_image' style='height:350px' alt=''>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-success'>View</button>
                            </a>
                            <a href='edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-info'>Edit</button>
                            </a>
                            <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-danger'>Delete</button>
                            </a>
                        </div><br><br>
                    ";
                } else {
                    echo "
                        <div id='own_posts'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3>
                                        <a style='text-decoration:none; cursor:pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4>
                                        <small style='color:black;'>Update a post on <strong>$post_date</small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                     <h3><p>" . nl2br($content) . "</p></h3>
                                </div>
                            </div><br>

                        
                    ";

                    global $con;

                    if(isset($_GET['u_id'])) {
                        $u_id =  intval(mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['u_id'])))));
                    }

                    $get_posts = "select user_email from users where user_id='$u_id'";
                    $run_user = mysqli_query($con, $get_posts);
                    $row = mysqli_fetch_array($run_user);
                    $user_email = $row['user_email'];

                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email='$user'";
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);

                    $user_id = $row['user_id'];
                    $u_email = $row['user_email'];

                    if ($u_email != $user_email) {
                        echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    } else {
                        echo "
                            <a href='single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-success'>View</button><br>
                            </a>
                            <a href='edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-info'>Edit</button>
                            </a>
                            <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-danger'>Delete</button>
                            </a></div><br><br>
                        ";
                    }
                }

                include_once ("functions/delete_post.php");
            }
        ?>
    </div>

    <div class="col-sm-2">

    </div>

</div>
</body>
</html>