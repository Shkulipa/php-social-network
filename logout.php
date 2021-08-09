<?php

session_start();

$_SESSION['user_email'] = '';

session_destroy();

header("location: index.php");
