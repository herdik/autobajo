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


if (($_SERVER["REQUEST_METHOD"] === "GET") || ($_SERVER["REQUEST_METHOD"] === "POST")){
    
    // if is error create error message
    $redirect_status_error = true;

    // database connection
    $database = new Database();
    $connection = $database->connectionDB();


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $status = filter_var($_POST["status"], FILTER_VALIDATE_BOOLEAN);
        $action = $_POST["action"];
        $tire_wheel_id = $_POST["tire_wheel_id"];
    } else {
        $keys = array_keys($_GET);
        $status = filter_var($_GET[$keys[0]], FILTER_VALIDATE_BOOLEAN);
        $action = ($keys[0]);
        $tire_wheel_id = $_GET["tire_wheel_id"];

    } 

    if ((isset($status) && is_bool($status)) && (isset($tire_wheel_id) && is_numeric($tire_wheel_id))){
            
        if ($action === "active"){
            if ($status){
                $active = true;
                $reserved = false;
                $sold = false;
            } else {
                $active = false;
                $reserved = false;
                $sold = false;
            }
        } elseif ($action === "reserved"){
            if ($status){
                $active = true;
                $reserved = true;
                $sold = false;
            } else {
                $active = true;
                $reserved = false;
                $sold = false;
            }
        } elseif ($action === "sold"){
            if ($status){
                $active = true;
                $reserved = false;
                $sold = true;
            } else {
                $active = true;
                $reserved = false;
                $sold = false;
            }
        }

        $update_status_advertisement = TireWheel::updateTireWheelStatusAdvertisement($connection, $active, $reserved, $sold, $tire_wheel_id);

        if ($update_status_advertisement) {
            $redirect_status_error = false;
        } 

    }
    
    if (!$redirect_status_error){
        if ($action === "active") {
            Url::redirectUrl("/autobajo/admin/tire-wheel-advertisement.php?");
        } else {
            // Url::redirectUrl("/autobajo/admin/tire-wheel-profil.php?tire_wheel_id=$tire_wheel_id&active_advertisement=1");
        }
    } else {
        $not_added_tire = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_tire"); 
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>