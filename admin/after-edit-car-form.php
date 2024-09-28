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

    var_dump($_POST);
    
    // if is error create error message
    $redirect_status_error = true;

    // database connection
    $database = new Database();
    $connection = $database->connectionDB();

    // manually set all boolean value for car advertisement - vehicle_equipment
    $vehicle_equipment = array();

    // car_id representing last insert car_advertisement to SQL database 
    // is manually set for false until saved car advertisement to SQL databesa to car_advertisement table
    $car_id = $_POST["car_id"];

    // value from registration form for car advertisement
    $car_brand = $_POST["car_brand"];
    $car_model = $_POST["car_model"];
    $car_color = $_POST["car_color"];
    $year_of_manufacture = $_POST["year_of_manufacture"];
    $engine_volume = $_POST["engine_volume"];
    $past_km = $_POST["past_km"];
    $car_price = $_POST["car_price"];
    $fuel_type = $_POST["fuel_type"];
    $gearbox = $_POST["gearbox"];
    $car_description = $_POST["car_description"];
    $other_equipment = $_POST["other_equipment"];
    $el_windows = false;
    $el_seats = false;
    $no_key_start = false;
    $airbag = false;
    $tempomat = false;
    $heated_seat = false;
    $parking_sensor = false;
    $isofix = false;
    $alu_rimes = false;
    $air_condition = false;
    $towing_device = false;
    $alarm = false;


    $vehicle_equipment = [$el_windows, $el_seats, $no_key_start, $airbag, $tempomat, $heated_seat, $parking_sensor, $isofix, $alu_rimes, $air_condition, $towing_device, $alarm];

    // save all boolean value from registration form car advertisement
    $equipment_array = $_POST["vehicle_equipment"];

    // update all vehicle equipment according registration form for car advertisement
    if(count($equipment_array) > 0){
        for($i=0; $i<count($equipment_array);$i++){
            $array_index = intval($equipment_array[$i]);
            $vehicle_equipment[$array_index] = true;
        }
    }


    // save all car dvertisement do SQL car_advertisement table
    $update_car = Car::updateCarInfoAdvertisement($connection, $car_id, $car_brand, $car_model, $car_color, $year_of_manufacture, $engine_volume, $past_km, $fuel_type, $gearbox, $car_price, $car_description, $other_equipment, $vehicle_equipment[0], $vehicle_equipment[1], $vehicle_equipment[2], $vehicle_equipment[3], $vehicle_equipment[4], $vehicle_equipment[5], $vehicle_equipment[6], $vehicle_equipment[7], $vehicle_equipment[8], $vehicle_equipment[9], $vehicle_equipment[10], $vehicle_equipment[11]);

    
    if ($update_car){
        Url::redirectUrl("/autobajo/admin/car-profil.php?car_id=$car_id");
    } else {
        $not_update_done = "Update inzerátu sa nepodaril.";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_update_done"); 
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>