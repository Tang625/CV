<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');

$cBox = $warning = $success = $error = $warningReload = $infoReload = "";

if(isset($_POST['submitBtn'])){
  $cBox = $_POST['cBox'];
  
  if(isBlankField($cBox)){
    $warningReload = "Please ensure all questions have been answered.";
      // $warning = "Please ensure all questions have answered.";
  } else {
    $infoReload = "Your answers are well received. We will contact you and customize our service bundles based on your needs!";
  }
}

$joinName = $joinEmail = $joinPhone = "";

if(isset($_POST['joinBtn'])){
  $joinName = $_POST['joinName'];
  $joinEmail = $_POST['joinEmail'];
  $joinPhone = $_POST['joinPhone'];

  $luckyNum = rand(0,10000);
  sprintf("%03d",$luckyNum);
  echo $luckyNum;
  
  if(isBlankField($joinName) || isBlankField($joinEmail) || isBlankField($joinPhone)){
    $warning = "Please make sure that all the empty fields have been filled in.";
  } else {
    if(filter_var($joinEmail, FILTER_VALIDATE_EMAIL)){
    $success = "Thanks for joining us! Your Membership Lucky Number is: " . $luckyNum . "! We will verify your details and contact you soon!";
    } else {
    $error = "Invalid email. Please enter a valid email address to join our membership.";
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
  <title><?php echo SITE_NAME; ?>-Services</title>
  <link rel="icon" href="assets/images/g-pack.ico">

  <?php include 'templates/styles.php'; ?>
</head>

<body>
  <section>
    <!--Nav Bar-->
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
              <a class="nav-link active" aria-current="page" href="services.php">
                <ion-icon name="build-outline"></ion-icon>
                Services
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!--Title-->
    <div class="row service-title">
      <div class="col-lg-12 logo-line">
        <h1><img src="assets/images/g-pack-2.png" alt="logo">en Pack Enterprise</h1>
        <h4 class="logo-line first-line">We strive to provide you with excellent and professional hygiene services.
        </h4>
      </div>
    </div>
  </section>

  <!-- Button trigger modal for Questionnaire -->
  <section id="modal-btn-2">
    <div class="d-grid gap-2 col-6 mx-auto">
      <h4 class="q-line">Let us serve you better by clicking
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2">HERE</button>
      </h4>
    </div>
  </section>

  <!-- Questionnaire Modal -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title q-line" id="exampleModalLabel">Service Bundles Questionnaire (SBQ)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="logo-line first-line">Take this questionnaire to let us know which service bundles suit you most!
          </h5>
          <form method="post" id="question">
            <div>
              <h5>Do your premises use air fresheners?</h5>
              <div class="form-check form-check-inline">
                <input class="form-check-input yes1" name="cBox" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input no1" name="cBox" type="checkbox" id="inlineCheckbox2">
                <label class="form-check-label" for="inlineCheckbox2">No</label>
              </div>
            </div><br>
            <div class="hidden-q1">
              <h5>If yes, are they installed?</h5>
              <div class="form-check form-check-inline">
                <input class="form-check-input yes2" name="cBox" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input no2" name="cBox" type="checkbox" id="inlineCheckbox2">
                <label class="form-check-label" for="inlineCheckbox2">No</label>
              </div>
            </div><br>
            <div>
              <h5>Is your household or workplace equipped with a toilet roll dispenser?</h5>
              <div class="form-check form-check-inline">
                <input class="form-check-input yes3" name="cBox" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input no3" name="cBox" type="checkbox" id="inlineCheckbox2">
                <label class="form-check-label" for="inlineCheckbox2">No</label>
              </div>
            </div><br>
            <div class="hidden-q2">
              <h5>If equipped, are they installed?</h5>
              <div class="form-check form-check-inline">
                <input class="form-check-input yes4" name="cBox" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input no4" name="cBox" type="checkbox" id="inlineCheckbox2">
                <label class="form-check-label" for="inlineCheckbox2">No</label>
              </div>
            </div>
            <div class="modal-footer">
              <button name="submitBtn" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Air Freshener -->
  <section>
    <h3 class="service-header">
      <ion-icon name="caret-back-outline"></ion-icon>
      <strong>Our service bundles</strong> 
      <ion-icon name="caret-forward-outline"></ion-icon>
    </h3>
    <div class="card mb-3" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/images/air-spray-installation.jpg" class="img-fluid rounded-start"
            alt="spray-installation">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Air freshener service & installation package</h5>
            <p class="card-text">You can count on our air freshener service when you need clean air.
            </p>
            <p class="card-text"><small class="text-muted">Service fee (initial installation included) only monthly SGD 20.00++ from now!</small></p>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/images/air-freshener-spray.jpg" class="img-fluid rounded-start" alt="air-freshener">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Glade Air Freshener - Spray Refill + Dispenser (In bundle with package)</h5>
            <p class="card-text">Packaged with our air freshener service & installation package, this product is offered in a bundle.</p>
            <p class="card-text"><small class="text-muted">Your value-added bundle and call us now 
              <ion-icon name="call-outline"></ion-icon></small>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Toilet Dispenser -->
  <section class="toilet-dispenser">
    <div class="card mb-3" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/images/toilet-roll-installation-2.jpg" class="img-fluid rounded-start"
            alt="roll-installation">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Toilet roll service & installation package</h5>
            <p class="card-text">The most comfortable way to take care of your hygiene needs.</p>
            <p class="card-text"><small class="text-muted">Service fee (initial installation included) only monthly SGD 50.00++ from now!</small></p>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/images/toilet-roll-dispenser.jpg" class="img-fluid rounded-start"
            alt="roll-dispenser">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Kimberly Clark Jumbo Roll Tissue + Dispenser (In bundle with package)</h5>
            <p class="card-text">Once you sign up for our toilet roll service & installation package, this product will come in a bundle.</p>
            <p class="card-text">
              <small class="text-muted">Your cost-saving bundle and call us now 
              <ion-icon name="call-outline"></ion-icon></small>
            </p>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials">
    <h4><ion-icon name="star"></ion-icon> Customer Acknowledgement 
      <ion-icon name="star"></ion-icon>
    </h4>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <h4 class="testimonial-text">
            "Their products have high quality and they respond promptly."
          </h4>
          <img class="testimonial-image" src="assets/images/chinese-uncle.jfif" alt="chinese-uncle" />
          <em>Mr. Goh, Queenstown</em>
        </div>
        <div class="carousel-item">
          <h4 class="testimonial-text">
            "Their staff is friendly and their prices are affordable."
          </h4>
          <img class="testimonial-image" src="assets/images/malay-lady-1.png" alt="malay-aunty" />
          <em>Ms. Siti, Woodlands</em>
        </div>
        <div class="carousel-item">
          <h4 class="testimonial-text">
            "Their service package is worth it!"
          </h4>
          <img class="testimonial-image" src="assets/images/indian-uncle-1.png" alt="indian-uncle" />
          <em>Mr. Kumar, Pioneer</em>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <!-- Button trigger modal for membership -->
  <section id="modal-btn-3">
    <h4><ion-icon name="gift"></ion-icon> Come! Enjoy your exclusive benefits by joining us!
      <ion-icon name="gift"></ion-icon>
    </h4><br>
    <div class="d-grid gap-2 col-4 mx-auto">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal3">
        <ion-icon name="star"></ion-icon> Lucky Number Membership click HERE ! 
        <ion-icon name="star"></ion-icon>
      </button>
    </div>
  </section>

  <!-- Membership Modal -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title q-line" id="exampleModalLabel">Lucky Number membership form </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="logo-line first-line">Complete the form below and get your exclusive Lucky Number membership!
          </h5>
          <form method="post">
            <div>
              <label for="id-name" class="col-form-label">Name:</label>
              <input name="joinName" type="text" class="form-control" id="recipient-name">
            </div>
            <div>
              <label for="email" class="col-form-label">Email Address:</label>
              <input name="joinEmail" type="email" class="form-control" id="email-add" placeholder="example@gmail.com">
            </div>
            <div>
              <label for="phone" class="col-form-label">Phone No.:</label>
              <input name="joinPhone" type="tel" class="form-control" id="phone-num" placeholder="+65 1234 5678">
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Leave</button>
              <button name="joinBtn" class="btn btn-primary">Join now !</button>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Contact -->
  <footer>
    <div class="contact-us">
      <h3>Contact Us</h3>
      <p>Call us at <strong><ion-icon name="call-outline"></ion-icon> 8436 0507</strong> or you may also contact us via:</p>
    </div>
    <div class="social-media">
      <h3>
        <a class="footer-link" href="https://www.instagram.com/">
          <ion-icon name="logo-instagram"></ion-icon>
        </a>
        <a class="footer-link" href="https://www.facebook.com/">
          <ion-icon name="logo-facebook"></ion-icon>
        </a>
        <a class="footer-link" href="https://twitter.com">
          <ion-icon name="logo-twitter"></ion-icon>
        </a>
        <a class="footer-link" href="mailto:services.genpack@gmail.com">
          <ion-icon name="mail-outline"></ion-icon>
        </a>
      </h3>
    </div>
  </footer>

  <?php include 'templates/script.php'; 

  if($warning){
		SweetAlert("warning", "Hi There!", $warning, 6000);
	}

  if($success){
		SweetAlert("success", "Congratulation!", $success, 6000);
	}
  
  if($error){
		SweetAlert("error", "Opps...", $error, 6000);
	}

  if($warningReload){
    sweetAlertReload("warning", "Hi There!", $warningReload, 6000);
  }

  if($infoReload){
    sweetAlertReload("info", "Well received!", $infoReload, 6000);
  }
  ?>
</body>

</html>