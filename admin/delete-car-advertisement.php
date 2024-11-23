<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Car.php";

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


    // ************ insert new title image/ add images to gallery *********
    if ($_POST["submit"] === "Vymazať"){
        $car_id = $_POST["car_id"];
        $dirname = "../uploads/cars/$car_id/";

        $deleted_advertisement = Car::deleteCarAdvertImgsDirImgs($connection, $car_id, $dirname);
        

        // if ($deleted_advertisement){
        //     Url::redirectUrl("/autobajo/admin/car-advertisement.php?car_history=0");
        // } else {
        //     $not_update_done = "Update inzerátu sa nepodaril.";
        //     Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
        // }
        if (!$deleted_advertisement){
            $not_update_done = "Update inzerátu sa nepodaril.";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
        } 
        
    }  


  
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>