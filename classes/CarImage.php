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
     * @param bool $title_image - title_image for specifically car advertisement
     *
     * 
     * @return boolean true or false
     * 
     */
    public static function insertCarImage($connection, $car_id, $image_name, $title_image){
        $sql = "INSERT INTO car_image (car_id, image_name, title_image)
                VALUES (:car_id, :image_name, :title_image)";
       
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        $stmt->bindValue(":title_image", $title_image, PDO::PARAM_BOOL);


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
                ORDER BY image_id";

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

}