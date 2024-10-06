<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Wheel.php";

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

    // wheel_id representing last insert wheel_advertisement to SQL database 
    // is manually set for false until saved wheel advertisement to SQL databesa to wheel_advertisement table
    $wheel_id = $_POST["wheel_id"];

    // value from registration form for wheel advertisement
    $wheel_category = $_POST["wheel_category"];
    $wheel_brand = $_POST["wheel_brand"];
    $wheel_model = $_POST["wheel_model"];
    $wheel_average = $_POST["wheel_average"];
    $spacing = $_POST["spacing"];
    $width = $_POST["width"];
    $et = $_POST["et"];
    $wheel_color = $_POST["wheel_color"];
    $wheel_price = $_POST["wheel_price"];
    $wheel_description = $_POST["wheel_description"];


    // save all car dvertisement do SQL car_advertisement table
    $update_wheel = Wheel::updateWheelInfoAdvertisement($connection, $wheel_id, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $width, $et, $wheel_color, $wheel_price, $wheel_description);

    
    if ($update_wheel){
        Url::redirectUrl("/autobajo/admin/wheel-profil.php?wheel_id=$wheel_id&active_advertisement=1");
    } else {
        $not_update_done = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>