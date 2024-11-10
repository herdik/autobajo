<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/CarImage.php";

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

    $update_cars_priority = array();
    
    for ($i = 0; $i < count($_POST); $i++) {
        $image_id = $_POST[$i];
        $update_car = CarImage::updateCarImagePriority($connection, $image_id, $i + 1);
        array_push($update_cars_priority, $update_car);
    }

    if(count(array_unique($update_cars_priority)) === 1){
        if (current($update_cars_priority)){
            echo json_encode($update_cars_priority);
            
            // Url::redirectUrl("/autobajo/admin/car-profil.php?car_id=$car_id&active_advertisement=1");
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