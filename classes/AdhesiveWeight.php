<?php

class AdhesiveWeight {


    /**
     *
     * ADD ADHESIVE WEIGHT NEW TYPE
     *
     * @param object $connection - database connection
     

     * @return boolean true or false
     * 
     */
    public static function createAdhesiveWeight($connection) {


        // sql scheme
        $sql = "INSERT INTO adhesive_weight ()
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
                throw new Exception ("Vytvorenie nového lepiaceho závažia sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createAdhesiveWeight\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL ADHESIVE WEIGHT  INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one weight for wheel
     */
    public static function getAllAdhesiveWeight($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM adhesive_weight
                ORDER BY adhesive_weight_id";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o lepiacich závažiach sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllAdhesiveWeight, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED ADHESIVE WEIGHT
     *
     * @param object $connection - database connection
     * @param string $type - type of metal wheel
     * @param string $price - price for one metal wheel
     * @param int $adhesive_weight_id -  truck_service_id for one truck wheel
     * 
     * @return boolean if update is successful
     */
    public static function updateAdhesiveWeight($connection, $adhesive_weight_id, $type, $price){
        $sql = "UPDATE adhesive_weight
                SET type = :type,
                    price = :price
                WHERE adhesive_weight_id = :adhesive_weight_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":adhesive_weight_id", $adhesive_weight_id, PDO::PARAM_INT);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update lepiaceho závažia sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateAdhesiveWeight, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * DELETE ADHESIVE WEIGHT FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $adhesive_weight_id - truck wheel for truck service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteAdhesiveWeight($connection, $adhesive_weight_id){
        $sql = "DELETE 
                FROM adhesive_weight
                WHERE adhesive_weight_id = :adhesive_weight_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":adhesive_weight_id", $adhesive_weight_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre vymazanie všetkých dát lepiacom záaží sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteAdhesiveWeight, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}