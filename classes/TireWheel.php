<?php

class TireWheel {


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
     * @param float $tire_width - tire_width
     * @param float $height - height tire
     * @param string $construction - construction tire
     * @param integer $average - average of tire
     * @param integer $weight_index - weight_index
     * @param string $speed_index - speed_index
     * 
     * @param string $wheel_category - wheel_category
     * @param string $wheel_brand - wheel_brand
     * @param string $wheel_model - wheel_model
     * @param string wheel_average - wheel_average
     * @param integer spacing - spacing of wheel
     * @param float $wheel_width - width wheel
     * @param float $et - et wheel
     * @param string $wheel_color - color of wheel
     * 
     * @param integer $price - price
     * @param string $description - description
     * @param boolean $active - active advertisement
     * @param boolean $reserved - reseerved - advertisement
     * @param boolean $sold - sold advertisement
     * @param string $tire_wheel_image - tire_wheel_image
    
     * @return integer $tire_wheel_id - id for tire advertisement
     * 
     */
    
    public static function createTireWheelAdvertisement($connection, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $tire_width, $height, $construction, $average, $weight_index, $speed_index, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $wheel_width, $et, $wheel_color, $price, $description, $active, $reserved, $sold, $tire_wheel_image) {


        // sql scheme
        $sql = "INSERT INTO tire_wheel_advertisement (tire_category, tire_brand, tire_model, type, year_of_manufacture, tire_width, height, construction, average, weight_index, speed_index, wheel_category, wheel_brand, wheel_model, wheel_average, spacing, wheel_width, et, wheel_color, price, description, active, reserved, sold, tire_wheel_image)
        VALUES (:tire_category, :tire_brand, :tire_model, :type, :year_of_manufacture, :tire_width, :height, :construction, :average, :weight_index, :speed_index, :wheel_category, :wheel_brand, :wheel_model, :wheel_average, :spacing, :wheel_width, :et, :wheel_color, :price, :description, :active, :reserved, :sold, :tire_wheel_image)";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_category", $tire_category, PDO::PARAM_STR);
        $stmt->bindValue(":tire_brand", $tire_brand, PDO::PARAM_STR);
        $stmt->bindValue(":tire_model", $tire_model, PDO::PARAM_STR);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_manufacture", $year_of_manufacture, PDO::PARAM_INT);
        $stmt->bindValue(":tire_width", $tire_width, PDO::PARAM_STR);
        $stmt->bindValue(":height", $height, PDO::PARAM_STR);
        $stmt->bindValue(":construction", $construction, PDO::PARAM_STR);
        $stmt->bindValue(":average", $average, PDO::PARAM_INT);
        $stmt->bindValue(":weight_index", $weight_index, PDO::PARAM_INT);
        $stmt->bindValue(":speed_index", $speed_index, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_category", $wheel_category, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_brand", $wheel_brand, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_model", $wheel_model, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_average", $wheel_average, PDO::PARAM_INT);
        $stmt->bindValue(":spacing", $spacing, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_width", $wheel_width, PDO::PARAM_STR);
        $stmt->bindValue(":et", $et, PDO::PARAM_INT);
        $stmt->bindValue(":wheel_color", $wheel_color, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_INT);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":active", $active, PDO::PARAM_BOOL);
        $stmt->bindValue(":reserved", $reserved, PDO::PARAM_BOOL);
        $stmt->bindValue(":sold", $sold, PDO::PARAM_BOOL);
        $stmt->bindValue(":tire_wheel_image", $tire_wheel_image, PDO::PARAM_STR);
        
        try {
            // execute all data to SQL Database to tire_wheel_advertisement
            if($stmt->execute()){
                $tire_wheel_id = $connection->lastInsertId();
                return $tire_wheel_id;
            } else {
                throw new Exception ("Vytvorenie nového inzerátu pneumatiky sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createTireWheelAdvertisement\n", 3, "../errors/error.log");
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
    public static function getAllTireWheelsAdvertisement($connection, $status, $page_nr, $show_nr_of_advert, $columns = "*"){
        $sql = "SELECT $columns
                FROM tire_wheel_advertisement
                WHERE active = :status
                ORDER BY tire_wheel_id DESC
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
            error_log("Chyba pri funckii getAllTireWheelsAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
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
    public static function getAllTireWheelsInfo($connection, $column, $required_word){
        $sql = "SELECT DISTINCT $column
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
            error_log("Chyba pri funckii getAllTireWheelsInfo, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN ID TIRE FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int tire_wheel_id - represent one tire_wheel_id
     * @return array all info for one tire_wheel_id
     */
    public static function getTireWheel($connection, $tire_wheel_id){
        $sql = "SELECT *
                FROM tire_wheel_advertisement
                WHERE tire_wheel_id = :tire_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one tire
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o inzeráte pneumatiky sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getTireWheel, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
     * @param int $tire_wheel_id -  spesific tire advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateTireWheelStatusAdvertisement($connection, $active, $reserved, $sold, $tire_wheel_id){

        $sql = "UPDATE tire_wheel_advertisement
                SET active = :active,
                    reserved = :reserved,
                    sold = :sold
                WHERE tire_wheel_id = :tire_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);
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
            error_log("Chyba pri funkcii updateTireWheelStatusAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
     * @param float $tire_width - tire_width
     * @param float $height - height tire
     * @param string $construction - construction tire
     * @param integer $average - average of tire
     * @param integer $weight_index - weight_index
     * @param string $speed_index - speed_index
     * 
     * @param string $wheel_category - wheel_category
     * @param string $wheel_brand - wheel_brand
     * @param string $wheel_model - wheel_model
     * @param string wheel_average - wheel_average
     * @param integer spacing - spacing of wheel
     * @param float $wheel_width - width wheel
     * @param float $et - et wheel
     * @param string $wheel_color - color of wheel
     * 
     * @param integer $price - price
     * @param string $description - description
     * @return boolean if update is successful
     */
    public static function updateTireWheelInfoAdvertisement($connection, $tire_wheel_id, $tire_category, $tire_brand, $tire_model, $type, $year_of_manufacture, $tire_width, $height, $construction, $average, $weight_index, $speed_index, $wheel_category, $wheel_brand, $wheel_model, $wheel_average, $spacing, $wheel_width, $et, $wheel_color, $price, $description){

        $sql = "UPDATE tire_wheel_advertisement
                SET tire_category = :tire_category, 
                    tire_brand = :tire_brand, 
                    tire_model = :tire_model, 
                    type = :type, 
                    year_of_manufacture = :year_of_manufacture, 
                    tire_width = :tire_width, 
                    height = :height, 
                    construction = :construction, 
                    average = :average, 
                    weight_index = :weight_index, 
                    speed_index = :speed_index,
                    wheel_category = :wheel_category, 
                    wheel_brand = :wheel_brand, 
                    wheel_model = :wheel_model, 
                    wheel_average = :wheel_average, 
                    spacing = :spacing, 
                    wheel_width = :wheel_width, 
                    et = :et, 
                    wheel_color = :wheel_color, 
                    price = :price, 
                    description = :description
                WHERE tire_wheel_id = :tire_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":tire_category", $tire_category, PDO::PARAM_STR);
        $stmt->bindValue(":tire_brand", $tire_brand, PDO::PARAM_STR);
        $stmt->bindValue(":tire_model", $tire_model, PDO::PARAM_STR);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_manufacture", $year_of_manufacture, PDO::PARAM_INT);
        $stmt->bindValue(":tire_width", $tire_width, PDO::PARAM_STR);
        $stmt->bindValue(":height", $height, PDO::PARAM_STR);
        $stmt->bindValue(":construction", $construction, PDO::PARAM_STR);
        $stmt->bindValue(":average", $average, PDO::PARAM_INT);
        $stmt->bindValue(":weight_index", $weight_index, PDO::PARAM_INT);
        $stmt->bindValue(":speed_index", $speed_index, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_category", $wheel_category, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_brand", $wheel_brand, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_model", $wheel_model, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_average", $wheel_average, PDO::PARAM_INT);
        $stmt->bindValue(":spacing", $spacing, PDO::PARAM_STR);
        $stmt->bindValue(":wheel_width", $wheel_width, PDO::PARAM_STR);
        $stmt->bindValue(":et", $et, PDO::PARAM_INT);
        $stmt->bindValue(":wheel_color", $wheel_color, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_INT);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny informácií inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireWheelInfoAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

     /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED TIRE ADVERTISEMENT TITLE IMAGE
     *
     * @param object $connection - database connection
     * @param string $tire_wheel_image - tire advertisement title image
     * @param int $tire_wheel_id -  spesific tire advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateTireWheelImageAdvertisement($connection, $tire_wheel_image, $tire_wheel_id){

        $sql = "UPDATE tire_wheel_advertisement
                SET tire_wheel_image = :tire_wheel_image
                WHERE tire_wheel_id = :tire_wheel_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);
        $stmt->bindValue(":tire_wheel_image", $tire_wheel_image, PDO::PARAM_STR);
        
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny statusu inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateTireWheelImageAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
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
    public static function countAllTireWheelsAdvertisement($connection, $status, $columns = "*"){
        $sql = "SELECT COUNT($columns)
                FROM tire_wheel_advertisement
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
            error_log("Chyba pri funckii countAllTireWheelsAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    
    /**
     * DELETE ALL IMAGES FROM FOLDER SPECIFIC FOR ADVERTISEMENT
     * DELETE ALL IMAGES FROM GALLERY AND FROM DATABASE SPECIFIC FOR ADVERTISEMENT 
     * DELETE SELECTED TireWheel ADVERTISEMENT FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $tire_wheel_id - truck wheel for truck service
     * 
     * @return boolean if delete is successful
     */
    public static function deleteTireWheelAdvertImgsDirImgs($connection, $tire_wheel_id, $dirname){

        $sql_1 = "DELETE 
                FROM tire_wheel_image
                WHERE tire_wheel_id = :tire_wheel_id";
        
    
        $sql_2 = "DELETE 
                FROM tire_wheel_advertisement
                WHERE tire_wheel_id = :tire_wheel_id";

        

        // connect sql amend to database
        $stmt_1 = $connection->prepare($sql_1);

        // connect sql amend to database
        $stmt_2 = $connection->prepare($sql_2);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt_1->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);
        $stmt_2->bindValue(":tire_wheel_id", $tire_wheel_id, PDO::PARAM_INT);

        

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
                    throw new Exception ("Príkaz pre vymazanie všetkých dát o inzeráte pneumatík na diskoch sa nepodaril");
                }
            } else {
                throw new Exception ("Príkaz pre vymazanie všetkých dát o vybraných obrázkoch z galérie sa nepodaril");
            }
            
        } catch (Exception $e){
            // something wrong rollback
            $connection->rollback();
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii deleteTireWheelAdvertImgsDirImgs, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        
        }
                 
    }

}