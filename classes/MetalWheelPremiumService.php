<?php

class MetalWheelPremiumService {

    /**
     *
     * ADD METAL WHEEL NEW TYPE
     *
     * @param object $connection - database connection
     

     * @return boolean true or false
     * 
     */
    public static function createMetalWheelPremiumService($connection) {


        // sql scheme
        $sql = "INSERT INTO metal_wheel_premium_service ()
        VALUES ()";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database

        
        try {
            // execute all data to SQL Database to car_advertisement
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception ("Vytvorenie nového plechového prémiového servisu sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createMetalWheelPremiumService\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL ALU WHEELS PREMIUM SERVICE  INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one metal wheel type
     */
    public static function getAllMetalWheelPremiumService($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM metal_wheel_premium_service
                ORDER BY metal_wheel_id";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o plechových diskoch premiový servis sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllMetalWheelPremiumService, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED METAL WHEEL PREMIUM SERVICE
     *
     * @param object $connection - database connection
     * @param string $type - type of metal wheel
     * @param string $price - price for one metal wheel
     * @param int $metal_wheel_id -  metal_wheel_id
     * 
     * @return boolean if update is successful
     */
    public static function updateMetalWheelPremiumService($connection, $metal_wheel_id, $type, $price){
        $sql = "UPDATE metal_wheel_premium_service
                SET type = :type,
                    price = :price
                WHERE metal_wheel_id = :metal_wheel_id
                ORDER BY metal_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":metal_wheel_id", $metal_wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update prémiového servisu plechových diskov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateMetalWheelPremiumService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * DELETE ONE METAL WHEEL PREMIUM SERVICE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $metal_wheel_id - metal wheel for premium service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteMetalWheelPremiumService($connection, $metal_wheel_id){
        $sql = "DELETE 
                FROM metal_wheel_premium_service
                WHERE metal_wheel_id = :metal_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":metal_wheel_id", $metal_wheel_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre vymazanie všetkých dát o plechových diskoch prémiový servis sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteMetalWheelPremiumService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}