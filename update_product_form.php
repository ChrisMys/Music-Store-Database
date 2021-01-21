<?php

// Checking to see if we have started a session yet, and if not we are starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../Models/category_db.php');
require_once('../Models/validate.php');

// If the session variable user_id is exactly equal to 1 it will redirect them to the permission_error.php
if($_SESSION['user_id'] == 1){
    include('../Views/permission_error.php');
    exit();
}

//First we get our product_id from the hidden field in index.php
$product_id = filter_input(INPUT_POST, 'product_id_hidden', FILTER_VALIDATE_INT);

//Now we use that product_id to get the current values from the database
$query = 'SELECT *
          FROM products
          WHERE productID = :product_id';
$statement = $db->prepare($query);
$statement->bindValue(':product_id', $product_id);
$statement->execute();

// the product variable will now hold the row or data associated with our product_id
$product = $statement->fetch();
$statement->closeCursor();


//If the variables have not been set or they have been made empty by validation
//we are going to default the values back to what is in the database
//Note: that this was not part of the marking scheme, but it is how many forms work in the real world
if(!isset($category_id) || $category_id==''){
    $category_id = $product['categoryID'];
}
if(!isset($codeInput) || $codeInput==''){
    $codeInput = $product['productCode'];
}
if(!isset($price) || $price==''){
    $price = $product['listPrice'];
}
if(!isset($name) || $name==''){
    $name = $product['productName'];
}


?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<!-- the body section -->
<body>

    <div class="container">

        <main>
            <h1>Update Product</h1>

            <!-- We are setting up our form to use update_product to process this form data -->
            <form action="../Controllers/update_product.php" method="post" id="add_product_form">

                <div class="form-group">
                    <label>Category:</label>
                    <?php if(isset($category_error) && $category_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $category_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="number" min="1" max="3" name="category_id" id="code"
                    value="<?php echo htmlspecialchars($category_id); ?>"><br>
                </div>

                <div class="form-group">
                    <label for="code">Code:</label>
                    <?php if(isset($code_error) && $code_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $code_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="code" id="code"
                    value="<?php echo htmlspecialchars($codeInput); ?>"><br>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <?php if(isset($name_error) && $name_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $name_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="name" id="name"
                    value="<?php echo htmlspecialchars($name); ?>"><br>
                </div>

                <div class="form-group">
                    <label for="price">List Price:</label>
                    <?php if(isset($price_error) && $price_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $price_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="price" id="price"
                    value="<?php echo htmlspecialchars($price); ?>"><br>
                </div>

                <!-- Need this hidden input so that the product_id is forwarded to update_product.php -->
                <input type="hidden" name="product_id_hidden"
                                value="<?php echo $product_id; ?>">

                <label>&nbsp;</label>
                <input class="btn btn-primary" type="submit" value="Update Product">
                <a class="btn btn-danger" href="../index.php" role="button">Go Back</a>
                <br>
                <br>
            </form>

        </main>
    </div>

</body>
</html>