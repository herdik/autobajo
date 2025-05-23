<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/AluWheelBasicService.php";

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

    // echo $_POST["alu_wheel_id"];
    // echo "\n";
    // echo $_POST["type"];
    // echo "\n";
    // echo $_POST["price"];
    // echo "\n";
    // echo $_POST["btn"];
    // value from registration form for car advertisement
    $alu_wheel_id = $_POST["alu_wheel_id"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    
    if ($_POST["btn"] === "OK"){
        $update_alu_basic_service = AluWheelBasicService::updateAluWheelBasicService($connection, $alu_wheel_id, $type, $price);
        $redirect_fault = true;
    } elseif ($_POST["btn"] === "X"){
        $delete_alu_basic_service = AluWheelBasicService::deleteAluWheelBasicService($connection, $alu_wheel_id);
        $redirect_fault = true;
    } 
    
    
    if (!$redirect_fault) {
        // Url::redirectUrl("/autobajo/admin/tires-service.php");
        $not_added_contact_info = "Nastala chyba na pri Cenníku pneuservisu";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_contact_info");
    } 
    

} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    
    if ($_GET["new_line"]) {
        $create_new_line = AluWheelBasicService::createAluWheelBasicService($connection);

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