<?php
require_once('./Models/category_db.php');
require_once('./Models/product_db.php');
require_once('./Models/validate.php');
require_once('./Models/file_util.php');

/* Here we are checking to see if the session has started, and if it hasn't we are starting it */
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Get category ID
if (!isset($category_id)) {
  $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
  if ($category_id == NULL || $category_id == FALSE) {
      $category_id = 1;
  }
}

// Get name for selected category
$category = get_category($category_id);
$category_name = $category['categoryName'];

// Get all categories
$categories = get_categories();

// Get products for selected category
$products = get_products($category_id);



?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
</head>

<!-- the body section -->
<body>
<main>
    <h1>Product List</h1>

    <!-- Here we are going to echo out our saved SESSION variables for $username & $usertype -->
    <h2><?php echo "May the force be with you, " . $usersname . " !" . " You are currently operating as \"" . $userstype . "\"."?></h2>

    <aside>
            <!-- display a list of categories -->
            <h2>Categories</h2>
            <nav>
            <ul>
                <?php foreach ($categories as $category) : ?>
                <li><a class="btn btn-block
                  <?php if($category['categoryID']==$category_id) {
                           echo "btn-success";
                        } else {
                           echo "btn-outline-success";
                        } ?>"
                        href=".?category_id=<?php echo $category['categoryID']; ?>">
                        <?php echo $category['categoryName']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            </nav>
        </aside>

    <section>
        <!-- display a table of products -->
        <h2><?php echo $category_name; ?></h2>
        <table class="table table-striped">
          <thead>
              <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th class="right">Price</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($products as $product) : ?>
              <tr>
                  <td><?php echo $product['productCode']; ?></td>
                  <td><?php echo $product['productName']; ?></td>

                    <!-- Using $product['productCode'] we are going to have each entry in the table populate with its respective images from the image folder.
                         Each image will match up with the image that corresponds with the productCode it has within the database. If no match is made it will
                         Load a default image in it's place -->
                  <td class = "text-center"> <img src = "../images/<?php echo $product['productCode']; ?>.png" onerror="this.onerror=null;this.src='./images/noImage.png';" alt="Uploaded Image" height = "100px"> </td>
                  <td class="right"><?php echo $product['listPrice']; ?></td>
                  <td>
                    <!-- We are only showing the Delete button for this form -->
                    <form action="./Controllers/delete_product.php" method="post">

                      <!-- This hidden field is used to store the productID -->
                      <input type="hidden" name="product_id_hidden"
                             value="<?php echo $product['productID']; ?>">

                      <!-- This hidden field is used to store the categoryID -->
                      <input type="hidden" name="category_id_hidden"
                             value="<?php echo $product['categoryID']; ?>">

                      <!-- This is the button that we actually see -->
                      <input class="btn btn-warning" type="submit" value="Delete">
                    </form>
                  </td>
                  <td>
                    <!-- We are only showing the Delete button for this form -->
                    <form action="./Views/update_product_form.php" method="post">

                      <!-- This hidden field is used to store the productID -->
                      <input type="hidden" name="product_id_hidden"
                             value="<?php echo $product['productID']; ?>">

                      <!-- This hidden field is used to store the categoryID -->
                      <input type="hidden" name="category_id_hidden"
                             value="<?php echo $product['categoryID']; ?>">

                      <!-- This is the button that we actually see -->
                      <input class="btn btn-info" type="submit" value="Update">
                    </form>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
        <a class="btn btn-primary" href="./Views/add_product_form.php" role="button">Add Product</a>
        <a class="btn btn-danger" href="./Controllers/logout.php" role="button">Logout</a> 

        <!-- This button will only appear if the user_id saved in the SESSION varaible is equal to 3, otherwise it is hidden -->
        <?php if($_SESSION['user_id'] == 3){
          echo "<a class='btn btn-success' href='./Views/add_user_form.php' role='button'>Add User</a>";
        } ?>     
    </section>
</main>
<footer></footer>
</body>
</html>