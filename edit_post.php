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
    <title>Edit post</title>

</head>
<body>
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <?php
                if (isset($_GET['post_id'])) {
                    $int_post_id = intval(htmlentities(trim($_GET['post_id'])));
                    $post_id =  mysqli_real_escape_string($con, $int_post_id);

                    if(is_string($post_id) && is_numeric($int_post_id)) {
                        $get_post = "select * from posts where post_id='$post_id'";
                        $run_post = mysqli_query($con, $get_post);
                        $row = mysqli_fetch_array($run_post);

                        $post_con = $row['post_content'];
                    } else {
                        echo "<script>alert('Something went wrong')</script>";
                    }
                }
            ?>
            <form action="" method="post" id="f" enctype="multipart/form-data">
                <center>
                    <h2>Edit your Post:</h2><br>
                    <textarea class="form-control" rows="4" name="content"><?php echo $post_con; ?></textarea><br>
                    <input type="file" name="update_image[]" multiple value="Update Image" class="btn btn-success" style="margin-bottom: 15px">
                    <input type="submit" name="update" value="Update Post" class="btn btn-info">
                </center>
            </form>

            <?php
            if(isset($_POST['update'])) {
                $content = mysqli_real_escape_string($con, htmlentities(trim($_POST['content'])));
                $upload_image =  mysqli_real_escape_string($con, htmlentities(trim($_FILES['update_image']['name'][0])));
                $image_type =  mysqli_real_escape_string($con, htmlentities(trim($_FILES['update_image']['type'][0])));
                $image_tmp = htmlentities(trim($_FILES['update_image']['tmp_name'][0]));
                $random_number = rand(1, 100);


                if(strlen($upload_image) >= 1 && (($image_type == 'image/jpeg') || ($image_type == 'image/png') || ($image_type == 'image/gif'))) {
                    move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
                    $update_post = "update posts set post_content='$content', upload_image='$upload_image.$random_number' where post_id='$post_id'";
                    $run_update = mysqli_query($con, $update_post);

                    if($run_update) {
                        echo "<script>alert('A Post have been Updated!')</script>";
                        echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    }
                } else if ( strlen($upload_image) >= 1 && (($image_type != 'image/jpeg') || ($image_type != 'image/pjpeg') || ($image_type != 'image/png') || ($image_type != 'image/gif'))) {
                    echo "<script>alert('Upload a picture format: jpeg, png or gif')</script>";
                } else {
                    $update_post = "update posts set post_content='$content' where post_id='$post_id'";
                    $run_update = mysqli_query($con, $update_post);

                    if($run_update) {
                        echo "<script>alert('A Post have been Updated!')</script>";
                        echo "<script>window.open('profile.php?u_id=$user_id', '_self')</script>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>