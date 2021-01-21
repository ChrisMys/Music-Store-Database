<?php

    // Here we are building a constant variable that will store the pathway to our images folder.

    $image_dir = ".." . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;
    $image_path_dir = getcwd() . DIRECTORY_SEPARATOR . $image_dir;
    
?>