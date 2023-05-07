<?php

function sweetAlert($type, $title, $msg, $duration){
	echo "<script>Swal.fire({
            icon: '$type',
			title: '$title',
			text: '$msg',
			timer: $duration,
			customClass: {
				confirmButton: 'btn btn-primary'
			},
			buttonsStyling: false
		});</script>";
}

function sweetAlertReload($type, $title, $msg, $duration){
	echo "<script>Swal.fire({
            icon: '$type',	
            title: '$title',
			text: '$msg',
			timer: $duration,
			customClass: {
				confirmButton: 'btn btn-primary'
			},
			buttonsStyling: false
		}).then(function() {
			window.location = window.location.href;
		});</script>";
}

function sweetAlertRedirect($type, $title, $msg, $duration, $redirect){
	echo "<script>Swal.fire({
            icon: '$type',	
            title: '$title',
			text: '$msg',
			timer: $duration,
			customClass: {
				confirmButton: 'btn btn-primary'
			},
			buttonsStyling: false
		}).then(function() {
			window.location.href = '$redirect';
		});</script>";
}

function alertReload($message){
	echo "<script language='JavaScript'>window.alert('$message'); window.location=window.location.href;</script>";
}

function alertWindow($message){
	echo "<script language='JavaScript'>window.alert('" . $message . "')</script>";
}

function alertRedirect($message, $redirectURL){
	echo "<script language='JavaScript'>window.alert('$message');window.location='$redirectURL'</script>";
}

function setCookies($userID){
	setcookie("userID", $userID, time() + (86400 * 30)); #86400 = 1 day * 30 = 30 days
    setcookie("isLoggedIn", true, time() + (86400 * 30)); #86400 = 1 day * 30 = 30 days
}

function unsetCookies(){
	setcookie("userID", "", time() - 3600); # delete the cookie for userEmail
	setcookie("isLoggedIn", "", time() - 3600); # delete the cookie for isLoggedIn	
}

function isLoggedIn(){
    if(isset($_COOKIE['userID']) && isset($_COOKIE['isLoggedIn'])){
      $userQuery = DB::query("SELECT * FROM user WHERE userID=%i", $_COOKIE['userID']);
      $userCount = DB::count();
      if($userCount == 1){
          return true; //is logged in
      } else {
          return false; //is  NOT logged in
      }
    } else {
        return false; //is  NOT logged in
    }
}

function isBlankField($data){
    if(trim($data) == ""){
        return true;
    } else {
        return false;
    }
}

function prepareDBVariables($controlName, $isAllLowercase = false) {
    $var = "";
    if(isset($_POST[$controlName]) && $_POST[$controlName] != ""){
        $var = trim($_POST[$controlName]);
        $var = stripslashes($_POST[$controlName]);
        $var = htmlspecialchars($_POST[$controlName]);
    }
    if($isAllLowercase){
        $var = strtolower($var);
    }
    return $var;
}

function isAdmin(){
    if(isset($_COOKIE["userID"])){
        $userPermQuery = DB::query("SELECT * FROM user WHERE userID = %i", $_COOKIE["userID"]);
        foreach($userPermQuery as $userPermResult){
            $getUserPerm = $userPermResult["userPermission"];
        }
        if($getUserPerm == 1){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function uploadImage($name){
    $returnMsg = $didUpload = "";
    $uploadOk = 1;
    $currentDirectory = getcwd() . "/";
    $uploadDirectory = "assets/images/";

    $fileExtensionsAllowed = ['gif', 'jpg', 'jpeg', 'jfi', 'jfif', 'jif', 'png']; // These will be the only file extensions allowed 

    $fileName = $_FILES[$name]['name'];
    $fileSize = $_FILES[$name]['size'];
    $fileTmpName  = $_FILES[$name]['tmp_name'];
    $fileType = $_FILES[$name]['type'];

    // Extracting file extension
    $fileExtension = explode('.', $fileName);
    $fileExtension = end($fileExtension);
    $fileExtension = strtolower($fileExtension);

    $finalFileName = basename($fileName, "." . $fileExtension) . "." . $fileExtension;

    $uploadPath = $currentDirectory . $uploadDirectory . $finalFileName;

    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
        $returnMsg = alertWindow("This file extension is not allowed. Please upload a valid image file.");
        $uploadOk = 0;
    }

    if ($fileSize > 10000000) {
        $returnMsg = alertWindow("The file exceeds the maximum size (10MB). Please choose another file respecting the size limit.");
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        $returnMsg = alertWindow("The file " . htmlspecialchars(basename($fileName)) . " has been uploaded.");
    } else {
        $returnMsg = alertWindow("Error occurred. Please upload again.");
    }

    if($didUpload == true){
        $uploadedFile = $finalFileName;
    } else {
        $uploadedFile = "";
    }

    return array("uploadedFile" => $uploadedFile, "returnMsg" => $returnMsg);
}

?>