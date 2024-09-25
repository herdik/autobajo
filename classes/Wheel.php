<?php

class Wheel {


    /**
     *
     * ADD PLAYER/USER TO DATABASE
     *
     * @param object $connection - database connection
     * @param string $wheel_category - wheel_category
     * @param string $wheel_brand - wheel_brand
     * @param string $wheel_model - wheel_model
     * @param string wheel_average - wheel_average
     * @param integer spacing - spacing of wheel
     * @param float $width - width wheel
     * @param float $et - et wheel
     * @param string $wheel_color - color of wheel
     * @param integer $wheel_price - wheel_price
     * @param string $wheel_description - wheel_description
     * @param string $wheel_image - wheel_image
    
     * @return integer $car_id - id for car advertisement
     * 
     */
    
    public static function createWheelAdvertisement($connection, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $width, $et, $wheel_color, $wheel_price, $wheel_description, $wheel_image) {


        // sql scheme
        $sql = "INSERT INTO wheel_advertisement (wheel_category, wheel_brand, wheel_model, wheel_average, spacing, width, et, wheel_color, wheel_price, wheel_description, wheel_image)
        VALUES (:wheel_category, :wheel_brand, :wheel_model, :wheel_average, :spacing, :width, :et, :wheel_color, :wheel_price, :wheel_description, :wheel_image)";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":wheel_category", $wheel_category, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_brand", $wheel_brand, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_model", $wheel_model, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_average", $wheel_average, PDO::PARAM_INT);
        $stmt->bindValue(":spacing", $spacing, PDO::PARAM_STR);
        $stmt->bindValue(":width", $width, PDO::PARAM_STR);
        $stmt->bindValue(":et", $et, PDO::PARAM_INT);
        $stmt->bindValue(":wheel_color", $wheel_color, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_price", $wheel_price, PDO::PARAM_INT);
        $stmt->bindValue(":wheel_description", $wheel_description, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_image", $wheel_image, PDO::PARAM_STR);
        
        try {
            // execute all data to SQL Database to car_advertisement
            if($stmt->execute()){
                $wheel_id = $connection->lastInsertId();
                return $wheel_id;
            } else {
                throw new Exception ("Vytvorenie nového inzerátu pneumatiky sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createWheelAdvertisement\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL TIRES ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one wheel infos
     */
    public static function getAllWheelsAdvertisement($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM wheel_advertisement";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o inzerátoch diskov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllWheelsAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN ID CAR FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int wheel_id - represent one wheel_id
     * @return array all info for one wheel_id
     */
    public static function getWheel($connection, $wheel_id){
        $sql = "SELECT *
                FROM wheel_advertisement
                WHERE wheel_id = :wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":wheel_id", $wheel_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one car
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o inzeráte disku sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getWheel, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }

}