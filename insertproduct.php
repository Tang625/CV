<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-Product Insert</title>
    <link rel="icon" href="assets/images/g-pack.ico">

    <?php include 'templates/styles.php'; ?>
</head>

<body>
    <div class="container">
        <div class="col-lg-12 logo-line">
            <h1>
                <img src="assets/images/g-pack-2.png" alt="logo"/>en Pack
                Enterprise
            </h1>
        </div>
        <h3 class="fw-normal myAdmin-line" style="text-align: center;">Gen Pack MyAdmin</h3><br>
        <h3 style="text-align: center;">Please enter the following details for a newly created product:</h3>
        <div style="display: none;" class="alert alert-danger" id="insertProductError" role="alert">
        </div>
        <div style="display: none;" class="alert alert-success" id="insertProductSuccess" role="alert"></div>
        <form class="form-insert">
            <div class="mb-3 div-insert">
                <label for="inputProductCat" class="form-label">Product Category</label>
                <input type="text" class="form-control" id="inputProductCat" value="" aria-describedby="importantTxt">
                <div id="importantTxt" class="form-text">Please ensure all details are entered correctly.</div>
            </div>
            <div class="mb-3 div-insert">
                <label for="inputProductPic" class="form-label">Product Picture</label>
                <input type="text" class="form-control" id="inputProductPic" value="" placeholder="Please insert product picture at index page." disabled>
            </div>
            <div class="mb-3 div-insert">
                <label for="inputProductPri" class="form-label">Product Price</label>
                <input type="text" class="form-control" id="inputProductPri">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputProductNam" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="inputProductNam">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputProductQty" class="form-label">Product Quantity</label>
                <input type="number" class="form-control" id="inputProductQty">
            </div>
            <div class="div-insert">
                <button type="submit" id="addProduct" class="btn btn-success">Insert Product
                </button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <?php include 'templates/script.php'; ?>

    <script>
        $(document).ready(function(){
            $("form").submit(function(e){
                e.preventDefault(e);
            });

            $("#addProduct").click(function(){
                var productCat = $("#inputProductCat").val();
                var productPic = $("#inputProductPic").val();
                var productPri = $("#inputProductPri").val();
                var productNam = $("#inputProductNam").val();
                var productQty = $("#inputProductQty").val();

                $.ajax({
                    url: 'ajax-insertproduct.php', //action
                    method: 'POST', //method
                    data:{
                        productCategory: productCat,
                        productPicture: productPic,
                        productPrice: productPri,
                        productName: productNam,
                        productQuantity: productQty,
                    },
                    success:function(data){
                        if(data != "Product added successfully!"){
                            //Insert NOT successful   
                            $("#insertProductSuccess").hide();
                            $("#insertProductError").text(data).show();
                            $("#inputProductNam").val(productNam);
                            window.parent.parent.scrollTo(0, 0);
                        } else {
                            //Insert successful
                            $("#insertProductError").hide();
                            $("#insertProductSuccess").text(data).show();
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