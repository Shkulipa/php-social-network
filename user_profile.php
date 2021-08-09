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
    <title>User Profile</title>
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
    #own_posts{
        border: 5px solid #e6e6e6;
        padding: 40px 50px;
        width: 90%;
    }

    #posts-img {
        height: 300px;
        width: 100%;
    }
</style>

<body>
<div class="row">
    <?php
        if(isset($_GET['u_id'])) {
            $u_id = mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['u_id']))));
        }
        if($u_id < 0 || $u_id == "") {
            echo "<script>window.open('home.php', '_self')</script>";
        }
    ?>
    <div class="col-sm-12">
        <?php
            if(isset($_GET['u_id'])) {
                global $con;

                $select = "select * from users where user_id='$u_id'";
                $run = mysqli_query($con, $select);
                $row = mysqli_fetch_array($run);

                $name = $row['user_name'];
            }
        ?>

        <?php
            if(isset($_GET['u_id'])) {
                global $con;
                $user_id = mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['u_id']))));
                $select = "select * from users where user_id='$user_id'";
                $run = mysqli_query($con, $select);
                $row = mysqli_fetch_array($run);

                $id = $row['user_id'];
                $image = $row['user_image'];
                $name = $row['user_name'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $describe_user = $row['describe_user'];
                $country = $row['user_country'];
                $gender = $row['user_gender'];
                $register_date = $row['user_reg_date'];

                echo "
                    <div class='row'>
                    <br>
                        <div class='col-sm-1'></div>
                        <center>
                            <div style='background-color: #e6e6e6;' class='col-sm-3'>
                                <h2>Information about</h2>
                                <img class='img-circle' src='users/$image' width='150' height='150' alt=''>
                                <br><br>
                                <ul class='list-group'>
                                    <li class='list-group-item' title='Username'><b>$first_name $last_name</b></li>
                                    <li class='list-group-item' title='User Status'><b style='color:grey;'>$describe_user</b></li>
                                    <li class='list-group-item' title='Gender'><b>$gender</b></li>
                                    <li class='list-group-item' title='Country'><b>$user_country</b></li>
                                    <li class='list-group-item' title='User Registration Date'><b>$register_date</b></li>
                                </ul>
                ";

                $user_email = $_SESSION['user_email'];
                $get_user = "select * from users where user_email='$user_email'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);

                $userown_id = $row['user_id'];

                if($user_id == $userown_id) {
                    echo "<a href='edit_profile.php?u_id=$userown_id' class='btn btn-success'>Edit profile</a><br><br><br>";
                }

                echo "
                            </div>
                        </center>
                ";
            }
        ?>
        <div class="col-sm-8">
            <center><h1><b><?php echo "$first_name $last_name"; ?></b></h1></center>

            <?php
                global $con;

                if(isset($_GET['u_id'])) {
                    $u_id = mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['u_id']))));
                }

                $get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
                $run_posts = mysqli_query($con, $get_posts);

                while($row_posts = mysqli_fetch_array($run_posts)) {
                    $post_id = $row_posts['post_id'];
                    $user_id = $row_posts['user_id'];
                    $content = $row_posts['post_content'];
                    $upload_image = $row_posts['upload_image'];
                    $post_date = $row_posts['post_date'];

                    $user = "select * from users where user_id='$user_id' AND posts='yes'";

                    $run_user = mysqli_query($con, $user);
                    $row_user = mysqli_fetch_array($run_user);

                    $user_name = $row_user['user_name'];
                    $first_name = $row_user['first_name'];
                    $last_name = $row_user['last_name'];
                    $user_image = $row_user['user_image'];

                    if ($content == 'No' && strlen($upload_image) >= 1) {
                        echo "
                            <div id='own_posts'>    
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p><img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''></p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3><a style='text-decoration: none;cursor:pointer;color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                        <h4><small style='color: black'>Updated a post on <b>$post_date</b></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <img id='posts-img' src='imagepost/$upload_image' style='height: 350px' alt=''>
                                    </div>
                                </div><br>
                                <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
                            </div><br><br>
                        ";
                    } else if (strlen($content) >= 1 && strlen($upload_image) >= 1) {
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
                                    <h3><p>$content</p></h3>
                                    <img id='posts-img' src='imagepost/$upload_image' style='height:350px' alt=''>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
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
                                         <h3><p>$content</p></h3>
                                    </div>
                                </div><br>
                                <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
                             </div>
                        ";
                    }
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>