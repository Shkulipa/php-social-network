<style>
    .txt-left {
        text-align: left;
    }
</style>

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'multis_shopp-market');
define('DB_PASSWORD', 'aXoWGfk6');
define('DB_NAME', 'multis_shopp-market');
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
or die('Ошибка подключения к MySQL серверу');

function insertPost(){
    if(isset($_POST['sub'])){
        global $con;
        global $user_id;

        $content = mysqli_real_escape_string($con, htmlentities(trim($_POST['content'])));
        $upload_image = $_FILES['upload_image']['name'];
        $image_tmp = $_FILES['upload_image']['tmp_name'];
        $random_number = rand(1, 100);

        if(strlen($content) > 5000){
            echo "<script>alert('Please Use 5000 or less than 5000 words!')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        }else{
            if(strlen($upload_image) >=1 && strlen($content) >= 1){
                move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
                $insert = "insert into posts (user_id, post_content, upload_image, post_date) values('$user_id', '$content', '$upload_image.$random_number', NOW())";

                $run = mysqli_query($con, $insert) or die('Ошибка Запроса');

                if($run){
                    echo "<script>alert('Your Post updated a moment ago!')</script>";
                    echo "<script>window.open('home.php', '_self')</script>";

                    $update = "update users set posts='yes' where user_id='$user_id'";
                    mysqli_multi_query($con, $update);
                }
            }else{
                if($upload_image == '' && $content == ''){
                    echo "<script>alert('Error Occured while uploading!')</script>";
                    echo "<script>window.open('home.php', '_self')</script>";
                }else{
                    if($content == ''){
                        move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
                        $insert = "insert into posts (user_id,post_content,upload_image,post_date) values ('$user_id','$content','$upload_image.$random_number',NOW())";
                        $run = mysqli_query($con, $insert) or die('Ошибка Запроса');

                        if($run){
                            echo "<script>alert('Your Post updated a moment ago!')</script>";
                            echo "<script>window.open('home.php', '_self')</script>";

                            $update = "update users set posts='yes' where user_id='$user_id'";
                            mysqli_multi_query($con, $update);
                        }

                        exit();
                    }else{
                        $insert = "insert into posts (user_id, post_content, post_date) values('$user_id', '$content', NOW())";
                        $run = mysqli_query($con, $insert) or die('Ошибка Запроса');

                        if($run){
                            echo "<script>alert('Your Post updated a moment ago!')</script>";
                            echo "<script>window.open('home.php', '_self')</script>";

                            $update = "update users set posts='yes' where user_id='$user_id'";
                            mysqli_multi_query($con, $update);
                        }
                    }
                }
            }
        }
    }
}

function get_post() {
    global $con;
    $per_page = 4;

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $per_page;

    $get_post = "SELECT * FROM posts ORDER by 1 DESC LIMIT $start_from, $per_page";

    $run_posts = mysqli_query($con, $get_post);

    while ($row_posts = mysqli_fetch_array($run_posts)) {
        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $content = substr($row_posts['post_content'], 0, 40);
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['post_date'];

        $user = "select * from users where user_id='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);

        $user_name = $row_user['user_name'];
        $user_image = $row_user['user_image'];

        if($content == "no" && strlen($upload_image) >=1 ) {
            echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                            
                        </div>
                        <div id='posts' class='col-sm-6'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3 class='txt-left'>
                                        <a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4 class='txt-left'>
                                        <small style='color: black'>
                                               Updated a post on <strong>$post_date</strong>
                                        </small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right;'>
                                <button class='btn btn-info'>Comment</button>
                            </a>
                        </div>
                        <div class='col-sm-3'>
                            
                        </div>

                </div><br><br>
                
            ";
        } else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
            echo "

                    <div class='row'>
                        <div class='col-sm-3'>
                            
                        </div>
                        <div id='posts' class='col-sm-6'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3 class='txt-left'>
                                        <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4 class='txt-left'>
                                        <small style='color: black'>
                                               Updated a post on <strong>$post_date</strong>
                                        </small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <p class='txt-left'>" . nl2br($content) . "</p>
                                    <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right;'>
                                <button class='btn btn-info'>Comment</button>
                            </a>
                        </div>
                        <div class='col-sm-3'>
                            
                        </div>
  
                </div><br><br>
            ";
        } else {
            echo "
                
                    <div class='row'>
                        <div class='col-sm-3'>
                            
                        </div>
                        <div id='posts' class='col-sm-6'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3 class='txt-left'>
                                        <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4 class='txt-left'>
                                        <small style='color: black'>
                                               Updated a post on <strong>$post_date</strong>
                                        </small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                   <h3><p class='txt-left'>$content</p></h3>
                                </div>
                            </div><br>
                            <a href='single.php?post_id=$post_id' style='float:right;'>
                                <button class='btn btn-info'>Comment</button>
                            </a>
                        </div>
                        <div class='col-sm-3'>
                            
                        </div>

                </div><br><br>
            ";
        }
    }

    include_once ("pagination.php");
}

function single_post() {
    if(isset($_GET['post_id'])) {
        global $con;

        $get_id = mysqli_real_escape_string($con, intval(htmlentities(trim($_GET['post_id']))));
        $get_posts = "select * from posts where post_id='$get_id'";
        $run_posts = mysqli_query($con, $get_posts);
        $row_posts = mysqli_fetch_array($run_posts);
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

        $user_email = $_SESSION['user_email'];
        $get_com = "select * from users where user_email='$user_email'";
        $run_com = mysqli_query($con, $get_com);
        $row_com = mysqli_fetch_array($run_com);

        $user_com_id = $row_com['user_id'];
        $user_com_name = $row_com['user_name'];

        $get_user = "select * from posts where post_id='$post_id'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);

        $p_id = $row['post_id'];

        if($p_id != $post_id) {
            echo "<script>alert('Error')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        }else{
            if($content == "no" && strlen($upload_image) >=1 ) {
                echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                            
                        </div>
                        <div id='posts' class='col-sm-6'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3 class='txt-left'>
                                        <a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4 class='txt-left'>
                                        <small style='color: black'>
                                               Updated a post on <strong>$post_date</strong>
                                        </small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                                </div>
                            </div><br>
                        </div>
                        <div class='col-sm-3'>
                            
                        </div>
                    </div><br><br>
                ";
                } else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                            
                        </div>
                        <div id='posts' class='col-sm-6'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <p>
                                        <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                    </p>
                                </div>
                                <div class='col-sm-6'>
                                    <h3 class='txt-left'>
                                        <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                    </h3>
                                    <h4 class='txt-left'>
                                        <small style='color: black'>
                                               Updated a post on <strong>$post_date</strong>
                                        </small>
                                    </h4>
                                </div>
                                <div class='col-sm-4'>
                                
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <p class='txt-left'>" . nl2br($content) . "</p>
                                    <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                                </div>
                            </div><br>
                        </div>
                        <div class='col-sm-3'>
                            
                        </div>
                    </div><br><br>
                ";
                } else {
                    echo "
                    <div id='own_posts'>
                        <div class='row'>
                            <div class='col-sm-3'>
                                
                            </div>
                            <div id='posts' class='col-sm-6'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p>
                                            <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                        </p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3 class='txt-left'>
                                            <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                        </h3>
                                        <h4 class='txt-left'>
                                            <small style='color: black'>
                                                   Updated a post on <strong>$post_date</strong>
                                            </small>
                                        </h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       <h3><p class='txt-left'>" . nl2br($content) . "</p></h3>
                                    </div>
                                </div><br>
                            </div>
                            <div class='col-sm-3'>
                                
                            </div>
                        </div>
                    </div><br><br>
                ";
            }

            include("comments.php");
            echo "
                <div class='row'>
                    <div class='col-md-6 col-md-offset-3'>
                        <div class='panel panel-info'>
                            <div class='panel-body'>
                                <form action='' method='post' class='form-inline'> 
                                    <textarea placeholder='Write your comment here!' class='pb-cmnt-textarea' name='comment'></textarea>
                                    <button class='btn btn-info pull-right' name='reply'>Comment</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>";

            if (isset($_POST['reply'])) {
                $comment = mysqli_real_escape_string($con, htmlentities(trim($_POST['comment'])));

                if($comment == "") {
                    echo "<script>alert('Enter your comment!')</script>";
                    echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
                }else{
                    $insert = "insert into comments (post_id, user_id, comment, comment_author, date_post) VALUES ('$post_id', '$user_com_id', '$comment', '$user_com_name', NOW())";
                    $run = mysqli_query($con, $insert);

                    if($run) {
                        echo "<script>alert('Your comment added!')</script>";
                        echo "<script>window.open('single.php?post_id=$post_id', '_self')</script>";
                    }
                }
            }
        }
    }
}

function search_user() {
    global $con;

    if(isset($_GET['search_user_btn'])) {
        $search_query = mysqli_real_escape_string($con, htmlentities(trim($_GET['search_user'])));
        $get_user = "select * from users where first_name like '%$search_query%' OR last_name like '%$search_query%' OR user_name like '%$search_query%'";
    } else {
        $get_user = "select * from users";
    }

    $run_user = mysqli_query($con, $get_user);
    while ($row_user = mysqli_fetch_array($run_user)) {
        $user_id = $row_user['user_id'];
        $first_name = $row_user['first_name'];
        $last_name = $row_user['last_name'];
        $user_name = $row_user['user_name'];
        $user_image = $row_user['user_image'];

        echo "
            <div class='row'>
                <div class='col-sm-3'></div>
                <div class='col-sm-6'>
                    <div class='row' id='find_people'>
                        <div class='col-sm-4'>
                            <a href='user_profile.php?u_id=$user_id'>
                                <img src='users/$user_image' alt='' width='150px' height='150px' title='$user_name' style='float: left; margin: 1px'>
                            </a>
                            
                        </div><br><br>
                        <div class='col-sm-6'>
                            <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>
                                <b><h2>$first_name $last_name</h2></b>
                            </a>
                        </div>
                        <div class='col-sm-3'></div>
                    </div>
                </div>
                <div class='col-sm-4'>
                
                </div>
            </div><br>
        ";
    }

}

function user_posts() {
    global $con;

    if(isset($_GET['u_id'])) {
        $u_id = mysqli_real_escape_string($con, htmlentities(trim($_GET['u_id'])));

        $get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
        $run_get_posts = mysqli_query($con, $get_posts);

        while($row_posts = mysqli_fetch_array($run_get_posts)) {
            $post_id = $row_posts['post_id'];
            $user_id = $row_posts['user_id'];
            $content = $row_posts['post_content'];
            $upload_image = $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];

            $user = "select * from users where user_id='$user_id' AND posts='yes'";

            $run_user = mysqli_query($con, $user);
            $row_user = mysqli_fetch_array($run_user);

            $user_email = $row_user['user_email'];
            $user_name = $row_user['user_name'];
            $user_image = $row_user['user_image'];

            if($user_email != $_SESSION['user_email']) {
                echo "<script>window.open('user_profile.php?u_id=$user_id', '_self')</script>";
            } else {
                if($content == "no" && strlen($upload_image) >=1 ) {
                    echo "
                <div class='row'>
                    <div class='col-sm-3'>
                        
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p>
                                    <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                </p>
                            </div>
                            <div class='col-sm-6'>
                                <h3 class='txt-left'>
                                    <a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                </h3>
                                <h4 class='txt-left'>
                                    <small style='color: black'>
                                           Updated a post on <strong>$post_date</strong>
                                    </small>
                                </h4>
                            </div>
                            <div class='col-sm-4'>
                            
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                            </div>
                        </div><br>
                        <div class='row'>
                            <div class='col-sm-12'>
                               <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-success'>View</button>
                                </a>
                                <a href='../edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                    <button class='btn btn-info'>Edit</button>
                                </a>
                                <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                    <button class='btn btn-danger'>Delete</button>
                                </a>
                            </div>
                        </div><br>
                    </div>
                    <div class='col-sm-3'>
                        
                    </div>
                </div><br><br>
            ";
                } else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
                    echo "
                <div class='row'>
                    <div class='col-sm-3'>
                        
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p>
                                    <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                </p>
                            </div>
                            <div class='col-sm-6'>
                                <h3 class='txt-left'>
                                    <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                </h3>
                                <h4 class='txt-left'>
                                    <small style='color: black'>
                                           Updated a post on <strong>$post_date</strong>
                                    </small>
                                </h4>
                            </div>
                            <div class='col-sm-4'>
                            
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <p class='txt-left'>" . nl2br($content) . "</p>
                                <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                            </div>
                        </div><br>
                        <div class='row'>
                            <div class='col-sm-12'>
                               <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                <button class='btn btn-success'>View</button>
                                </a>
                                <a href='../edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                    <button class='btn btn-info'>Edit</button>
                                </a>
                                <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                    <button class='btn btn-danger'>Delete</button>
                                </a>
                            </div>
                        </div><br>
                    </div>
                    <div class='col-sm-3'>
                        
                    </div>
                </div><br><br>
            ";
                } else {
                    echo "
                    <div id='own_posts'>
                        <div class='row'>
                            <div class='col-sm-3'>
                                
                            </div>
                            <div id='posts' class='col-sm-6'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p>
                                            <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                        </p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3 class='txt-left'>
                                            <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                        </h3>
                                        <h4 class='txt-left'>
                                            <small style='color: black'>
                                                   Updated a post on <strong>$post_date</strong>
                                            </small>
                                        </h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       <h3><p class='txt-left'>" . nl2br($content) . "</p></h3>
                                    </div>
                                </div><br>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                        <button class='btn btn-success'>View</button>
                                        </a>
                                        <a href='../edit_post.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                            <button class='btn btn-info'>Edit</button>
                                        </a>
                                        <a href='functions/delete_post.php?post_id=$post_id&user_id=$user_id' style='float:right; margin-left: 10px;'>
                                            <button class='btn btn-danger'>Delete</button>
                                        </a>
                                    </div>
                                </div><br>
                            </div>
                            <div class='col-sm-3'>
                                
                            </div>
                        </div>
                    </div><br><br>
                ";
                }
            }
        }
    }
}

function results() {
    global $con;

    if(isset($_GET['search'])) {
        $search_query = mysqli_real_escape_string($con, htmlentities(trim($_GET['user_query'])));
    }

    $get_posts = "select * from posts where post_content like '%$search_query%' OR upload_image like '%$search_query%'";

    $run_posts = mysqli_query($con, $get_posts);


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

        if($content == "no" && strlen($upload_image) >=1 ) {
            echo "
                <div class='row'>
                    <div class='col-sm-3'>
                        
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p>
                                    <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                </p>
                            </div>
                            <div class='col-sm-6'>
                                <h3 class='txt-left'>
                                    <a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                </h3>
                                <h4 class='txt-left'>
                                    <small style='color: black'>
                                           Updated a post on <strong>$post_date</strong>
                                    </small>
                                </h4>
                            </div>
                            <div class='col-sm-4'>
                            
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                            </div>
                        </div><br>
                        <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                            <button class='btn btn-info'>View</button>
                        </a>
                    </div>
                    <div class='col-sm-3'>
                        
                    </div>
                </div><br><br>
            ";
        } else if(strlen($content) >= 1 && strlen($upload_image) >= 1) {
            echo "
                <div class='row'>
                    <div class='col-sm-3'>
                        
                    </div>
                    <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p>
                                    <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                </p>
                            </div>
                            <div class='col-sm-6'>
                                <h3 class='txt-left'>
                                    <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                </h3>
                                <h4 class='txt-left'>
                                    <small style='color: black'>
                                           Updated a post on <strong>$post_date</strong>
                                    </small>
                                </h4>
                            </div>
                            <div class='col-sm-4'>
                            
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <p class='txt-left'>" . nl2br($content) . "</p>
                                <img id='posts-img' src='../imagepost/$upload_image' style='height: 350px;' alt=''>
                            </div>
                        </div><br>
                        <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                            <button class='btn btn-info'>View</button>
                         </a>
                    </div>
                    <div class='col-sm-3'>
                        
                    </div>
                </div><br><br>
            ";
        } else {
            echo "
                    <div id='own_posts'>
                        <div class='row'>
                            <div class='col-sm-3'>
                                
                            </div>
                            <div id='posts' class='col-sm-6'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p>
                                            <img src='users/$user_image' class='img-circle' width='100px' height='100px' alt=''>
                                        </p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3 class='txt-left'>
                                            <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a>
                                        </h3>
                                        <h4 class='txt-left'>
                                            <small style='color: black'>
                                                   Updated a post on <strong>$post_date</strong>
                                            </small>
                                        </h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       <h3><p class='txt-left'>" . nl2br($content) . "</p></h3>
                                    </div>
                                </div><br>
                                <a href='../single.php?post_id=$post_id' style='float:right; margin-left: 10px;'>
                                    <button class='btn btn-info'>View</button>
                                </a>
                            </div>
                            <div class='col-sm-3'>
                                
                            </div>
                        </div>
                    </div><br><br>
                ";
        }
    }
}

?>