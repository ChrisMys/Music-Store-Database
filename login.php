<?php

    // Checking to see if we have started a session yet, and if not we are starting one
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Getting our filtered data from the form
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $user_password = filter_input(INPUT_POST, 'password');

    // Clearing our the messages from the session if they already exist
    unset($_SESSION['email_message']);
    unset($_SESSION['password_message']);
    unset($_SESSION['login_message']);
    unset($_SESSION['welcome_message']);


    // Validating email, and if it's wrong we are putting the error in a SESSION message
    if ( $email === FALSE ) {
        $_SESSION['email_message'] = 'Please provide a valid email address.';
    }

    // Validating user_password, and if it's wrong we are putting the error in a SESSION message
    if ( $user_password === FALSE || strlen($user_password) < 6 ) {
        $_SESSION['password_message'] = 'Please provide a password at least 6 characters long.';
    }

    // If an error message is triggered, it will redirect back to the login_form.php, but if the email is correct it will stay in its input box
    if (isset($_SESSION['password_message']) ||
        isset($_SESSION['email_message']) ) {

        $_SESSION['email'] = $email;

        // Using header here will alter our address bar so that the information isnt being displayed
        header('Location: ../Views/login_form.php');
        exit();

    } else {

        // Setting our requirements here to adequately set our SESSION variables below
        require_once('../Models/database.php');
        require_once('../Models/db_admin.php');

        // Here is where we need to validate the user and set the session's for our valid_login, username and usertype
        if(is_valid_admin_login($email, $user_password)){

            $_SESSION['is_valid_admin'] = true;
            $_SESSION['welcome_message'] = get_users_name($email);
            $_SESSION['user_type'] = get_user_type($email);
            $_SESSION['user_id'] = get_type_id($email);

            header('Location: ../index.php');

        } else {

            if(email_exists($email)){
                $_SESSION['login_message'] = "Password is incorrect.";
            } else {
                $_SESSION['login_message'] = "Username does not exist.";
            }

            header('Location: ../Views/login_form.php');
            exit();
        }
        
    }

?>
