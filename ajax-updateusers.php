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

if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['permission']) && isset($_POST['id'])){
    $name = prepareDBVariables('name');   
    $password = prepareDBVariables('password');
    $permission = prepareDBVariables('permission');
    $id = prepareDBVariables('id');

    DB::startTransaction();
        
    if($name && $password == ""){
        DB::update("users", [
            'userPermission' => $permission
        ], "userID = %i", $id);
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        DB::update("users", [
            'userName' => $name,
            'userPassword' => $hashedPassword,
            'userPermission' => $permission
        ], "userID = %i", $id);
    }
    
    $isSuccess = DB::affectedRows();
    
    if($isSuccess){
        DB::commit();
        echo "User updated successfully!";
    } else {
        DB::rollback();
        echo "Error occurred. Please update again.";
    }
} else {
    header("Location: " . SITE_URL . "users.php");
}
?>