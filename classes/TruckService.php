<?php

class TruckService {


    /**
     *
     * ADD Truck Service NEW TYPE
     *
     * @param object $connection - database connection
     

     * @return boolean true or false
     * 
     */
    public static function createTruckService($connection) {


        // sql scheme
        $sql = "INSERT INTO truck_service ()
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
                throw new Exception ("Vytvorenie nového nákladného servisu sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createTruckService\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL Truck Service  INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one truck service type
     */
    public static function getAllTruckService($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM truck_service
                ORDER BY truck_service_id";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o service nákladných áut sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllTruckService, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TRUCK SERVICE
     *
     * @param object $connection - database connection
     * @param string $type - type of metal wheel
     * @param string $price - price for one metal wheel
     * @param int $truck_service_id -  truck_service_id for one truck wheel
     * 
     * @return boolean if update is successful
     */
    public static function updateTruckService($connection, $truck_service_id, $service_type, $price){
        $sql = "UPDATE truck_service
                SET service_type = :service_type,
                    price = :price
                WHERE truck_service_id = :truck_service_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":truck_service_id", $truck_service_id, PDO::PARAM_INT);
        $stmt->bindValue(":service_type", $service_type, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update nákladného servisu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTruckService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * DELETE ONE METAL WHEEL BASIC SERVICE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $truck_service_id - truck wheel for truck service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteTruckService($connection, $truck_service_id){
        $sql = "DELETE 
                FROM truck_service
                WHERE truck_service_id = :truck_service_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":truck_service_id", $truck_service_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre vymazanie všetkých dát o diskoch nákládného servis sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteTruckService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}