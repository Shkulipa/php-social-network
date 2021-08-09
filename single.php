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
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--  Bootstrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>View Your Post</title>

    <!--  mystyle  -->
    <link rel="stylesheet" href="./style/style.css">
</head>
<style>
    #posts {
        border:5px solid #e6e6e6;
        padding: 40px 50px;
    }
</style>
<body>
    <div class="row">

        <div class="col-sm-12">
            <center>
                <h2>Comments</h2><br>
                <?php single_post(); ?>
            </center>
        </div>

    </div>
</body>
</html>

