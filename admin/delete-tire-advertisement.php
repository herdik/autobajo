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


    // ************ insert new title image/ add images to gallery *********
    if ($_POST["submit"] === "Vymazať"){
        $tire_id = $_POST["tire_id"];
        $dirname = "../uploads/tires/$tire_id/";

        $deleted_advertisement = Tire::deleteTireAdvertImgsDirImgs($connection, $tire_id, $dirname);
        
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