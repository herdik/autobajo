<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/TireImage.php";

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

    $update_tires_priority = array();
    
    for ($i = 0; $i < count($_POST); $i++) {
        $image_id = $_POST[$i];
        $update_tire = TireImage::updateTireImagePriority($connection, $image_id, $i + 1);
        array_push($update_tires_priority, $update_tire);
    }

    if(count(array_unique($update_tires_priority)) === 1){
        if (current($update_tires_priority)){
            echo json_encode($update_tires_priority);
            
            // Url::redirectUrl("/autobajo/admin/tire-profil.php?tire_id=$tire_id&active_advertisement=1");
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