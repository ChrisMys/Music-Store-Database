<?php

    // Checking to see if we have started a session yet, and if not we are starting one
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Checking to see if our SESSION variable is_valid_admin is set, and if it isnt it will redirect to login_form.php until a user has successfully logged in
    if(!isset($_SESSION['is_valid_admin'])) {
        header("Location: ../Views/login_form.php");
    }

    // Checking to see if our SESSION variable welcome_message has been set, and if it hasnt it will display "Not Working" otherwise it will display a welcome message to the user on the index.php
    if(!isset($_SESSION['welcome_message'])) {
        $usersname = "Not Working";
        $userstype = "Not Working";
      } else {
        $usersname = $_SESSION['welcome_message'];
        $userstype = $_SESSION['user_type'];
        $usernumber = $_SESSION['user_id'];
      }

      

?>