<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');

if(isLoggedIn()){
    header("Location: " . SITE_URL . "index.php");
    exit();
}

$email = $password = $warningReload = $error = $errorReload = "";

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(isBlankField($email) || isBlankField($password)){
        $warningReload = "Please ensure both the email and password fields are filled in.";
    } else {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            # start sign in process
            # 1. Check if user exist in DB
            $userQuery = DB::query("SELECT * FROM user WHERE userEmail = %s", $email);
            $userCount = DB::count();
            
            if($userCount == 1){
                foreach($userQuery as $userResult){
                    $userID = $userResult["userID"];
                    $userPassword = $userResult['userPassword'];
                }
                // if($password == $userPassword){
                if(password_verify($password, $userPassword)){
                    # If Password matches
                    # Set cookies
                    setCookies($userID);
                    
                    header("Location: " . SITE_URL . "index.php"); # redirect user to dashboard
                    exit(); 
                } else {
                    $error = "Invalid password.";
                }
            } else {
                # Email DO NOT exist in DB OR Password not match
                $error = "The user does not exist.";
            }
        } else {
            $errorReload = "Invalid email";
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
    <title><?php echo SITE_NAME; ?>-Login</title>
    <link rel="icon" href="assets/images/g-pack.ico">
    
    <?php include 'templates/styles.php'; ?>
</head>

<body id="page3">
    <section>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php"><ion-icon name="logo-google"></ion-icon>en Pack Enterprise</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.php">
                                <ion-icon name="person-outline"></ion-icon> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Title-->
        <div class="row">
            <div class="col-lg-12 logo-line">
                <h1>
                    <img src="assets/images/g-pack-2.png" alt="logo"/>en Pack
                    Enterprise
                </h1>
                <h4 class="logo-line first-line">
                    Welcome to our login page!
                </h4>
            </div>
        </div>
    </section>

    <main class="text-center login-page form-login">
        <form method="POST">
            <h1 class="h3 fw-normal myAdmin-line">Gen Pack MyAdmin</h1><br>

            <div class="form-floating">
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo $email; ?>">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="signIn" type="submit">Sign in</button>
            <p class="mt-5"> This site is only for authorized personnel.</p>
            <p class="mt-5 text-muted">&copy; <?php echo SITE_NAME; ?> <?php echo date("Y"); ?></p>
        </form>
    </main>

    <?php
    include 'templates/script.php';
    
    if($warningReload){
        sweetAlertReload("warning", "Hi there!", $warningReload, 6000);
    }

    if($error){
        sweetAlert("error", "Opps...", $error, 6000);
    }

    if($errorReload){
        sweetAlertReload("error", "Opps...", $errorReload, 6000);
    }
    ?>
</body>

</html>