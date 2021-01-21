<?php

// Get the input fields
$typeID = filter_input(INPUT_POST, 'permission_id');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

//Retrieve and sanitize the first and last names
$first_name = filter_input(INPUT_POST, 'first_name');
$first_name = filter_var($first_name, FILTER_SANITIZE_STRING);

//Retrieve and sanitize the first and last names
$last_name = filter_input(INPUT_POST, 'last_name');
$last_name = filter_var($last_name, FILTER_SANITIZE_STRING);

//Retrieve the password
$user_password = filter_input(INPUT_POST, 'user_password');
$confirm_password = filter_input(INPUT_POST, 'confirm_password');

//Set all our error strings to the empty string
$permission_error = '';
$email_error = '';
$firstname_error = '';
$lastname_error = '';
$password_error = '';
$confirm_password_error = '';

// Validate User Type
if ($typeID == null || $typeID == false){
    $permission_error = "Please select a permission for user.";
}

// Validate email
if ($email == null || $email == false){
    $email_error = "Please enter a valid email.";
}

// Validate first name
if($first_name == false){
    $firstname_error = "Please enter a first name";
}

// Validate last name
if($last_name == false){
    $lastname_error = "Please enter a last name";
}

// Validate password
if($user_password == false || !preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$/', $user_password)){
    $password_error = "Please enter a valid password that contains at least:<ul><li> 6 characters long</li><li>one Capital letter</li><li>one lowercase letter</li><li>one number</li></ul>";
}

// Pasword confirmation
if($confirm_password == false || $confirm_password!=$user_password){
    $confirm_password_error = "Confirmation password must match the password entered.";
}

// If there are errors it will retain the data, and show to applicable errors. Otherwise it will proceed to add the user to the database.
if($email_error!='' || $firstname_error!=''  || $lastname_error!=''  || $password_error!=''  || $confirm_password_error!='' ) {
    include('../Views/add_user_form.php');
    exit();
} else {
    // Setting our requirements
    require_once('../Models/database.php');
    require_once('../Models/db_admin.php');

    // This is where we add the user to the new database table
    $add_return_value = add_admin($email, $user_password, $first_name, $last_name, $typeID);

    // Display the Product List page
    include('../Views/add_user_form.php');
    exit();
}
?>