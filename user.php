<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};

if(!isAdmin()){
    header("Location: " . SITE_URL . "index.php"); //redirect to dashboard
    exit();
}

$userID = $_COOKIE["userID"];

// Query user info from DB
$userQuery = DB::query("SELECT * FROM user WHERE userID = %i", $userID);
foreach($userQuery as $userResult){
    $userEmail = $userResult["userEmail"];
    $userName = $userResult["userName"];
    $userPermission = $userResult["userPermission"];
}

// Setting permission text
if($userPermission == 1){
    $userPermissionText = "Admin";
}else if($userPermission == 0){
    $userPermissionText = "User";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-User Management</title>
    <link rel="icon" href="assets/images/g-pack.ico">

    <?php include 'templates/styles.php'; ?>
</head>

<body id="page2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 logo-line">
                <h1>
                    <img src="assets/images/g-pack-2.png" alt="logo"/>en Pack
                    Enterprise
                </h1>
            </div>
            <div class="col-md-12 dashboard">
                <h1 class="h3 fw-normal myAdmin-line">Gen Pack MyAdmin</h1><br>
                <h4 class="ml11">
                    <span class="text-wrapper">
                        <span class="line line1"></span>
                        <span class="letters">Welcome Admin! You may edit the user's details here.</span>
                    </span>
                </h4>
                <p>Admin ID: <?php echo $userID; ?></p>
                <p>Admin Name: <?php echo $userName; ?></p>
                <p>Admin Email: <?php echo $userEmail; ?></p>
                <a href="logout.php" style="margin-bottom: 15px;" class="btn btn-danger">Logout</a>
                <a href="index.php" style="margin-bottom: 15px;" class="btn btn-success">To Index Page
                </a>
            </div>
            
            <div class="col-md-12">
                <a href="register.php" style="margin-bottom: 15px;" class="btn btn-primary">Register New User</a>

                <div class="chart"></div>

                <table class="table display table-primary table-hover" id="allUsers">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">User Permission</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $getAllUserQuery = DB::query("SELECT * FROM user");
                            foreach($getAllUserQuery as $getAllUserResult){
                                echo '<tr>';
                                    echo '<th scope="row">' . $getAllUserResult['userID'] . '</th>';
                                    echo '<td>' . $getAllUserResult['userName'] . '</td>';
                                    echo '<th scope="row">' . $getAllUserResult['userEmail'] . 
                                    '</th>';
                                    echo '<td>' . $getAllUserResult['userPermission'] . '</td>';
                                    echo '<td>
                                            <a style="margin-right: 5px;" href="updateuser.php?id=' . $getAllUserResult['userID'] . '"><ion-icon name="create-outline"></ion-icon></a>
                                            <a onclick="return confirm(\'Are you sure you want to delete this user?\')" href="deleteuser.php?id=' . $getAllUserResult['userID'] . '"><ion-icon name="trash-outline"></ion-icon></a>
                                        </td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'templates/script.php'; ?>

    <script>
        $(document).ready( function () {
            $('#allUsers').DataTable();
        } );
    </script>
</body>

</html>