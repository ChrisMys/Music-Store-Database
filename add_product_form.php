<?php

// Checking to see if we have started a session yet, and if not we are starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../Models/database.php');
require_once('../Models/validate.php');
require_once('../Models/category_db.php');

// Checking our session variable to see if the user_id is exactly equal to one, and if it isnt the user will be redirected to the permission_error.php
if($_SESSION['user_id'] == 1){
    include('../Views/permission_error.php');
    exit();
}

// Clearing the codeInput if its set
if(!isset($codeInput)){
    $codeInput = '';
}

// Clearing the price if its set
if(!isset($price)){
    $price = '';
}

// Clearing the name if its set
if(!isset($name)){
    $name = '';
}

// Get all categories
$categories = get_categories();

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
            <h1>Add Product</h1>

            <!-- Setting our enctype to multipart/form-data to support our image upload -->
            <form action="../Controllers/insert_product.php" method="post"
                enctype="multipart/form-data" id="add_product_form">

                <!-- Using a foreach to assign all the categories in our database to drop down menu -->
                <div class="form-group">
                    <label>Category:</label>
                    <?php if(isset($category_error) && $category_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $category_error; ?></h3>
                    <?php } ?>
                    <select class="form-control" name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['categoryID']; ?>">
                            <?php echo $category['categoryName']; ?>
                        </option>
                    <?php endforeach; ?>
                    </select><br>
                </div>

                <!-- Product Code -->
                <div class="form-group">
                    <label for="code">Code:</label>
                    <?php if(isset($code_error) && $code_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $code_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="code" id="code"
                    value="<?php echo htmlspecialchars($codeInput); ?>"><br>
                </div>

                <!-- Product Name -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <?php if(isset($name_error) && $name_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $name_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="name" id="name"
                    value="<?php echo htmlspecialchars($name); ?>"><br>
                </div>

                <!-- List Price -->
                <div class="form-group">
                    <label for="price">List Price:</label>
                    <?php if(isset($price_error) && $price_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $price_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="price" id="price"
                    value="<?php echo htmlspecialchars($price); ?>"><br>
                </div>

                <!-- Upload Image -->
                <div class="form-group">
                    <input type="file" name="upload">
                </div>

                <!-- Add Product & Go Back -->
                <label>&nbsp;</label>
                <input class="btn btn-primary" type="submit" value="Add Product">
                <a class="btn btn-danger" href="../index.php" role="button">Go Back</a>
                <br>
                <br>
            </form>

        </main>
    </div>

</body>
</html>