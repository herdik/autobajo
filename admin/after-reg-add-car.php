<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Car.php";
require "../classes/CarImage.php";

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

    // if redirect is active/true do not save data to database and not to use onother redirrect
    $redirect_status = false;

    // manually set all boolean value for car advertisement - vehicle_equipment
    $vehicle_equipment = array();

    // car_id representing last insert car_advertisement to SQL database 
    // is manually set for false until saved car advertisement to SQL databesa to car_advertisement table
    $car_id = false;

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

    // title image for car advertisement
    $car_image = $_FILES["car_image"];

    // update all vehicle equipment according registration form for car advertisement
    if(count($equipment_array) > 0){
        for($i=0; $i<count($equipment_array);$i++){
            $array_index = intval($equipment_array[$i]);
            $vehicle_equipment[$array_index] = true;
        }
    }
    
    // isset is not null
    if(isset($_POST["submit"]) && isset($car_image)){
        $image_name = $car_image["name"];
        $image_size = $car_image["size"];
        // temporary saved file/image
        $image_tmp_name = $car_image["tmp_name"];
        $error = $car_image["error"];

        // how many errors is
        if ($error === 0){
            // 10000000 is 10MB
            if ($image_size > 10000000){
                // redirect to error site
                $too_big = "súbor je príliš veľký";
                Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$too_big");
                $redirect_status = true;
            } else {
                // use pathinfo to get filename extension
                $image_extension = pathinfo($image_name, PATHINFO_EXTENSION); 
                // to lowercase image extension    
                $image_extension_lower_case = strtolower($image_extension);

                // allowed extensions 
                $allowed_extensions = ["jpg", "jpeg", "png"];
                
                // in_array — Checks if a value exists in an array
                if(in_array($image_extension_lower_case, $allowed_extensions)){

                    // uniq name for image
                    $new_image_name = uniqid("IMG-", true) . "." . $image_extension;

                    // save all car dvertisement do SQL car_advertisement table
                    $car_id = Car::createCarAdvertisement($connection, $car_brand, $car_model, $car_color, $year_of_manufacture, $engine_volume, $past_km, $car_price, $fuel_type, $gearbox, $car_description, $other_equipment, $vehicle_equipment[0], $vehicle_equipment[1], $vehicle_equipment[2], $vehicle_equipment[3], $vehicle_equipment[4], $vehicle_equipment[5], $vehicle_equipment[6], $vehicle_equipment[7], $vehicle_equipment[8], $vehicle_equipment[9], $vehicle_equipment[10], $vehicle_equipment[11], true, false, false, $new_image_name);

                    if ($car_id) {
                        // save title image for car advertisement to car_image table
                        $image_id = CarImage::insertCarImage($connection, $car_id, $new_image_name);
                    }

                    if ($car_id && $image_id) {
                        if(!file_exists("../uploads/cars/" . $car_id)){
                            // 0777 authorizations
                            mkdir("../uploads/cars/" . $car_id, 0777, true);
                        }
    
                        // create path where will save image
                        $image_upload_path = "../uploads/cars/" . $car_id . "/" . $new_image_name;
    
                        // upload image - change temporary image path for path to current registered player
                        move_uploaded_file($image_tmp_name, $image_upload_path);
                    }

                    
                } else {
                    // redirect to error site
                    $not_allowed_extension = "nedovolená koncovka";
                    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_allowed_extension");
                    $redirect_status = true;
                }
            }
        } else {
            // error 0 = something went wrong 
            // error 4 = is UPLOAD_ERR_NO_FILE
            if ($error == 4 || ($image_size == 0 && $error == 0)){
                // if user did not choose title image ->

                $new_image_name = "no-photo-car.jpg";

                // save all car dvertisement do SQL car_advertisement table
                $car_id = Car::createCarAdvertisement($connection, $car_brand, $car_model, $car_color, $year_of_manufacture, $engine_volume, $past_km, $car_price, $fuel_type, $gearbox, $car_description, $other_equipment, $vehicle_equipment[0], $vehicle_equipment[1], $vehicle_equipment[2], $vehicle_equipment[3], $vehicle_equipment[4], $vehicle_equipment[5], $vehicle_equipment[6], $vehicle_equipment[7], $vehicle_equipment[8], $vehicle_equipment[9], $vehicle_equipment[10], $vehicle_equipment[11], true, false, false, $new_image_name);

                if ($car_id) {
                    // save title image for car advertisement to car_image table
                    $image_id = CarImage::insertCarImage($connection, $car_id, $new_image_name);
                }
            }
        }
    }
    
    if (!$redirect_status){
    
        if ($car_id && $image_id){
            Url::redirectUrl("/autobajo/admin/car-profil.php?car_id=$car_id&active_advertisement=1");
        } else {
            $not_added_car = "Nový inzerát auta sa nepodarilo pridať";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_car");
        }
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>