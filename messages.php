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
    <title>Messages</title>
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
    #loaded_msg-u {
        display: flex;
        justify-content: flex-end;
    }
    #loaded_msg-other {
        display: flex;
        justify-content: flex-start;
    }
    .message {
        width: 45%;
    }
    .message-content{
        display: flex;
        align-items: center;
    }
    .message-content div form {
        display: flex;
        justify-content: center;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #scroll_messages{
        max-height: 80%;
        overflow: scroll;
    }
    #btn-msg{
        width: 20%;
        height: 28px;
        border-radius: 5px;
        margin: 5px;
        border: none;
        color: #fff;
        float: right;
        background-color: #2ecc71;
    }
    #select_user{
        max-height: 500px;
        overflow: scroll;
    }
    #green, #blue {
        background-color: #2ecc71;
        border-color: #27ae60;
        width: 45%;
        padding: 2.5px;
        font-size: 16px;
        border-radius: 3px;
        float: right;
        margin-bottom: 5px;
    }
    #blue {
         background-color: #3498db;
         border-color: #2980b9;
     }
</style>
<body>
<div class="row">
    <?php
        if(isset($_GET['u_id'])) {
            global $con;

            $get_id = mysqli_real_escape_string($con, htmlentities(trim($_GET['u_id'])));

            $get_user = "select * from users where user_id='$get_id'";

            $run_user = mysqli_query($con, $get_user);

            $row_user = mysqli_fetch_array($run_user);

            $user_to_msg = $row_user['user_id'];
            $user_to_name = $row_user['user_name'];
        }

        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email='$user'";

        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);

        $user_from_msg = $row['user_id'];
        $user_from_name = $row['user_name'];
    ?>

    <div class="col-sm-3" id="select_user" style="margin-top: 15px;">
        <?php
            $user = "select * from users";

            $run_user = mysqli_query($con, $user);

            while($row_user = mysqli_fetch_array($run_user)) {
                $user_id = $row_user['user_id'];
                $user_name = $row_user['user_name'];
                $first_name = $row_user['first_name'];
                $last_name = $row_user['last_name'];
                $user_image = $row_user['user_image'];

                echo "
                    <div class='container-fluid'>
                        <a style='text-decoration: none; cursor:pointer;color:#3897f0;' href='messages.php?u_id=$user_id'>
                        <img class='img-circle' src='users/$user_image' width='90px' height='90px' title='$user_name' alt=''><b>&nbsp $first_name $last_name</b><br><br>
                        </a>
                    </div> 
                ";
            }
        ?>
    </div>
    <div class="col-sm-6">
        <div class="load_msg" id="scroll_messages">
            <?php
                $sel_msg = "select * from user_messages where (user_to='$user_to_msg' AND user_from='$user_from_msg') OR (user_from='$user_to_msg' AND user_to='$user_from_msg') ORDER by 1 ASC";
                $run_msg = mysqli_query($con, $sel_msg);

                while($row_msg = mysqli_fetch_array($run_msg)) {
                    $msg_id = $row_msg['id'];
                    $user_to = $row_msg['user_to'];
                    $user_from = $row_msg['user_from'];
                    $msg_body = $row_msg['msg_body'];
                    $msg_date = $row_msg['date_msg'];

                    if($user_to == $user_to_msg && $user_from == $user_from_msg) {
                        echo "
                            <div id='loaded_msg-u'>
                                <div class='message' style='margin: 5px;' id='blue' data-toggle='tooltip' title='$msg_date'>
                                    <div class='row message-content' style='padding: 5px'>
                                        <div class='col-sm-9'>$msg_body</div>
                                        <div class='col-sm-3'>
                                            <form action='' method='post'>
                                                <input type='hidden' name='msg_id' value='$msg_id'>
                                                <input class='btn btn-danger' type='submit' name='delete_msg' value='Delete'>
                                            </form>
                                        </div>
                                    </div>
                                </div><br><br>
                            </div>
                        ";
                    } else if ($user_to == $user_from_msg && $user_from == $user_to_msg){
                        echo "
                            <div id='loaded_msg-other'>
                                <div class='message' style='margin: 5px;' id='green' data-toggle='tooltip' title='$msg_date'>
                                    $msg_body
                                </div><br><br>
                            </div>
                        ";
                    }
               }

                if(isset($_POST['delete_msg'])) {
                    $post_id = mysqli_real_escape_string($con, htmlentities(trim($_POST['msg_id'])));
                    $req = "delete from user_messages where id='$post_id'";
                    mysqli_query($con, $req);

                    echo "<script>window.open('messages.php?u_id=$user_to_msg', '_self')</script>";
                }
            ?>
        </div>

        <?php
            if(isset($_GET['u_id'])) {
                $u_id = mysqli_real_escape_string($con, htmlentities(trim($_GET['u_id'])));
                if($u_id == 'new') {
                    echo '
                        <form>
                            <center><h3>Select Someone to start conversation</h3></center>
                            <textarea disabled class="form-control" placeholder="Enter your Message" style="margin-bottom: 15px" name=""></textarea>
                            <input type="submit" class="btn btn-default" disabled value="Send">
                        </form><br><br>
                    ';
                } else {
                    echo '
                        <form action="" method="post">
                            <textarea  class="form-control" placeholder="Enter your Message" name="msg_box" style="margin-bottom: 15px" id="message_textarea"></textarea>
                            <input name="send_msg" type="submit" id="btn-msg" class="btn btn-default"  value="Send">
                        </form><br><br>
                    ';
                }
            }
        ?>

        <?php
            if(isset($_POST['send_msg'])) {
                $msg = mysqli_real_escape_string($con, htmlentities(trim($_POST['msg_box'])));

                if($msg == "") {
                    echo "
                        <h4 style='color: red; text-align: center;'>Message was unable to send</h4>
                    ";
                } else if (strlen($msg) > 37) {
                    echo "
                        <h4 style='color: red; text-align: center;'>Message is too long! Use only 37 characters</h4>
                    ";
                } else {
                    $insert_1 = "insert into user_messages (user_to, user_from, msg_body, date_msg, msg_seen) VALUES ('$user_to_msg', '$user_from_msg', '$msg', NOW(), 'no')";
                    $run_insert_1 = mysqli_query($con, $insert_1) or die('Ошибка запроса');

                    echo "<script>window.open('messages.php?u_id=$user_to_msg', '_self')</script>";
                }
            }
        ?>
    </div>
    <div class="col-sm-3">
        <?php
            if(isset($_GET['u_id'])) {
                global $con;

                $get_id = mysqli_real_escape_string($con, htmlentities(trim($_GET['u_id'])));

                $get_user = "select * from users where user_id='$get_id'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);

                $user_id = $row['user_id'];
                $user_name = $row['user_name'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $describe_user = $row['describe_user'];
                $user_country = $row['user_country'];
                $user_image = $row['user_image'];
                $register_date = $row['user_reg_date'];
                $gender = $row['user_gender'];
            }

            if($get_id == 'new') {

            } else {
                echo "
                    <div class='row' style='margin-top: 15px'>
                        <div class='col-sm-2'>
                        </div>
                        <center>
                        <div style='background-color: #e6e6e6;' class='col-sm-9'>
                            <h2>Information About</h2>
                            <img class='img-circle' src='users/$user_image' width='150' height='150' alt=''>
                            <br><br>
                            <ul class='list-group'>
                                <li class='list-group-item' title='Username'>
                                    <b>$first_name $last_name</b>
                                </li>
                                <li class='list-group-item' title='User status'>
                                    <b style='color:grey;'>$describe_user</b>
                                </li>
                                <li class='list-group-item' title='Gender'>
                                    $gender
                                </li>
                                <li class='list-group-item' title='Country'>
                                    $user_country
                                </li>
                                <li class='list-group-item' title='User Registration Date'>
                                    $register_date
                                </li>
                            </ul>
                        </div>
                        <div class='col-sm-1'></div>
                        </center>
                    </div> 
                ";
            }
        ?>
    </div>

</div>
</body>

<script>
    let div = document.getElementById("scroll_messages");
    div.scrollTop = div.scrollHeight;
</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script src="./script/script.js"></script>-->

</html>