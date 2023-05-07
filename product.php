<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-Product</title>
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
                            <a class="nav-link active" aria-current="page" href="product.php">
                                <ion-icon name="cube-outline"></ion-icon> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">Services</a>
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
                <h1>
                    <img src="assets/images/g-pack-2.png" alt="logo"/>en Pack
                    Enterprise
                </h1>
                <h4 class="logo-line first-line">
                    Our products are always here to meet your needs.
                </h4>
            </div>
        </div>
    </section>

    <!-- Button trigger modal -->
    <section id="modal-btn-1">
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                <h4>Proceed to checkout! <ion-icon name="cart-outline"></ion-icon></h4>
            </button>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Your Checkout List
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price(SGD)</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>

                        <?php
                            $getAllProductQuery = DB::query("SELECT * FROM product");
                            $productCount = DB::count();
                            if ($productCount > 0){                
                                foreach($getAllProductQuery as $getAllProductResult){
                                    $productImage = $getAllProductResult["productPicture"];
                                    $productPrice = $getAllProductResult['productPrice'];
                                    $productName = $getAllProductResult['productName'];
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td>
                                                <img src="assets/images/' . $productImage . '" class="img-fluid img-thumbnail"/>
                                            </td>';
                                            echo '<td>' . $productName . '</td>';
                                            echo '<td>
                                                    <div class="button-container">
                                                        <button class="cart-qty-plus" type="button" value="+">
                                                            +
                                                        </button>
                                                        <input type="text" name="qty" min="0" class="qty form-control" value="0" />
                                                        <button class="cart-qty-minus" type="button" value="-">
                                                            -
                                                        </button>
                                                    </div>
                                                </td>';
                                            echo '<td>
                                                    <input type="text" value="' . $productPrice . '" class="price form-control" disabled />
                                                </td>';
                                            echo '<td>
                                                    SGD <span id="amount" class="amount">0</span>
                                                </td>';
                                        echo '</tr>';
                                    echo '</tbody>';
                                }
                            }
                        ?>
                    </table>
                    <div class="d-flex justify-content-end">
                        <h5>Total Price: SGD <span id="total" class="total">0</span></h5>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clear-btn" class="btn btn-danger">
                        Clear Cart
                    </button>
                    <button type="button" class="btn btn-primary payment-link">
                        Proceed Payment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Paper Products -->
    <div class="product-header">
        <h2>Paper Products</h2>
        <p>Top-quality paper wipes that are soft and pleasant to use.</p>
    </div>

    <section id="features">
        <div class="row">
            <?php
                $getAllProductQuery = DB::query("SELECT * FROM product WHERE productCategory = 'Paper'");
                $productCount = DB::count();
                if ($productCount > 0){                
                    foreach($getAllProductQuery as $getAllProductResult){
                        $productImage = $getAllProductResult["productPicture"];
                        $productPrice = $getAllProductResult['productPrice'];
                        $productName = $getAllProductResult['productName'];
                        echo '<div class="feature-box col-lg-4 product-bottom">';
                            echo '<img src="assets/images/' . $productImage . '"/>';
                            echo '<h3>SGD' . $productPrice . '</h3>';
                            echo '<p>' . $productName . '</p>';
                            echo '<button class="btn btn-lg btn-block btn-outline-dark cart-btn" type="button">
                                <ion-icon name="cart-outline"></ion-icon>
                            </button>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <!-- Chemical Products -->
    <div class="product-header">
        <h2>Chemical Products</h2>
        <p>This magic removes all the dirt and dust.</p>
    </div>

    <section id="features">
        <div class="row">
            <?php
                $getAllProductQuery = DB::query("SELECT * FROM product WHERE productCategory = 'Chemical'");
                $productCount = DB::count();   
                if ($productCount > 0){                
                    foreach($getAllProductQuery as $getAllProductResult){
                        $productImage = $getAllProductResult["productPicture"];
                        $productPrice = $getAllProductResult['productPrice'];
                        $productName = $getAllProductResult['productName'];
                        echo '<div class="feature-box col-lg-4 product-bottom">';
                            echo '<img src="assets/images/' . $productImage . '"/>';
                            echo '<h3>SGD' . $productPrice . '</h3>';
                            echo '<p>' . $productName . '</p>';
                            echo '<button class="btn btn-lg btn-block btn-outline-dark cart-btn" type="button">
                                <ion-icon name="cart-outline"></ion-icon>
                            </button>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <!-- plastic Products -->
    <div class="product-header">
        <h2>Plastic Products</h2>
        <p>Designed for your convenience and is environmentally friendly.</p>
    </div>

    <section id="features">
        <div class="row">
            <?php
                $getAllProductQuery = DB::query("SELECT * FROM product WHERE productCategory = 'Plastic'");
                $productCount = DB::count();   
                if ($productCount > 0){                
                    foreach($getAllProductQuery as $getAllProductResult){
                        $productImage = $getAllProductResult["productPicture"];
                        $productPrice = $getAllProductResult['productPrice'];
                        $productName = $getAllProductResult['productName'];
                        echo '<div class="feature-box col-lg-4 product-bottom">';
                            echo '<img src="assets/images/' . $productImage . '"/>';
                            echo '<h3>SGD' . $productPrice . '</h3>';
                            echo '<p>' . $productName . '</p>';
                            echo '<button class="btn btn-lg btn-block btn-outline-dark cart-btn" type="button">
                                <ion-icon name="cart-outline"></ion-icon>
                            </button>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <!--caption-->
    <section>
        <div class="row slogan">
            <div class="col-lg-12">
                <h3>
                    <ion-icon name="cart-outline"></ion-icon> Your smart choice of goods <ion-icon name="cart-outline"></ion-icon>
                </h3>
            </div>
        </div>
    </section>

    <?php include 'templates/script.php'; ?>
</body>

</html>