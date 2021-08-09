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
    <title>Find people</title>
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
    <div class="col-sm-12">
        <center><h2>Find New People</h2></center><br><br>
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <form action="" class="search_form">
                    <input type="text" placeholder="Search Friend" name="search_user">
                    <button class="btn btn-info" type="submit" name="search_user_btn">Search</button>
                </form>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <br><br>
        <?php
            search_user();
        ?>
    </div>
</div>
</body>
</html>