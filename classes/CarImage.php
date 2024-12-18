<?php

 
class CarImage {

    // INSERT IMAGE
    /**
     *
     * ADD IMAGE TO DATABASE
     *
     * @param object $connection - database connection
     * @param int $car_id - specifically id for specifically car advertisement
     * @param string $image_name - image_name for specifically car advertisement
     *
     * 
     * @return boolean true or false
     * 
     */
    public static function insertCarImage($connection, $car_id, $image_name, $priority){
        $sql = "INSERT INTO car_image (car_id, image_name, priority)
                VALUES (:car_id, :image_name, :priority)";
       
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        $stmt->bindValue(":priority", $priority, PDO::PARAM_INT);


        try {
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception ("Vloženie obrázku do databázi sa nepodarilo");
            }
        } catch (Exception $e) {
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii insertCarImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }

    }

    /**
     *
     * RETURN ALL CARS IMAGES INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param object $car_id - car_id
     *
     * @return array array of objects, one object mean one car foto
     */
    public static function getAllCarsImages($connection, $car_id, $columns = "*"){
        $sql = "SELECT $columns
                FROM car_image
                WHERE car_id = :car_id
                ORDER BY priority, image_id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o fotkách áut sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllCarsImages, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }
    

    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CAR IMAGE
     *
     * @param object $connection - database connection
     * @param int $car_id - specifically id for specifically car advertisement
     * @param string $image_name - image_name for specifically car advertisement
     *
     * 
     * @return boolean true or false
     */
    public static function updateCarImage($connection, $car_id, $image_name){

        $sql = "UPDATE car_image
                SET image_name = :image_name
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update obrázku auta inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateCarImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


     /**
     *
     * RETURN CAR IMAGE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int image_id - represent one image_id
     * @return array all info for one image
     */
    public static function getCarImage($connection, $image_id){
        $sql = "SELECT *
                FROM car_image
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one car
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o obrázku auta sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getCarImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }

    /**
     *
     * RETURN CAR IMAGE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int image_id - represent one image_id
     * @return array all info for one image
     */
    public static function getMaxPriorityNumber($connection, $car_id){
        $sql = "SELECT MAX(priority) 
                FROM car_image
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one car
                return $stmt->fetch(PDO::FETCH_COLUMN);
            } else {
                throw Exception ("Príkaz pre získanie najvyšieho priority čísla podľa car id obrázku auta sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getCarImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }


    /**
     *
     * DELETE SELECTED IMAGE FROM FOLDER
     *
     * @param object $connection - connection to database
     * @param string $path
     * 
     * @return boolean if delete file is successful
     */
    public static function deleteCarImageFromDirectory($path){
        try {
            // check File is exists
            if(!file_exists($path)){
                throw new Exception("Súbor neexistuje a preto nemôže byť zmazaný");
            }
    
            // delete image from folder
            if(unlink($path)){
                return true;
            } else {
                throw new Exception("Pri zmazání súboru došlo k chybe");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteCarImageFromDirectory, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * REDUCE IMAGE SIZE
     *
     * @param object $current_image - image ["tmp_name"] 
     * @param string $path - $upload_folder to save image in folder
     * @param int $maxWidth - max width for image
     * @param int $maxHeight - max height for image
     * @param int $quality - quality of image
     * 
     * @return boolean if delete file is successful
     */
    public static function reduce_img_size($current_image, $upload_folder, $maxWidth, $maxHeight, $quality){

        $info_image = getimagesize($current_image);
        $current_width = $info_image[0];
        $current_height = $info_image[1];
        $type = $info_image['mime'];
        

        // New Dimenssions of Image
        $aspectRatio = $current_width / $current_height;
        if ($current_width > $current_height) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $aspectRatio;
        } else {
            $newHeight = $maxHeight;
            $newWidth = $maxHeight * $aspectRatio;
        }

        // Načítať pôvodný obrázok podľa jeho typu
        if ($type == 'image/jpeg' || $type == 'image/jpeg'){
            $image = imagecreatefromjpeg($current_image);
        } elseif ($type == 'image/png'){
            $image = imagecreatefrompng($current_image);
        }

        // New Image with new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $current_width, $current_height);

        // save compressed image to folder
        if ($type == 'image/jpeg' || $type == 'image/jpeg'){
            imagejpeg($newImage, $upload_folder, $quality);
        } elseif ($type == 'image/png'){
            imagepng($newImage, $upload_folder);
        }


        // DELETED FROM MEMORY
        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }



    /**
     *
     * DELETE SELECTED IMAGE FROM GALLERY AND FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $image_id - truck wheel for truck service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteCarImage($connection, $image_id){
        $sql = "DELETE 
                FROM car_image
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre vymazanie všetkých dát o vybranom obrázku z galérie sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteCarImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }



    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CAR IMAGE
     *
     * @param object $connection - database connection
     * @param int $image_id - specifically id for specifically car advertisement
     * @param string $priority - priority for specifically car advertisement
     *
     * 
     * @return boolean true or false
     */
    public static function updateCarImagePriority($connection, $image_id, $priority){

        $sql = "UPDATE car_image
                SET priority = :priority
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
        $stmt->bindValue(":priority", $priority, PDO::PARAM_INT);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update obrázku auta inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateCarImagePriority, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    
}