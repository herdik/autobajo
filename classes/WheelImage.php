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

}