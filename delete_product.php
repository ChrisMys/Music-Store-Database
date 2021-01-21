<?php

// Checking to see if we have started a session yet, and if not we are starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../Models/product_db.php');
require_once('../Models/validate.php');

if($_SESSION['user_id'] == 1){
    include('../Views/permission_error.php');
    exit();
}

// Get IDs
$product_id = filter_input(INPUT_POST, 'product_id_hidden', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id_hidden', FILTER_VALIDATE_INT);

// Delete the product from the database
if ($product_id != false && $category_id != false) {
    delete_product($product_id);
}

// display the Product List page
header('Location: ../index.php');
?>