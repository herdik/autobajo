<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Tire.php";
require "../classes/TireImage.php";

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

    
    // tire_id representing last insert tire_advertisement to SQL database 
    // is manually set for false until saved tire advertisement to SQL databesa to tire_advertisement table
    $tire_id = false;

    // value from registration form for tire advertisement
    $tire_category = $_POST["tire_category"];
    $tire_brand = $_POST["tire_brand"];
    $tire_model = $_POST["tire_model"];
    $type = $_POST["type"];
    $year_of_manufacture = $_POST["year_of_manufacture"];
    $width = $_POST["width"];
    $height = $_POST["height"];
    $construction = $_POST["construction"];
    $average = $_POST["average"];
    $weight_index = $_POST["weight_index"];
    $speed_index = $_POST["speed_index"];
    $tire_price = $_POST["tire_price"];
    $tire_description = $_POST["tire_description"];

    // title image for tire advertisement
    $tire_image = $_FILES["tire_image"];

    // isset is not null
    if(isset($_POST["submit"]) && isset($tire_image)){
        $image_name = $tire_image["name"];
        $image_size = $tire_image["size"];
        // temporary saved file/image
        $image_tmp_name = $tire_image["tmp_name"];
        $error = $tire_image["error"];

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
                    $tire_id = Tire::createTireAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description, true, false, false, $new_image_name);

                    if ($tire_id) {
                        // save title image for tire advertisement to tire_image table
                        $image_id = TireImage::insertTireImage($connection, $tire_id, $new_image_name, true);
                    }

                    if ($tire_id && $image_id) {
                        if(!file_exists("../uploads/tires/" . $tire_id)){
                            // 0777 authorizations
                            mkdir("../uploads/tires/" . $tire_id, 0777, true);
                        }
    
                        // create path where will save image
                        $image_upload_path = "../uploads/tires/" . $tire_id . "/" . $new_image_name;
    
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

                // save all tire dvertisement do SQL tire_advertisement table
                $tire_id = Tire::createTireAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description, true, false, false, $new_image_name);

                if ($tire_id) {
                    // save title image for tire advertisement to tire_image table
                    $image_id = TireImage::insertTireImage($connection, $tire_id, $new_image_name, true);
                }
            }
        }
    }
    
    if (!$redirect_status){
    
        if ($tire_id && $image_id){
            Url::redirectUrl("/autobajo/admin/tire-profil.php?tire_id=$tire_id&active_advertisement=1");
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