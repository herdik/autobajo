<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/TireWheel.php";
require "../classes/TireWheelImage.php";

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

    
    // tire_wheel_id representing last insert tire_advertisement to SQL database 
    // is manually set for false until saved tire advertisement to SQL databesa to tire_advertisement table
    $tire_wheel_id = false;

    // value from registration form for tire advertisement
    $tire_category = $_POST["tire_category"];
    $tire_brand = $_POST["tire_brand"];
    $tire_model = $_POST["tire_model"];
    $type = $_POST["type"];
    $year_of_manufacture = $_POST["year_of_manufacture"];
    $tire_width = $_POST["tire_width"];
    $height = $_POST["height"];
    $construction = $_POST["construction"];
    $average = $_POST["average"];
    $weight_index = $_POST["weight_index"];
    $speed_index = $_POST["speed_index"];

    // value from registration form for wheel advertisement
    $wheel_category = $_POST["wheel_category"];
    $wheel_brand = $_POST["wheel_brand"];
    $wheel_model = $_POST["wheel_model"];
    $wheel_average = $_POST["wheel_average"];
    $spacing = $_POST["spacing"];
    $wheel_width = $_POST["wheel_width"];
    $et = $_POST["et"];
    $wheel_color = $_POST["wheel_color"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    
    // title image for tire advertisement
    $tire_wheel_image = $_FILES["tire_wheel_image"];

    // isset is not null
    if(isset($_POST["submit"]) && isset($tire_wheel_image)){
        $image_name = $tire_wheel_image["name"];
        $image_size = $tire_wheel_image["size"];
        // temporary saved file/image
        $image_tmp_name = $tire_wheel_image["tmp_name"];
        $error = $tire_wheel_image["error"];

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

                    // save all tire dvertisement do SQL tire_advertisement table
                    $tire_wheel_id = TireWheel::createTireWheelAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $tire_width, $height, $construction, $average, $weight_index, $speed_index, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $wheel_width, $et, $wheel_color, $price, $description, true, false, false, $new_image_name);

                    if ($tire_wheel_id) {
                        // save title image for tire advertisement to tire_wheel_image table
                        $priority = TireWheelImage::getMaxPriorityNumber($connection, $tire_wheel_id);
                        if (empty($priority)){
                            $priority = 0;
                        }

                        $image_id = TireWheelImage::insertTireWheelImage($connection, $tire_wheel_id, $new_image_name, $priority + 1);
                    }

                    if ($tire_wheel_id && $image_id) {
                        if(!file_exists("../uploads/tireswithwheels/" . $tire_wheel_id)){
                            // 0777 authorizations
                            mkdir("../uploads/tireswithwheels/" . $tire_wheel_id, 0777, true);
                        }
    
                        // create path where will save image
                        $image_upload_path = "../uploads/tireswithwheels/" . $tire_wheel_id . "/" . $new_image_name;
    
                        // save file in folder and resize and change quality
                        if ($image_size > 4000000){
                            $quality = 65;
                        } elseif ($image_size > 2000000){
                            $quality = 80;
                        } elseif ($image_size > 1000000){
                            $quality = 90;
                        } elseif ($image_size > 500000){
                            $quality = 95;
                        } else {
                            $quality = false;
                        }
                        if ($quality){
                            // Max width and height for resize image
                            $maxWidth = 1280;
                            $maxHeight = 1024;
                            // resize and change quality
                            TireWheelImage::reduce_img_size($image_tmp_name, $image_upload_path, $maxWidth, $maxHeight, $quality);
                        } else {
                            // upload image - change temporary image path for path to current registered player
                            move_uploaded_file($image_tmp_name, $image_upload_path);
                        }
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

                // save all tire dvertisement do SQL tire_advertisement table
                $tire_wheel_id = TireWheel::createTireWheelAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $tire_width, $height, $construction, $average, $weight_index, $speed_index, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $wheel_width, $et, $wheel_color, $price, $description, true, false, false, $new_image_name);

                if ($tire_wheel_id) {
                    // save title image for tire advertisement to tire_wheel_image table
                    $priority = TireWheelImage::getMaxPriorityNumber($connection, $tire_wheel_id);
                    if (empty($priority)){
                        $priority = 0;
                    }

                    $image_id = TireWheelImage::insertTireWheelImage($connection, $tire_wheel_id, $new_image_name, $priority + 1);
                }
            }
        }
    }
    
    if (!$redirect_status){
    
        if ($tire_wheel_id && $image_id){
            Url::redirectUrl("/autobajo/admin/tire-wheel-profil.php?tire_wheel_id=$tire_wheel_id&active_advertisement=1");
        } else {
            $not_added_tire = "Nový inzerát pneumatiky sa nepodarilo pridať";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_tire");
        }
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>