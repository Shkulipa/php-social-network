<?php
include_once('connectvars.php');
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Ошибка подключения к MySQL серверу');