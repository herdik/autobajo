<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/WheelImage.php";

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 


if ($_SERVER["REQUEST_METHOD"] === "POST"){

    // database connection
    $database = new Database();
    $connection = $database->connectionDB();

    $update_wheels_priority = array();
    
    for ($i = 0; $i < count($_POST); $i++) {
        $image_id = $_POST[$i];
        $update_wheel = WheelImage::updateWheelImagePriority($connection, $image_id, $i + 1);
        array_push($update_wheels_priority, $update_wheel);
    }

    if(count(array_unique($update_wheels_priority)) === 1){
        if (current($update_wheels_priority)){
            echo json_encode($update_wheels_priority);
            
            // Url::redirectUrl("/autobajo/admin/wheel-profil.php?wheel_id=$wheel_id&active_advertisement=1");
        } else {
            $not_update_done = "Update inzerátu sa nepodaril.";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done");
        }
    } else {
        $not_update_done = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done");
    }

} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>