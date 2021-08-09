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

    <!--  mystyle  -->
    <link rel="stylesheet" href="./style/style.css">
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
</style>
<body>
<div class="row">
    <div id="insert_post" class="col-sm-12">
        <center>
            <form action="home.php?id=<?php echo $user_id; ?>" method="post" id="f" enctype="multipart/form-data">
                <textarea class="form-control" id="content" rows="4" name="content" placeholder="What's in your mind?"></textarea><br>
                <label class="btn btn-warning" id="upload_image_button" for="upload_image">Select Image</label>
                <input class="inputfile" type="file" name="upload_image" size="60" id="upload_image">
                <button id="btn-post" class="btn btn-success" name="sub">Post</button>
            </form>
            <?php insertPost(); ?>
        </center>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <center>
            <h2>
                <b>News Feed</b>
            </h2>
            <?php echo get_post(); ?>
        </center>
    </div>
</div>
</body>
</html>