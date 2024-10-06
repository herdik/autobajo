<?php

 
class WheelImage {

    // INSERT IMAGE
    /**
     *
     * ADD IMAGE TO DATABASE
     *
     * @param object $connection - database connection
     * @param int $wheel_id - specifically id for specifically wheel advertisement
     * @param string $image_name - image_name for specifically wheel advertisement
     *
     * 
     * @return boolean true or false
     * 
     */
    public static function insertWheelImage($connection, $wheel_id, $image_name){
        $sql = "INSERT INTO wheel_image (wheel_id, image_name)
                VALUES (:wheel_id, :image_name)";
       
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":wheel_id", $wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);


        try {
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception ("Vloženie obrázku disku do databázi sa nepodarilo");
            }
        } catch (Exception $e) {
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii insertWheelImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }

    }


    /**
     *
     * RETURN ALL WHEELS IMAGES INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param object $wheel_id - wheel_id
     *
     * @return array array of objects, one object mean one wheel foto
     */
    public static function getAllWheelsImages($connection, $wheel_id, $columns = "*"){
        $sql = "SELECT $columns
                FROM wheel_image
                WHERE wheel_id = :wheel_id
                ORDER BY image_id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":wheel_id", $wheel_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o fotkách diskov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllWheelsImages, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }
    

    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED WHEEL IMAGE
     *
     * @param object $connection - database connection
     * @param int $wheel_id - specifically id for specifically wheel advertisement
     * @param string $image_name - image_name for specifically wheel advertisement
     *
     * 
     * @return boolean true or false
     */
    public static function updateWheelImage($connection, $wheel_id, $image_name){

        $sql = "UPDATE wheel_image
                SET image_name = :image_name
                WHERE wheel_id = :wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":wheel_id", $wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update obrázku disku inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateWheelImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


     /**
     *
     * RETURN WHEEL IMAGE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int image_id - represent one image_id
     * @return array all info for one image
     */
    public static function getWheelImage($connection, $image_id){
        $sql = "SELECT *
                FROM wheel_image
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one wheel
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o obrázku disku sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getWheelImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
    public static function deleteWheelImageFromDirectory($path){
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
            error_log("Chyba pri funkcii deleteWheelImageFromDirectory, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
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
    public static function deleteWheelImage($connection, $image_id){
        $sql = "DELETE 
                FROM wheel_image
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
            error_log("Chyba pri funkcii deleteWheelImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}