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
      $userQuery = DB::query("SELECT * FROM users WHERE userID=%i", $_COOKIE['userID']);
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
        $userPermQuery = DB::query("SELECT * FROM users WHERE userID = %i", $_COOKIE["userID"]);
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