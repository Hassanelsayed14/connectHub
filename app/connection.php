<?php


$dbhost = "db";
$dbuser = "app_user";
$dbpass = "strongpassword";
$dbname = "task";


if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){

    die("failed to connect");
}

?>