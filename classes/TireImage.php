<?php

 
class TireImage {

    // INSERT IMAGE
    /**
     *
     * ADD IMAGE TO DATABASE
     *
     * @param object $connection - database connection
     * @param int $tire_id - specifically id for specifically tire advertisement
     * @param string $image_name - image_name for specifically tire advertisement
     * @param bool $title_image - title_image for specifically tire advertisement
     *
     * 
     * @return boolean true or false
     * 
     */
    public static function insertTireImage($connection, $tire_id, $image_name, $title_image){
        $sql = "INSERT INTO tire_image (tire_id, image_name, title_image)
                VALUES (:tire_id, :image_name, :title_image)";
       
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        $stmt->bindValue(":title_image", $title_image, PDO::PARAM_BOOL);


        try {
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception ("Vloženie obrázku pneumatiky do databázi sa nepodarilo");
            }
        } catch (Exception $e) {
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii insertTireImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }

    }

}