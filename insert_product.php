<?php

// Retrieve the category_id
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

//Retrieve and sanitize the codeinput
$codeInput = filter_input(INPUT_POST, 'code');
$codeInput = filter_var($codeInput, FILTER_SANITIZE_STRING);

//Retrieve and sanitize the name
$name = filter_input(INPUT_POST, 'name');
$name = filter_var($name, FILTER_SANITIZE_STRING);

// Retrieve the price
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

require('../Models/file_util.php');

// Checking to see if the uploaded file exists, then saving the name of the uploaded file to our variable fileName.
// Then we are exploding the name format at the "." and picking up the file extension at the end of the name and saving it to our fileExt.
// Then we are creating an Array to store our allowed values to be checked with our fileExt
// If the fileName is not empty, and the fileExt exists in our allowed array it will proceed to name the newFileName as whatever the codeInput was
// that the user specified in the form, then we will take that file from its tmp_location and move_uploaded_file to our specified directory to save it.
if(isset($_FILES['upload'])){
    $fileName = $_FILES['upload']['name'];
    $fileType = explode('.', $fileName);
    $fileExt = strtolower(end($fileType));
    $allowed = array('png');
    

    if(!empty($fileName) && in_array($fileExt, $allowed)){
        $newFileName = $codeInput;
        $sourceLocation = $_FILES['upload']['tmp_name'];
        $targetPath = $image_path_dir . $newFileName . "." . $fileExt;
        move_uploaded_file($sourceLocation, $targetPath);       
    } 
}

// Setting all our error messages to empty strings by default
$category_error = '';
$code_error = '';
$name_error = '';
$price_error = '';

// Validate Category_ID, and throw an error if parameters are not met
if ($category_id == null || $category_id == false){
    $category_error = "Please choose a category.";
}

// Validate codeInput, and throw an error if parameters are not met
if($codeInput == false){
    $code_error = "Please enter a code";
}

// Validate name, and throw an error if parameters are not met
if($name == false){
    $name_error = "Please enter a name";
}

// Validate price, and throw an error if parameters are not met
if($price == false){
    $price_error = "Please enter a price";
} else if($price < 0 || $price > 50000){
    $price_error = "Please enter a price between 0 and 50 000 dollars";
}

// If any of the error parameters are triggered we will prompt the page to refresh with any error codes currently present for further validation
if($price_error !='' || $name_error != ''  || $code_error != ''  || $category_error != '') {
    include('../Views/add_product_form.php');
    exit();

// If there is not any errors we will require_once the product_db.php and run our add_product function which will add all our our specified inputs to the database
// and then relocate us to index.php 
} else {
    require_once('../Models/product_db.php');

    add_product($category_id, $codeInput, $name, $price);

}

    // Display the Product List page
    header('Location: ../index.php');

?>