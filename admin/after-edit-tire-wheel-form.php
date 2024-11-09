<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/TireWheel.php";

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

    // tire_wheel_id representing last insert tire_advertisement to SQL database 
    // is manually set for false until saved tire advertisement to SQL databesa to tire_advertisement table
    $tire_wheel_id = $_POST["tire_wheel_id"];

    // value from registration form for tire advertisement
    $tire_category = $_POST["tire_category"];
    $tire_brand = $_POST["tire_brand"];
    $tire_model = $_POST["tire_model"];
    $type = $_POST["type"];
    $year_of_manufacture = $_POST["year_of_manufacture"];
    $tire_width = $_POST["tire_width"];
    $height = $_POST["height"];
    $construction = $_POST["construction"];
    $average = $_POST["average"];
    $weight_index = $_POST["weight_index"];
    $speed_index = $_POST["speed_index"];

    // value from registration form for wheel advertisement
    $wheel_category = $_POST["wheel_category"];
    $wheel_brand = $_POST["wheel_brand"];
    $wheel_model = $_POST["wheel_model"];
    $wheel_average = $_POST["wheel_average"];
    $spacing = $_POST["spacing"];
    $wheel_width = $_POST["wheel_width"];
    $et = $_POST["et"];
    $wheel_color = $_POST["wheel_color"];
    $price = $_POST["price"];
    $description = $_POST["description"];


    // save all car dvertisement do SQL car_advertisement table
    $update_tire_wheel = TireWheel::updateTireWheelInfoAdvertisement($connection, $tire_wheel_id, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $tire_width, $height, $construction, $average, $weight_index, $speed_index, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $wheel_width, $et, $wheel_color, $price, $description);

    
    if ($update_tire_wheel){
        Url::redirectUrl("/autobajo/admin/tire-wheel-profil.php?tire_wheel_id=$tire_wheel_id&active_advertisement=1");
    } else {
        $not_update_done = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>