<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};

if(!isAdmin()){
    header("Location: " . SITE_URL . "main.php"); //redirect to dashboard
    exit();
}

if(!isset($_GET['id']) || $_GET['id'] == ""){
    #No GET parameter detected
    header('Location: ' . SITE_URL);
} else {
    #GET parameter has value
    #Delete the user
    DB::delete("users", "userID = %i", $_GET['id']);
    #Redirect the user back to dashboard
    header('Location: ' . SITE_URL . "users.php");
}
?>