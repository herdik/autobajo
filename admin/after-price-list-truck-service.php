<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/TruckService.php";

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

// database connection
$database = new Database();
$connection = $database->connectionDB();

$redirect_fault = false; 

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    // value from registration form for car advertisement
    $truck_service_id = $_POST["truck_service_id"];
    $service_type = $_POST["service_type"];
    $price = $_POST["price"];

    if ($_POST["btn"] === "OK"){
        $update_alu_basic_service = TruckService::updateTruckService($connection, $truck_service_id, $service_type, $price);
        $redirect_fault = true;
    } elseif ($_POST["btn"] === "X"){
        $delete_alu_basic_service = TruckService::deleteTruckService($connection, $truck_service_id);
        $redirect_fault = true;
    } 
    
    
    if (!$redirect_fault) {
        // Url::redirectUrl("/autobajo/admin/tires-service.php");
        $not_added_contact_info = "Nastala chyba na pri Cenníku pneuservisu";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_contact_info");
    }
    

} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
   
    if ($_GET["new_line"]) {
        $create_new_line = TruckService::createTruckService($connection);

        if (!$create_new_line) {
            // Url::redirectUrl("/autobajo/admin/tires-service.php");
            $not_added_contact_info = "Nastala chyba na pri Cenníku pneuservisu";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_contact_info");
        } 
    }
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>