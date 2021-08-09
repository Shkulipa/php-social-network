<?php
session_start();
if($_SESSION['user_email'] != '') {
    echo "<script>window.open('home.php', '_self')</script>";
} else {
    session_destroy();
    include_once ("main.php");
}
?>