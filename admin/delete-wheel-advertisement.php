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


    // ************ insert new title image/ add images to gallery *********
    if ($_POST["submit"] === "Vymazať"){
        $wheel_id = $_POST["wheel_id"];
        $dirname = "../uploads/wheels/$wheel_id/";

        $deleted_advertisement = Wheel::deleteWheelAdvertImgsDirImgs($connection, $wheel_id, $dirname);
        
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