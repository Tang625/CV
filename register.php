<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php");
    exit();
}

$error = $errorReload = $warning = $successRedirect = "";

if(isset($_POST['register'])){ # if the form is submitted
    $email = $_POST['email'];
    $domain = isset(explode('ecogreat@', $email)[1]);
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $permission = $_POST['permission'];

    if(isBlankField($email) || isBlankField($userName)){
        $warning = "Please make sure that all the empty fields have been filled in.";
    } else {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            if($domain == 'gmail.com'){
                if(!isBlankField($password)){
                    if($password == $confirmPassword){
                        
                        $userQuery = DB::query("SELECT * FROM users WHERE userEmail = %s", $email);
                        $userCount = DB::count();
                        
                        if($userCount == 0){
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            DB::startTransaction();
                            DB::insert("users", [
                                'userEmail' => $email,
                                'userName' => $userName,
                                'userPassword' => $hashedPassword,
                                'userPermission' => $permission
                            ]);
                
                            $newUserID = DB::insertId();
                            $isSuccess = DB::affectedRows();
                            
                            
                            if ($isSuccess) {
                                DB::commit();
                                $successRedirect = "New user created! Welcome.";
                            } else {
                                DB::rollback();
                                $errorReload = "Error occurred. Please register again.";
                            }
                
                        } else {
                            $warning = "The user already exists. Please confirm.";
                        }
                    } else {
                        $error = "The password does not match. Please check it.";
                    }
                } else {
                    $warning = "The password was empty. Please fill it in.";
                }
            } else {
                $errorReload = "This is not a registered email. Please contact the administrator for help.";
            }    
        } else {
            $errorReload = "Invalid email. Please confirm.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-User Register</title>
    <link rel="icon" href="assets/images/eco-icon.ico">

    <?php include 'templates/styles.php'; ?>
</head>

<body>
    <div class="container">
        <div class="col-lg-12" style="text-align: center;">
            <img src="assets/images/ecogreat-03.png" alt="logo"/>
        </div>
        <p class="subTitle topLine" style="text-align: center;">ECOGreat Clock System - User Register</p><br>
        <h3 style="text-align: center;">Please enter the following details for a new user:</h3>
        <form method="POST" class="form-insert">
            <div class="mb-3 div-insert">
                <label for="floatingInput" class="form-label">User Email</label>
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
            </div>
            <div class="mb-3 div-insert">
                <label for="floatingInput" class="form-label">User Name</label>
                <input type="text" name="userName" class="form-control" id="floatingInput" placeholder="User Name" value="<?php if(isset($_POST['userName'])){ echo $_POST['userName']; } ?>">
            </div>
            <div class="mb-3 div-insert">
                <label for="floatingPassword" class="form-label">User Password</label>
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            </div>
            <div class="mb-3 div-insert">
                <label for="floatingPassword" class="form-label">Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control" id="floatingPassword" placeholder="Confirm Password">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputPermission" class="form-label">User Permission</label>
                <select class="form-select" name="permission" id="inputPermission">
                    <option value="" selected>Please select a permission</option>    
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <div class="div-insert">
                <button class="btn btn-primary" name="register" type="submit">Register
                </button>
                <a href="users.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <?php
    include 'templates/scripts.php';
    
    if($error){
        sweetAlert("error", "Opps...", $error, 6000);
    }

    if($errorReload){
        sweetAlertReload("error", "Opps...", $errorReload, 6000);
    }

    if($warning){
        sweetAlert("warning", "Hi there!", $warning, 6000);
    }

    if($successRedirect){
        sweetAlertRedirect("success", "Great!", $successRedirect, 6000, "user.php");
    }
    ?>
</body>

</html>