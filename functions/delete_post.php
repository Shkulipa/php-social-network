<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'multis_shopp-market');
define('DB_PASSWORD', 'aXoWGfk6');
define('DB_NAME', 'multis_shopp-market');
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
or die('Ошибка подключения к MySQL серверу');

if(isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_GET['user_id'];

    $delete_post = "delete from posts where post_id='$post_id'";
    $run_delete = mysqli_query($con, $delete_post);

    if($run_delete) {
        echo "<script>alert('A post have been deleted!')</script>";
        echo "<script>window.open('../profile.php?u_id=$user_id', '_self')</script>";
    }
}

