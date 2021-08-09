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
    <title>Search Posts of results </title>
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
<body>
<div class="row">
    <center><h2>See Your results here!</h2></center>
    <?php results(); ?>
</div>
</body>
</html>
