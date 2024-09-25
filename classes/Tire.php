<?php

class Tire {


    /**
     *
     * ADD PLAYER/USER TO DATABASE
     *
     * @param object $connection - database connection
     * @param string $tire_category - tire_category
     * @param string $tire_brand - tire_brand
     * @param string $tire_model - tire_model
     * @param string $type - type - sommer/winter or all year
     * @param integer $year_of_manufactur - year_of_manufactur
     * @param float $width - width tire
     * @param float $height - height tire
     * @param string $construction - construction tire
     * @param integer $average - average of tire
     * @param integer $weight_index - weight_index
     * @param string $speed_index - speed_index
     * @param integer $tire_price - tire_price
     * @param string $tire_description - tire_description
     * @param string $tire_image - tire_image
    
     * @return integer $car_id - id for car advertisement
     * 
     */
    
    public static function createTireAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description, $tire_image) {


        // sql scheme
        $sql = "INSERT INTO tire_advertisement (tire_category, tire_brand, tire_model, type, year_of_manufacture, width, height, construction, average, weight_index, speed_index, tire_price, tire_description, tire_image)
        VALUES (:tire_category, :tire_brand, :tire_model, :type, :year_of_manufacture, :width, :height, :construction, :average, :weight_index, :speed_index, :tire_price, :tire_description, :tire_image)";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_category", $tire_category, PDO::PARAM_STR);
        $stmt->bindValue(":tire_brand", $tire_brand, PDO::PARAM_STR);
        $stmt->bindValue(":tire_model", $tire_model, PDO::PARAM_STR);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_manufacture", $year_of_manufacture, PDO::PARAM_INT);
        $stmt->bindValue(":width", $width, PDO::PARAM_STR);
        $stmt->bindValue(":height", $height, PDO::PARAM_STR);
        $stmt->bindValue(":construction", $construction, PDO::PARAM_STR);
        $stmt->bindValue(":average", $average, PDO::PARAM_INT);
        $stmt->bindValue(":weight_index", $weight_index, PDO::PARAM_INT);
        $stmt->bindValue(":speed_index", $speed_index, PDO::PARAM_STR);
        $stmt->bindValue(":tire_price", $tire_price, PDO::PARAM_INT);
        $stmt->bindValue(":tire_description", $tire_description, PDO::PARAM_STR);
        $stmt->bindValue(":tire_image", $tire_image, PDO::PARAM_STR);
        
        try {
            // execute all data to SQL Database to car_advertisement
            if($stmt->execute()){
                $tire_id = $connection->lastInsertId();
                return $tire_id;
            } else {
                throw new Exception ("Vytvorenie nového inzerátu pneumatiky sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createTireAdvertisement\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL TIRES ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one tire infos
     */
    public static function getAllTiresAdvertisement($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM tire_advertisement";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o inzerátoch pneumatík sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllTiresAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN ID CAR FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int tire_id - represent one tire_id
     * @return array all info for one tire_id
     */
    public static function getTire($connection, $tire_id){
        $sql = "SELECT *
                FROM tire_advertisement
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one car
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o inzeráte pneumatiky sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getTire, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }

}