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

    // how many images were successfully uploaded
    $uploaded_images = 0;

    // gallery 1 means add pistures to gallery and gallery 0 means add title image 
    $gallery = filter_var($_POST["gallery"], FILTER_VALIDATE_BOOLEAN);


    // insert new image/images
    if ($_POST["submit"] === "Pridať"){

        // car_id representing special id for one car_advertisement to SQL database 
        $car_id = $_POST["car_id"];

        // title image for car advertisement
        $car_images = $_FILES["car_image"];

        if (!$gallery) {
            $car_image = $car_images;
            $car_images = array();
            foreach ($car_image as $key => $value){
                $new_array = array();
                $new_array[0] = $value;
                $car_images[$key] = $new_array;
                
            }
        }
        
        $image_count = count($car_images["name"]);
        
        // count not uloaded pictures
        $count_error_images = 0;

        // update all vehicle equipment according registration form for car advertisement
        if($image_count > 0){
            for($i=0; $i<$image_count;$i++){
        
                // isset is not null
                if(isset($_POST["submit"]) && isset($car_images)){
                    
                    $image_name = $car_images["name"][$i];
                    $image_size = $car_images["size"][$i];
                    // temporary saved file/image
                    $image_tmp_name = $car_images["tmp_name"][$i];
                    $error = $car_images["error"][$i];

                    // how many errors is
                    if ($error === 0){
                        // 10000000 is 10MB
                        if ($image_size > 10000000){
                            // too big picture
                            $count_error_images += 1;
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


                                // save new title image
                                if (!$gallery){
                                    $updated_title_img = Car::updateCarImageAdvertisement($connection, $new_image_name, $car_id);
                                }
                                // save title image for car advertisement to car_image table
                                $image_id = CarImage::insertCarImage($connection, $car_id, $new_image_name);
                                
                                
                                

                                if ($image_id) {
                                    if(!file_exists("../uploads/cars/" . $car_id)){
                                        // 0777 authorizations
                                        mkdir("../uploads/cars/" . $car_id, 0777, false);
                                    }
                
                                    // create path where will save image
                                    $image_upload_path = "../uploads/cars/" . $car_id . "/" . $new_image_name;
                
                                    // upload image - change temporary image path for path to current registered player
                                    
                                    if  (move_uploaded_file($image_tmp_name, $image_upload_path)){
                                        $uploaded_images += 1;
                                    } else {
                                        $count_error_images += 1;
                                    }

                                    
                                } else {
                                    $count_error_images += 1;
                                }

                                
                            } else {
                                // redirect to error site
                                $count_error_images += 1;
                            }
                        }
                    } else {
                        // error 4 = is UPLOAD_ERR_NO_FILE
                        $count_error_images += 1;
                        
                    }
                }
            }
        }   
    } else {
        // update title image
        if ($_POST["action"] === "add" and isset($_POST["submit"])){
            $image_id = $_POST["image_id"];
            $image_name = CarImage::getCarImage($connection, $image_id)["image_name"];
            $car_id = CarImage::getCarImage($connection, $image_id)["car_id"];
            if($image_name){
                $title_img_update = Car::updateCarImageAdvertisement($connection, $image_name, $car_id);
                if ($title_img_update){
                    $uploaded_images += 1;
                } else {
                    // redirect to error site
                    $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                }
            } else {
                // redirect to error site
                $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
            }
        }
    }

    if ($uploaded_images > 0){
        if (!$gallery){
            Url::redirectUrl("/autobajo/admin/car-profil.php?car_id=$car_id&active_advertisement=1");
        } else {
            Url::redirectUrl("/autobajo/admin/gallery-car.php?car_id=$car_id&message_error=$count_error_images");
        }
        
    } else {
        $not_added_car = "Zvolené obrázky sa nepodarilo nahrať";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_car");
    }
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>