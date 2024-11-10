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
     *
     * 
     * @return boolean true or false
     * 
     */
    public static function insertTireImage($connection, $tire_id, $image_name, $priority){
        $sql = "INSERT INTO tire_image (tire_id, image_name, priority)
                VALUES (:tire_id, :image_name, :priority)";
       
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        $stmt->bindValue(":priority", $priority, PDO::PARAM_INT);


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


    /**
     *
     * RETURN ALL TIRES IMAGES INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param object $tire_id - tire_id
     *
     * @return array array of objects, one object mean one tire foto
     */
    public static function getAllTiresImages($connection, $tire_id, $columns = "*"){
        $sql = "SELECT $columns
                FROM tire_image
                WHERE tire_id = :tire_id
                ORDER BY priority, image_id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o fotkách pneumatík sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllTiresImages, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }
    

    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TIRE IMAGE
     *
     * @param object $connection - database connection
     * @param int $tire_id - specifically id for specifically tire advertisement
     * @param string $image_name - image_name for specifically tire advertisement
     *
     * 
     * @return boolean true or false
     */
    public static function updateTireImage($connection, $tire_id, $image_name){

        $sql = "UPDATE tire_image
                SET image_name = :image_name
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $image_name, PDO::PARAM_STR);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update obrázku pneumatiky inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


     /**
     *
     * RETURN TIRE IMAGE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int image_id - represent one image_id
     * @return array all info for one image
     */
    public static function getTireImage($connection, $image_id){
        $sql = "SELECT *
                FROM tire_image
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one tire
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o obrázku pneumatiky sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getTireImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }

    /**
     *
     * RETURN TIRE IMAGE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int image_id - represent one image_id
     * @return array all info for one image
     */
    public static function getMaxPriorityNumber($connection, $tire_id){
        $sql = "SELECT MAX(priority) 
                FROM tire_image
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one tire
                return $stmt->fetch(PDO::FETCH_COLUMN);
            } else {
                throw Exception ("Príkaz pre získanie najvyšieho priority čísla podľa tire id obrázku auta sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getTireImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
    public static function deleteTireImageFromDirectory($path){
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
            error_log("Chyba pri funkcii deleteTireImageFromDirectory, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
    public static function deleteTireImage($connection, $image_id){
        $sql = "DELETE 
                FROM tire_image
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
            error_log("Chyba pri funkcii deleteTireImage, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TIRE IMAGE
     *
     * @param object $connection - database connection
     * @param int $image_id - specifically id for specifically tire advertisement
     * @param string $priority - priority for specifically tire advertisement
     *
     * 
     * @return boolean true or false
     */
    public static function updateTireImagePriority($connection, $image_id, $priority){

        $sql = "UPDATE tire_image
                SET priority = :priority
                WHERE image_id = :image_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":image_id", $image_id, PDO::PARAM_INT);
        $stmt->bindValue(":priority", $priority, PDO::PARAM_INT);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update obrázku auta inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireImagePriority, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}