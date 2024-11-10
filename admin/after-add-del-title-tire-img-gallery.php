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

    // using ajax and jquery
    $refresh_page = false;

    // how many images were successfully uploaded
    $uploaded_images = 0;

    // * gallery 1 means add pistures to gallery/delete pistures from gallery *
    // * gallery 0 means add/update title image *
    $gallery = filter_var($_POST["gallery"], FILTER_VALIDATE_BOOLEAN);

    // count not uloaded pictures to gallery or deleted pictures from gallery
    $count_error_images = 0;


    // ************ insert new title image/ add images to gallery *********
    if ($_POST["submit"] === "Pridať"){

        
        // tire_id representing special id for one tire_advertisement to SQL database 
        $tire_id = $_POST["tire_id"];

        // title image for tire advertisement
        $tire_images = $_FILES["tire_image"];

        // settings for title image - set as array
        if (!$gallery) {
            $tire_image = $tire_images;
            $tire_images = array();
            foreach ($tire_image as $key => $value){
                $new_array = array();
                $new_array[0] = $value;
                $tire_images[$key] = $new_array;
                
            }
            // basic settings for title image to redirect profil advertisement and title image will be uploaded 
            $refresh_page = true;
        }
        // settings for title image - set as array

        // checking number of images
        $image_count = count($tire_images["name"]);

        // update all images according registration form for advertisement
        if($image_count > 0){
            for($i=0; $i<$image_count;$i++){
                
                // isset is not null
                if(isset($_POST["submit"]) && isset($tire_images)){
                    
                    $image_name = $tire_images["name"][$i];
                    $image_size = $tire_images["size"][$i];
                    // temporary saved file/image
                    $image_tmp_name = $tire_images["tmp_name"][$i];
                    $error = $tire_images["error"][$i];

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
                                    $updated_title_img = Tire::updateTireImageAdvertisement($connection, $new_image_name, $tire_id);

                                    // if update title false than redirect 
                                    if (!$updated_title_img){
                                        // redirect to error site
                                        $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                                        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                                    }
                                }
                                // save title image for tire advertisement to tire_image table / insert new images to gallery
                                $priority = TireImage::getMaxPriorityNumber($connection, $tire_id);
                                if (empty($priority)){
                                    $priority = 0;
                                }

                                $image_id = TireImage::insertTireImage($connection, $tire_id, $new_image_name, $priority + 1);
                                
                                
                                

                                if ($image_id) {
                                    if(!file_exists("../uploads/tires/" . $tire_id)){
                                        // 0777 authorizations
                                        mkdir("../uploads/tires/" . $tire_id, 0777, false);
                                    }
                
                                    // create path where will save image
                                    $image_upload_path = "../uploads/tires/" . $tire_id . "/" . $new_image_name;
                
                                    // upload image - change temporary image path for path to current registered player
                                    
                                    if  (move_uploaded_file($image_tmp_name, $image_upload_path)){
                                        $uploaded_images += 1;
                                    } else {
                                        // save new title image false
                                        if (!$gallery){
                                            // redirect to error site
                                            $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                                            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                                        } else {
                                            // error 4 = is UPLOAD_ERR_NO_FILE
                                            $count_error_images += 1;
                                        }
                                    }

                                    
                                } else {
                                    // save new title image false
                                    if (!$gallery){
                                        // redirect to error site
                                        $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                                        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                                    } else {
                                        // error 4 = is UPLOAD_ERR_NO_FILE
                                        $count_error_images += 1;
                                    }
                                }

                                
                            } else {
                                // save new title image false
                                if (!$gallery){
                                    // redirect to error site
                                    $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                                    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                                } else {
                                    // error 4 = is UPLOAD_ERR_NO_FILE
                                    $count_error_images += 1;
                                }
                            }
                        }
                    } else {
                        // save new title image false
                        if (!$gallery){
                            // redirect to error site
                            $not_updated = "Zvolené obrázky sa nepodarilo nahrať";
                            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated");
                        } else {
                            // error 4 = is UPLOAD_ERR_NO_FILE
                            $count_error_images += 1;
                        }   
                    }
                }
            }
        }   
    // ************ insert new title image/ add images to gallery *********
    } else {
        
        // ********* update title image from gallery *************
        if ($_POST["action"] === "add" and isset($_POST["submit"])){
            // use redirect to profil
            $refresh_page = true;

            $image_id = $_POST["image_id"];
            $image_name = TireImage::getTireImage($connection, $image_id)["image_name"];
            $tire_id = TireImage::getTireImage($connection, $image_id)["tire_id"];
            if($image_name){
                $title_img_update = Tire::updateTireImageAdvertisement($connection, $image_name, $tire_id);
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
        // ********* update title image from gallery *************
        } else {
        // ***** deleted selected images from gallery and folder********
            // get string array in array
            $images_id = $_POST["image_id"];
            // convert string array to classy array
            $image_id = explode(",", $images_id[0]);
            
            // loop to delete one for one image which is selected by user
            for ($i=0; $i < count($image_id); $i++){
                // get tire id 
                $tire_id = TireImage::getTireImage($connection, $image_id[$i])["tire_id"];
                // get name for image 
                $uploaded_image_name = TireImage::getTireImage($connection, $image_id[$i])["image_name"];
    
                // if gallery has default picture no dot delete default picture
                if ($uploaded_image_name === "no-photo-car.jpg"){
                    $delete_file = true;
                } else {
                    // create path where will delete image from folder
                    $image_delete_path = "../uploads/tires/" . strval($tire_id) . "/" . strval($uploaded_image_name);

                    // deleted file from Folder
                    $delete_file = TireImage::deleteTireImageFromDirectory($image_delete_path);
                }
                
                if ($delete_file){
                    // delete image in database 
                    $deleted_all_img = TireImage::deleteTireImage($connection, $image_id[$i]);

                    // control for delete images from database
                    if (!$deleted_all_img){
                        // if some file wasn't deleted from database add error message to print on gallery site
                        $count_error_images += 1;
                    }
                } else {
                    // if some file wasn't deleted from folder add error message to print on gallery site
                    $count_error_images += 1;
                } 
                
                
            }
            $refresh_page = false;
        // ***** deleted selected images from gallery and folder********
        }
    }

    // redirect to profil adveritsement or if false to error site
    if ($refresh_page){
        if ($uploaded_images > 0){
            if (!$gallery){
                Url::redirectUrl("/autobajo/admin/tire-profil.php?tire_id=$tire_id&active_advertisement=1");
            } else {
                $not_added_tire = "Zvolené obrázky sa nepodarilo nahrať";
                Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_tire");
            }
            
        } else {
            $not_added_tire = "Zvolené obrázky sa nepodarilo nahrať";
            Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_tire");
        }
    } else {
        echo $count_error_images;
    }
    
    
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>