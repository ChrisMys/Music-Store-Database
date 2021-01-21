<?php

    // If a session doesn't exist start one to avoid errors
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    session_destroy(); // Clean up the session ID
    header ("Location: ../Views/login_form.php");

?>