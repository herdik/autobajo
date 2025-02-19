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
     * @param boolean $active - active advertisement
     * @param boolean $reserved - reseerved - advertisement
     * @param boolean $sold - sold advertisement
     * @param string $tire_image - tire_image
    
     * @return integer $tire_id - id for tire advertisement
     * 
     */
    
    public static function createTireAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description, $active, $reserved, $sold, $tire_image) {


        // sql scheme
        $sql = "INSERT INTO tire_advertisement (tire_category, tire_brand, tire_model, type, year_of_manufacture, width, height, construction, average, weight_index, speed_index, tire_price, tire_description, active, reserved, sold, tire_image)
        VALUES (:tire_category, :tire_brand, :tire_model, :type, :year_of_manufacture, :width, :height, :construction, :average, :weight_index, :speed_index, :tire_price, :tire_description, :active, :reserved, :sold, :tire_image)";

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
        $stmt->bindValue(":active", $active, PDO::PARAM_BOOL);
        $stmt->bindValue(":reserved", $reserved, PDO::PARAM_BOOL);
        $stmt->bindValue(":sold", $sold, PDO::PARAM_BOOL);
        $stmt->bindValue(":tire_image", $tire_image, PDO::PARAM_STR);
        
        try {
            // execute all data to SQL Database to tire_advertisement
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
     * @param bool $status - active or historical advertisement
     * @param int $page_nr - actual page number
     * @param int $show_nr_of_advert - how many advertisement is printed on page/site
     *
     * @return array array of objects, one object mean one tire infos
     */
    public static function getAllTiresAdvertisement($connection, $status, $page_nr, $show_nr_of_advert, $columns = "*"){
        $sql = "SELECT $columns
                FROM tire_advertisement
                WHERE active = :status
                ORDER BY tire_id DESC
                LIMIT :page_nr, :show_nr_of_advert";

        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":page_nr", $page_nr, PDO::PARAM_INT);
        $stmt->bindValue(":show_nr_of_advert", $show_nr_of_advert, PDO::PARAM_INT);

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
     * RETURN ALL TIRES ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param bool $status - active or historical advertisement
     * @param int $page_nr - actual page number
     * @param int $show_nr_of_advert - how many advertisement is printed on page/site
     *
     * @return array array of objects, one object mean one tire infos
     */
    public static function getAllTiresInfo($connection, $column, $required_word){
        $sql = "SELECT DISTINCT $column
                FROM tire_advertisement
                WHERE tire_brand LIKE :required_word
                UNION
                SELECT $column
                FROM tire_wheel_advertisement
                WHERE tire_brand LIKE :required_word
                ORDER BY $column ASC";

        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":required_word", $required_word, PDO::PARAM_STR);
        

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_COLUMN);
            } else {
                throw new Exception ("Príkaz pre získanie špecifických dát o inzerátoch pneumatík sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllTiresInfo, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN ID TIRE FROM DATABASE
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
                // asscoc array for one tire
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

    
    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TIRE ADVERTISEMENT
     *
     * @param object $connection - database connection
     * @param string $active - active advertisement
     * @param string $reserved - reserved advertisement
     * @param int $sold -  sold advertisement
     * @param int $tire_id -  spesific tire advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateTireStatusAdvertisement($connection, $active, $reserved, $sold, $tire_id){

        $sql = "UPDATE tire_advertisement
                SET active = :active,
                    reserved = :reserved,
                    sold = :sold
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt->bindValue(":active", $active, PDO::PARAM_STR);
        $stmt->bindValue(":reserved", $reserved, PDO::PARAM_STR);
        $stmt->bindValue(":sold", $sold, PDO::PARAM_STR);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny statusu inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireStatusAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED INFO TIRE ADVERTISEMENT
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
     * @param int $tire_id -  spesific tire advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateTireInfoAdvertisement($connection, $tire_id, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $width, $height, $construction, $average, $weight_index, $speed_index, $tire_price, $tire_description){

        $sql = "UPDATE tire_advertisement
                SET tire_category = :tire_category, 
                    tire_brand = :tire_brand, 
                    tire_model = :tire_model, 
                    type = :type, 
                    year_of_manufacture = :year_of_manufacture, 
                    width = :width, 
                    height = :height, 
                    construction = :construction, 
                    average = :average, 
                    weight_index = :weight_index, 
                    speed_index = :speed_index, 
                    tire_price = :tire_price, 
                    tire_description = :tire_description
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
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
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny informácií inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireInfoAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

     /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TIRE ADVERTISEMENT TITLE IMAGE
     *
     * @param object $connection - database connection
     * @param string $tire_image - tire advertisement title image
     * @param int $tire_id -  spesific tire advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateTireImageAdvertisement($connection, $tire_image, $tire_id){

        $sql = "UPDATE tire_advertisement
                SET tire_image = :tire_image
                WHERE tire_id = :tire_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt->bindValue(":tire_image", $tire_image, PDO::PARAM_STR);
        
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny statusu inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireImageAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN NUMBER OF TIRES ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return int numebr of all active or deactive advertisement
     */
    public static function countAllTiresAdvertisement($connection, $status, $columns = "*"){
        $sql = "SELECT COUNT($columns)
                FROM tire_advertisement
                WHERE active = $status";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchColumn();
            } else {
                throw new Exception ("Príkaz pre získanie počtu inzerátov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii countAllTiresAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    
    /**
     * DELETE ALL IMAGES FROM FOLDER SPECIFIC FOR ADVERTISEMENT
     * DELETE ALL IMAGES FROM GALLERY AND FROM DATABASE SPECIFIC FOR ADVERTISEMENT 
     * DELETE SELECTED TIRE ADVERTISEMENT FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $tire_id - truck wheel for truck service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteTireAdvertImgsDirImgs($connection, $tire_id, $dirname){

        $sql_1 = "DELETE 
                FROM tire_image
                WHERE tire_id = :tire_id";
        
    
        $sql_2 = "DELETE 
                FROM tire_advertisement
                WHERE tire_id = :tire_id";

        

        // connect sql amend to database
        $stmt_1 = $connection->prepare($sql_1);

        // connect sql amend to database
        $stmt_2 = $connection->prepare($sql_2);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt_1->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);
        $stmt_2->bindValue(":tire_id", $tire_id, PDO::PARAM_INT);

        

        $connection->beginTransaction();

        try {

            $stmt_1->execute();
            // check if was deleted minimum 1 row
            if($stmt_1->rowCount()) {
                $stmt_2->execute();
                if($stmt_2->rowCount()){
                    // check Folder is exists
                    if(is_dir($dirname)){
                        array_map('unlink', glob("$dirname/*.*"));
                        rmdir($dirname); 
                    }  
                    // everything is done commit
                    $connection->commit();
                    return true;   
                } else {
                    throw new Exception ("Príkaz pre vymazanie všetkých dát o inzeráte apneumatike sa nepodaril");
                }
            } else {
                throw new Exception ("Príkaz pre vymazanie všetkých dát o vybraných obrázkoch z galérie sa nepodaril");
            }
            
        } catch (Exception $e){
            // something wrong rollback
            $connection->rollback();
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteTireAdvertImgsDirImgs, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        
        }
                 
    }

}