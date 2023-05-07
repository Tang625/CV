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
    header('Location: main.php');
} else {
    #GET parameter is detected
    $getUserQuery = DB::query("SELECT * FROM users WHERE userID = %i", $_GET['id']);
    foreach($getUserQuery as $getUserResult){
        $dbUserEmail = $getUserResult["userEmail"];
        $dbUserName = $getUserResult["userName"];
        $dbUserPermission = $getUserResult["userPermission"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-User Update</title>
    <link rel="icon" href="assets/images/eco-icon.ico">

    <?php include 'templates/styles.php'; ?>
</head>

<body>
    <div class="container">
        <div class="col-lg-12" style="text-align: center;">
            <img src="assets/images/ecogreat-03.png" alt="logo"/>
        </div>
        <p class="subTitle topLine" style="text-align: center;">ECOGreat Clock System - User Update</p><br>
        <h3 style="text-align: center;">Please update the user details below:</h3>
        <div style="display: none;" class="alert alert-danger" id="error" role="alert"></div>
        <div style="display: none;" class="alert alert-primary" id="success" role="alert"></div>
        <form class="form-insert">
            <input type="text" id="id" value="<?php echo $_GET['id']; ?>" hidden>
            <div class="mb-3 div-insert">
                <label for="inputEmail" class="form-label">User Email</label>
                <input type="email" class="form-control" id="inputEmail" value="<?php echo $dbUserEmail; ?>" aria-describedby="emailHelp" disabled>
                <div id="emailHelp" class="form-text">User email was not allowed to be changed. Please contact the administrator if necessary.</div>
            </div>
            <div class="mb-3 div-insert">
                <label for="inputName" class="form-label">User Name</label>
                <input type="text" class="form-control" id="inputName" value="<?php echo $dbUserName; ?>">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputPassword" class="form-label">User Password</label>
                <input type="password" class="form-control" id="inputPassword">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputPermission" class="form-label">User Permission</label>
                <select class="form-select" id="inputPermission">
                    <option value="0" <?php if($dbUserPermission == 0){ echo "selected"; } ?>>User
                    </option>
                    <option value="1" <?php if($dbUserPermission == 1){ echo "selected"; } 
                    ?>>Admin</option>
                </select>
            </div>
            <div class="div-insert">
                <button type="submit" id="updateUser" class="btn btn-primary">Update User</button>
                <a href="users.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <?php include 'templates/scripts.php'; ?>

    <script>
    $(document).ready(function(){
        $("form").submit(function(e){
            e.preventDefault(e);
        });

        $("#updateUser").click(function(){
            var name = $("#inputName").val();
            var password = $("#inputPassword").val();
            var permission = $("#inputPermission").val();
            var id = $("#id").val();

            $.ajax({
                url: 'ajax-updateusers.php', //action
                method: 'POST', //method
                data:{
                    id: id,
                    name: name,
                    password: password,
                    permission: permission,
                },
                success:function(data){
                    if(data != "User updated successfully!"){
                        //Insert NOT successful
                        $("#success").hide();
                        $("#error").text(data).show();
                        $("#inputName").val(name);
                        window.parent.parent.scrollTo(0, 0);
                    } else {
                        //Insert successful
                        $("#error").hide();
                        $("#success").text(data).show();
                        $("form")[0].reset(); //reset the form
                        window.parent.parent.scrollTo(0, 0);
                    }
                }
            });
        });
    });
    </script>
</body>

</html>