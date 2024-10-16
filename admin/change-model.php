<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Car.php";
require "../classes/Tire.php";
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
    if (isset($_POST['select_changed'])){
        
        if ($_POST['type'] === "car"){
            $selected_car_brand = $_POST["car_brand"];
            $models = Car::getAllCarsInfo($connection, 'car_model', $selected_car_brand);
            
        } elseif ($_POST['type'] === "tire"){
            
            $selected_tire_brand = $_POST["tire_brand"];
            $models = Tire::getAllTiresInfo($connection, 'tire_model', $selected_tire_brand);

        } elseif ($_POST['type'] === "wheel"){
            
            $selected_wheel_brand = $_POST["wheel_brand"];
            $models = Wheel::getAllWheelsInfo($connection, 'wheel_model', $selected_wheel_brand);

        }
        
        if ($models){
            header('content-type: application/json');
            echo json_encode($models);
        }
        
    }
    
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>