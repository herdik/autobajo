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
    if (isset($_POST['select_changed'])){
        $selected_car_brand = $_POST["car_brand"];
        $car_models = Car::getAllCarsInfo($connection, 'car_model', $selected_car_brand);
        if ($car_models){
            header('content-type: application/json');
            echo json_encode($car_models);
        }
        
    }
    
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>