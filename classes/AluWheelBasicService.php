<?php

class AluWheelBasicService {

     /**
     *
     * ADD ALU WHEEL NEW TYPE
     *
     * @param object $connection - database connection
     

     * @return boolean true or false
     * 
     */
    public static function createAluWheelBasicService($connection) {


        // sql scheme
        $sql = "INSERT INTO alu_wheel_basic_service ()
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
                throw new Exception ("Vytvorenie nového alu základného servisu sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createAluWheelBasicService\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL ALU WHEELS BASIC SERVICE  INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one alu wheel type
     */
    public static function getAllAluWheelBasicService($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM alu_wheel_basic_service
                ORDER BY alu_wheel_id";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o hliníkových diskoch základný servis sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllAluWheelBasicService, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED ALU WHEEL BASIC SERVICE
     *
     * @param object $connection - database connection
     * @param string $type - type of alu wheel
     * @param string $price - price for one alu wheel
     * @param int $alu_wheel_id -  alu_wheel_id
     * 
     * @return boolean if update is successful
     */
    public static function updateAluWheelBasicService($connection, $alu_wheel_id, $type, $price){
        $sql = "UPDATE alu_wheel_basic_service
                SET type = :type,
                    price = :price
                WHERE alu_wheel_id = :alu_wheel_id
                ORDER BY alu_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":alu_wheel_id", $alu_wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update základného servisu hliníkových diskov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateAluWheelBasicService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * DELETE ONE ALU WHEEL BASIC SERVICE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $alu_wheel_id - alu wheel for basic service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteAluWheelBasicService($connection, $alu_wheel_id){
        $sql = "DELETE 
                FROM alu_wheel_basic_service
                WHERE alu_wheel_id = :alu_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":alu_wheel_id", $alu_wheel_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre vymazanie všetkých dát o hlinníkových diskoch základný servis sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteAluWheelBasicService, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}