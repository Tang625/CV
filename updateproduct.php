<?php
include('core/config.php');
include('core/db.php');
include('core/function.php');

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "login.php"); //redirect to login page
};

if(!isset($_GET['id']) || $_GET['id'] == ""){
    #No GET parameter detected
    header('Location: index.php');
} else {
    #GET parameter is detected
    $getProductQuery = DB::query("SELECT * FROM product WHERE productID = %i", $_GET['id']);
    foreach($getProductQuery as $getProductResult){
        $dbProductID = $getProductResult["productID"];
        $dbProductCategory = $getProductResult["productCategory"];
        $dbProductPicture = $getProductResult["productPicture"];
        $dbProductPrice = $getProductResult["productPrice"];
        $dbProductName = $getProductResult["productName"];
        $dbProductQuantity = $getProductResult["productQuantity"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?>-Product Update</title>
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
        <h3 style="text-align: center;">Please update the product details below:</h3>
        <div style="display: none;" class="alert alert-danger" id="updateProductError" role="alert">
        </div>
        <div style="display: none;" class="alert alert-success" id="updateProductSuccess" role="alert">
        </div>
        <form class="form-insert">
            <input type="text" id="id" value="<?php echo $_GET['id']; ?>" hidden>
            <div class="mb-3 div-insert">
                <label for="inputCategory" class="form-label">Product Category</label>
                <input type="text" class="form-control" id="inputCategory" value="<?php echo $dbProductCategory; ?>" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Please ensure that all details are entered correctly.</div>
            </div>
            <div class="mb-3 div-insert">
                <label class="form-label">Product Picture</label><br>
                <img src="assets/images/<?php echo $dbProductPicture; ?>" class="img-fluid img-thumbnail" alt="Product-Image"/><br>
                <?php
                    echo '<a href="image.php?id=' . $dbProductID . '" class="btn btn-info">Update Picture</a>'
                ?>
            </div>
            <div class="mb-3 div-insert">
                <label for="inputPrice" class="form-label">Product Price</label>
                <input type="text" class="form-control" id="inputPrice" value="<?php echo $dbProductPrice; ?>">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputProductName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="inputProductName" value="<?php echo $dbProductName; ?>">
            </div>
            <div class="mb-3 div-insert">
                <label for="inputQuantity" class="form-label">Product Quantity</label>
                <input type="number" class="form-control" id="inputQuantity" value="<?php echo $dbProductQuantity; ?>">
            </div>
            <div class="div-insert">
                <button type="submit" id="updateProduct" class="btn btn-success">Update Product</button>
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

        $("#updateProduct").click(function(){
            var id = $("#id").val();
            var category = $("#inputCategory").val();
            var price = $("#inputPrice").val();
            var productName = $("#inputProductName").val();
            var quantity = $("#inputQuantity").val();

            $.ajax({
                url: 'ajax-updateproduct.php', //action
                method: 'POST', //method
                data:{
                    id: id,
                    category: category,
                    price: price,
                    productName: productName,
                    quantity: quantity,
                },
                success:function(data){
                    if(data != "Product updated successfully!"){
                        //Insert NOT successful
                        $("#updateProductSuccess").hide();
                        $("#updateProductError").text(data).show();
                        $("#inputProductName").val(productName);
                        window.parent.parent.scrollTo(0, 0);
                    } else {
                        //Insert successful
                        $("#updateProductError").hide();
                        $("#updateProductSuccess").text(data).show();
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