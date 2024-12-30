<?php
    require_once 'includes\header.php';
    require_once 'includes\classes\ProfileGenerator.php';

    if (isset($_GET["username"])){
        $username = $_GET["username"];
    } else {
        echo "No username provided";
        exit();
    }

    $profile = new ProfileGenerator($con, $userLoggedInObj, $username);
    echo $profile->create();


?>