<?php
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};

$successReload = $successReload2 = $errorReload = "";
$userID = $_COOKIE["userID"];

// Query user info from DB
$userQuery = DB::query("SELECT * FROM users WHERE userID = %i", $userID);
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

if(isset($_POST["timeIn"]) && $_POST["timeIn"] == "in"){
    $timeInValue = $_POST["timeIn"];
    date_default_timezone_set('Asia/Singapore');
    $currentDateTime = date("Y-m-d H:i:s");

    $clockQuery = DB::query("INSERT INTO clock (userID, clockTime, clockAction) VALUES (%i, %s, %s)", $userID, $currentDateTime, $timeInValue);

        $newClockID = DB::insertId();
        $isSuccess = DB::affectedRows();
        
        
        if ($isSuccess) {
            DB::commit();
            $successReload = "Thanks for clock in! Welcome.";
        } else {
            DB::rollback();
            $errorReload = "Error occurred. Please contact administrator for assistance.";
        }

}

if(isset($_POST["timeOut"]) && $_POST["timeOut"] == "out"){
    $timeOutValue = $_POST["timeOut"];
    date_default_timezone_set('Asia/Singapore');
    $currentDateTime = date("Y-m-d H:i:s");

    $clockQuery = DB::query("INSERT INTO clock (userID, clockTime, clockAction) VALUES (%i, %s, %s)", $userID, $currentDateTime, $timeOutValue);

        $newClockID = DB::insertId();
        $isSuccess = DB::affectedRows();
        
        
        if ($isSuccess) {
            DB::commit();
            $successReload2 = "You have clocked out. See ya!";
        } else {
            DB::rollback();
            $errorReload = "Error occurred. Please contact administrator for assistance.";
        }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-Main</title>
    <link rel="icon" href="assets/images/eco-icon.ico">
    <script src="assets/functionalities/script.js" defer></script>

    <?php include 'templates/styles.php'; ?>
</head>

<body id="page1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 main-logo">
                <img src="assets/images/ecogreat-03.png" alt="logo"/>
            </div>
            <div class="col-md-12 dashboard">
                <p class="subTitle topLine">ECOGreat Clock System</p><br>

                <div class="timecontainer">
                    <span id="hours">00</span>
                    <span>:</span>
                    <span id="minutes">00</span>
                    <span>:</span>
                    <span id="seconds">00</span>
                    <span id="session">AM</span>

                    <?php
                        echo "<br>".date('d-m-Y, l');
                    ?>
                </div><br>

                <form method="POST" action="main.php">
                    <div style="padding: 10px;">
                        <button class="btn btn-success"  style="padding-right: 20px;" name="timeIn" value="in" type="submit"><ion-icon class="btnLogo" name="enter-outline"></ion-icon><br>Time In
                        </button>

                        <span class="spaceDiv"></span>

                        <button class="btn btn-primary" name="timeOut" value="out" type="submit"><ion-icon class="btnLogo" name="exit-outline"></ion-icon><br>Time Out
                        </button>
                    </div>
                </form>
                
                <p class="subTitle">User Details</p>
                <p>User ID: <?php echo $userID; ?></p>
                <p>User Name: <?php echo $userName; ?></p>
                <p>User Email: <?php echo $userEmail; ?></p>
                <p>User Permission: <?php echo $userPermissionText; ?></p>
                <a href="logout.php" style="margin-bottom: 15px;" class="btn btn-danger">Logout</a>
                <?php
                    if(isAdmin()){
                        echo '<a href="users.php" style="margin-bottom: 15px;" class="btn btn-primary">To User Page</a>';
                    }
                ?>
            </div>
            
            <div class="col-md-12">
                <p class="subTitle">User Clock Record</p>

                <div class="code-block">
                    <label for="searchClockTime" class="form-label" style="padding-right: 5px">Clock Time:</label>
                    <input type="text" id="searchClockTime" style="margin-right: 5px" placeholder="Search" onkeyup="filterDateTime()">
                    <label for="inputAction" class="form-label" style="padding-right: 5px">Clock Action:</label>
                    <select class="form-select" name="action" id="inputAction" style="width: 200px">
                        <option value="" selected>Select an action</option>    
                        <option value="in">In</option>
                        <option value="out">Out</option>
                    </select>
                </div>
            
                <table class="table display table-success table-hover" id="clockTable">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Clock ID</th>
                            <th scope="col">Clock Time</th>
                            <th scope="col">Clock Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getAllClockQuery = DB::query("SELECT * FROM clock WHERE userID = %i", $userID);
                            foreach($getAllClockQuery as $getAllClockResult){
                                echo '<tr id="row_">';
                                    echo '<th scope="row">' . $getAllClockResult['userID'] . '</th>';
                                    echo '<th scope="row">' . $getAllClockResult['clockID'] . 
                                    '</th>';
                                    echo '<td class="datetime-column">' . $getAllClockResult['clockTime'] . '</td>';
                                    echo '<td>' . $getAllClockResult['clockAction'] . '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
                if(isAdmin()){
                    echo '<div class="col-md-12">';
                        echo '<p class="subTitle">All Users Clock Record</p>';
                        
                        echo '<div class="code-block">';
                            echo '<label for="searchUser" class="form-label" style="padding-right: 5px">User ID:</label>';
                            echo'<input type="text" id="searchUser" style="margin-right: 5px" placeholder="Search" onkeyup="filterIDTime()">';
                            echo '<label for="searchAllClockTime" class="form-label" style="padding-right: 5px">Clock Time:</label>';
                            echo'<input type="text" id="searchAllClockTime" style="margin-right: 5px" placeholder="Search" onkeyup="filterIDTime()">';
                            echo '<label for="inputAllAction" class="form-label" style="padding-right: 5px">Clock Action:</label>';
                            echo '<select class="form-select" name="allAction" id="inputAllAction" style="width: 200px">';
                                echo '<option value="" selected>Select an action</option>';    
                                echo '<option value="in">In</option>';
                                echo '<option value="out">Out</option>';
                            echo '</select>';
                        echo '</div>';

                        echo '<table class="table display table-success table-hover" id="allClockTable">';
                            echo '<thead>';
                                echo '<tr>';
                                    echo '<th scope="col">User ID</th>';
                                    echo '<th scope="col">Clock ID</th>';
                                    echo '<th scope="col">Clock Time</th>';
                                    echo '<th scope="col">Clock Action</th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                                $getAllClockQuery = DB::query("SELECT * FROM clock");
                                foreach($getAllClockQuery as $getAllClockResult){
                                    echo '<tr id="allRow_' . $getAllClockResult['userID'] . '">';
                                        echo '<th scope="row">' . $getAllClockResult['userID'] . '</th>';
                                        echo '<th scope="row">' . $getAllClockResult['clockID'] . '</th>';
                                        echo '<td class="allDatetime-Column">' . $getAllClockResult['clockTime'] . '</td>';
                                        echo '<td>' . $getAllClockResult['clockAction'] . '</td>';
                                    echo '</tr>';
                                }
                                
                            echo '</tbody>';
                        echo '</table>';
                    echo '</div>';
                }
            ?>

            <p class="endLine"><ion-icon name="time-outline"></ion-icon> Punctuality is about professional behavior. <ion-icon name="time-outline"></ion-icon></p>

            <?php 
            include 'templates/scripts.php'; 
            
            if($successReload){
                sweetAlertReload("success", "Welcome!", $successReload, 6000);
            }

            if($successReload2){
                sweetAlertReload("success", "Goodbye!", $successReload2, 6000);
            }

            if($errorReload){
                sweetAlertReload("error", "Opps...", $errorReload, 6000);
            }
            ?>
        </div>
    </div>
</body>

</html>