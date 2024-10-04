<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Wheel.php";
require "../classes/WheelImage.php";

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

    
    // wheel_id representing last insert wheel_advertisement to SQL database 
    // is manually set for false until saved wheel advertisement to SQL databesa to wheel_advertisement table
    $wheel_id = false;

    // value from registration form for wheel advertisement
    $wheel_category = $_POST["wheel_category"];
    $wheel_brand = $_POST["wheel_brand"];
    $wheel_model = $_POST["wheel_model"];
    $wheel_average = $_POST["wheel_average"];
    $spacing = $_POST["spacing"];
    $width = $_POST["width"];
    $et = $_POST["et"];
    $wheel_color = $_POST["wheel_color"];
    $wheel_price = $_POST["wheel_price"];
    $wheel_description = $_POST["wheel_description"];

    // title image for wheel advertisement
    $wheel_image = $_FILES["wheel_image"];

    // isset is not null
    if(isset($_POST["submit"]) && isset($wheel_image)){
        $image_name = $wheel_image["name"];
        $image_size = $wheel_image["size"];
        // temporary saved file/image
        $image_tmp_name = $wheel_image["tmp_name"];
        $error = $wheel_image["error"];

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

                    // save all wheel dvertisement do SQL wheel_advertisement table
                    $wheel_id = Wheel::createWheelAdvertisement($connection, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $width, $et, $wheel_color, $wheel_price, $wheel_description, true, false, false, $new_image_name);

                    if ($wheel_id) {
                        // save title image for wheel advertisement to wheel_image table
                        $image_id = WheelImage::insertWheelImage($connection, $wheel_id, $new_image_name);
                        var_dump($image_id);
                        var_dump($wheel_id);
                    }

                    if ($wheel_id && $image_id) {
                        if(!file_exists("../uploads/wheels/" . $wheel_id)){
                            // 0777 authorizations
                            mkdir("../uploads/wheels/" . $wheel_id, 0777, true);
                        }
    
                        // create path where will save image
                        $image_upload_path = "../uploads/wheels/" . $wheel_id . "/" . $new_image_name;
    
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

                // save all wheel dvertisement do SQL wheel_advertisement table
                $wheel_id = Wheel::createWheelAdvertisement($connection, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $width, $et, $wheel_color, $wheel_price, $wheel_description, true, false, false, $new_image_name);

                if ($wheel_id) {
                    // save title image for wheel advertisement to wheel_image table
                    $image_id = WheelImage::insertWheelImage($connection, $wheel_id, $new_image_name);
                }
            }
        }
    }
    
    if (!$redirect_status){
    
        if ($wheel_id && $image_id){
            Url::redirectUrl("/autobajo/admin/wheel-profil.php?wheel_id=$wheel_id&active_advertisement=1");
        } else {
            $not_added_wheel = "Nový inzerát disku sa nepodarilo pridať";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_wheel");
        }
    }
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>