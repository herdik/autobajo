<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Tire.php";

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

    // tire_id representing last insert tire_advertisement to SQL database 
    // is manually set for false until saved tire advertisement to SQL databesa to tire_advertisement table
    $tire_id = $_POST["tire_id"];

    // value from registration form for tire advertisement
    $tire_category = $_POST["tire_category"];
    $tire_brand = $_POST["tire_brand"];
    $tire_model = $_POST["tire_model"];
    $type = $_POST["type"];
    $year_of_manufacture = $_POST["year_of_manufacture"];
    $width = $_POST["width"];
    $height = $_POST["height"];
    $construction = $_POST["construction"];
    $average = $_POST["average"];
    $weight_index = $_POST["weight_index"];
    $speed_index = $_POST["speed_index"];
    $tire_price = $_POST["tire_price"];
    $tire_description = $_POST["tire_description"];


    // save all car dvertisement do SQL car_advertisement table
    $update_tire = Tire::updateTireInfoAdvertisement($connection, $tire_id, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description);

    
    if ($update_tire){
        Url::redirectUrl("/autobajo/admin/tire-profil.php?tire_id=$tire_id&active_advertisement=1");
    } else {
        $not_update_done = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>