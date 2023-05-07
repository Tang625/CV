<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};

$isLoggedIn = $_COOKIE["isLoggedIn"];

if($isLoggedIn == 0){ #if user is not logged in
    #redirect back to login page
    header("Location: login.php");
    exit(); 
}

unsetCookies();

header("Location: login.php");
exit();
?>