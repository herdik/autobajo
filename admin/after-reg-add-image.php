<?php

require "../classes/Database.php";
require "../classes/Url.php";
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

    // car_id representing special id for one car_advertisement to SQL database 
    $car_id = $_POST["car_id"];
    
    // title image for car advertisement
    $car_images = $_FILES["car_image"];
    $image_count = count($_FILES["car_image"]["name"]);
    
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

                            // save title image for car advertisement to car_image table
                            $image_id = CarImage::insertCarImage($connection, $car_id, $new_image_name, false);
                            

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

    if ($uploaded_images > 0){
        Url::redirectUrl("/autobajo/admin/gallery-car.php?car_id=$car_id&message_error=$count_error_images");
    } else {
        $not_added_car = "Zvolené obrázky sa nepodarilo nahrať";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_car");
    }
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>