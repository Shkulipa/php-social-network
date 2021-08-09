<?php

$get_id = mysqli_real_escape_string($con, htmlentities(trim($_GET['post_id'])));

$get_com = "select * from comments where post_id='$get_id' ORDER by 1 DESC";

$run_com = mysqli_query($con, $get_com);

while ($row = mysqli_fetch_array($run_com)) {
    $com = $row['comment'];
    $user_id = $row['user_id'];
    $date = $row['date_post'];


    $get_user = "select * from users where user_id='$user_id'";
    $run_user = mysqli_query($con, $get_user);
    $row_user = mysqli_fetch_array($run_user);
    $com_author_name = $row_user['user_name'];
    $com_author_id = $row_user['user_id'];
    $com_author_img = $row_user['user_image'];

/*    echo "<pre>";
    print_r($row_user);
    echo "</pre>";*/


    echo "
        <div class='row'>
            <div class='col-md-6 col-md-offset-3'>
                <div class='panel panel-info'>
                    <div class='panel-body'>
                        <div>
                            <h4 style='text-align: left'>   
                                <div style='margin-bottom: 15px; font-size: 16px'>
                                   <a href='user_profile.php?u_id=$com_author_id'><b>$com_author_name</b></a> <i>commented</i> on $date
                                </div>
                                <p class='text-primary' style='margin-left: 5px; font-size: 20px; text-align: left'>$com</p>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
}