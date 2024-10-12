<?php

class Car {


    /**
     *
     * ADD PLAYER/USER TO DATABASE
     *
     * @param object $connection - database connection
     * @param string $car_brand - car_brand
     * @param string $car_model - car_model
     * @param string $car_color - car_color
     * @param string $year_of_manufacture - year_of_manufacture
     * @param int $engine_volume - engine_volume
     * @param int $past_km - past kilometers
     * @param int $car_price - car_price
     * @param integer $fuel_type - fuel_type
     * @param string $gearbox - gearbox
     * @param string $car_description - car_description
     * @param string $other_equipment - other_equipment
     * @param string $el_windows - el_windows
     * @param string $el_seats - el_seats
     * @param string $no_key_start - no_key_start
     * @param string $airbag - airbag
     * @param string $tempomat - tempomat
     * @param string $heated_seat - heated_seat
     * @param string $parking_sensor - parking_sensor
     * @param string $isofix - isofix
     * @param string $alu_rimes - alu_rimes
     * @param string $air_condition - air_condition
     * @param string $towing_device - towing_device
     * @param string $alarm - alarm
     * @param boolean $active - active advertisement
     * @param boolean $reserved - reseerved - advertisement
     * @param boolean $sold - sold advertisement
     * @param string $car_image - car_image
     *
     * @return integer $car_id - id for car advertisement
     * 
     */
    public static function createCarAdvertisement($connection, $car_brand, $car_model, $car_color, $year_of_manufacture, $engine_volume, $past_km, $car_price, $fuel_type, $gearbox, $car_description, $other_equipment, $el_windows, $el_seats, $no_key_start, $airbag, $tempomat, $heated_seat, $parking_sensor, $isofix, $alu_rimes, $air_condition, $towing_device, $alarm, $active, $reserved, $sold, $car_image) {


        // sql scheme
        $sql = "INSERT INTO car_advertisement (car_brand, car_model, car_color, year_of_manufacture, engine_volume, past_km, car_price, fuel_type, gearbox, car_description, other_equipment, el_windows, el_seats, no_key_start, airbag, tempomat, heated_seat, parking_sensor, isofix, alu_rimes, air_condition, towing_device, alarm, active, reserved, sold, car_image)
        VALUES ( :car_brand, :car_model, :car_color, :year_of_manufacture, :engine_volume, :past_km, :car_price, :fuel_type, :gearbox, :car_description, :other_equipment, :el_windows, :el_seats, :no_key_start, :airbag, :tempomat, :heated_seat, :parking_sensor, :isofix, :alu_rimes, :air_condition, :towing_device, :alarm, :active, :reserved, :sold, :car_image)";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":car_brand", $car_brand, PDO::PARAM_STR);
        $stmt->bindValue(":car_model", $car_model, PDO::PARAM_STR);
        $stmt->bindValue(":car_color", $car_color, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_manufacture", $year_of_manufacture, PDO::PARAM_INT);
        $stmt->bindValue(":engine_volume", $engine_volume, PDO::PARAM_INT);
        $stmt->bindValue(":past_km", $past_km, PDO::PARAM_INT);
        $stmt->bindValue(":car_price", $car_price, PDO::PARAM_INT);
        $stmt->bindValue(":fuel_type", $fuel_type, PDO::PARAM_STR);
        $stmt->bindValue(":gearbox", $gearbox, PDO::PARAM_STR);
        $stmt->bindValue(":car_description", $car_description, PDO::PARAM_STR);
        $stmt->bindValue(":other_equipment", $other_equipment, PDO::PARAM_STR);
        $stmt->bindValue(":el_windows", $el_windows, PDO::PARAM_BOOL);
        $stmt->bindValue(":el_seats", $el_seats, PDO::PARAM_BOOL);
        $stmt->bindValue(":no_key_start", $no_key_start, PDO::PARAM_BOOL);
        $stmt->bindValue(":airbag", $airbag, PDO::PARAM_BOOL);
        $stmt->bindValue(":tempomat", $tempomat, PDO::PARAM_BOOL);
        $stmt->bindValue(":heated_seat", $heated_seat, PDO::PARAM_BOOL);
        $stmt->bindValue(":parking_sensor", $parking_sensor, PDO::PARAM_BOOL);
        $stmt->bindValue(":isofix", $isofix, PDO::PARAM_BOOL);
        $stmt->bindValue(":alu_rimes", $alu_rimes, PDO::PARAM_BOOL);
        $stmt->bindValue(":air_condition", $air_condition, PDO::PARAM_BOOL);
        $stmt->bindValue(":towing_device", $towing_device, PDO::PARAM_BOOL);
        $stmt->bindValue(":alarm", $alarm, PDO::PARAM_BOOL);
        $stmt->bindValue(":active", $active, PDO::PARAM_BOOL);
        $stmt->bindValue(":reserved", $reserved, PDO::PARAM_BOOL);
        $stmt->bindValue(":sold", $sold, PDO::PARAM_BOOL);
        $stmt->bindValue(":car_image", $car_image, PDO::PARAM_STR);
    

        
        try {
            // execute all data to SQL Database to car_advertisement
            if($stmt->execute()){
                $car_id = $connection->lastInsertId();
                return $car_id;
            } else {
                throw new Exception ("Vytvorenie nového inzerátu automobilu sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createCarAdvertisement\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL CARS ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param bool $status - active or historical advertisement
     * @param int $page_nr - actual page number
     * @param int $show_nr_of_advert - how many advertisement is printed on page/site
     *
     * @return array array of objects, one object mean one car infos
     */
    public static function getAllCarsAdvertisement($connection, $status, $page_nr, $show_nr_of_advert, $columns = "*"){
        $sql = "SELECT $columns
                FROM car_advertisement
                WHERE active = :status
                ORDER BY car_id DESC
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
                throw new Exception ("Príkaz pre získanie všetkých dát o inzerátoch áut sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllCarsAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN ID CAR FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param int car_id - represent one car id
     * @return array all info for one car_id
     */
    public static function getCar($connection, $car_id){
        $sql = "SELECT *
                FROM car_advertisement
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one car
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o inzeráte auta sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getCar, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }


    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CAR ADVERTISEMENT
     *
     * @param object $connection - database connection
     * @param string $active - active advertisement
     * @param string $reserved - reserved advertisement
     * @param int $sold -  sold advertisement
     * @param int $car_id -  spesific car advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateCarStatusAdvertisement($connection, $active, $reserved, $sold, $car_id){

        $sql = "UPDATE car_advertisement
                SET active = :active,
                    reserved = :reserved,
                    sold = :sold
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
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
            error_log("Chyba pri funkcii updateCarStatusAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }



    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CAR INFO ADVERTISEMENT
     *
     * @param object $connection - database connection
     * @param string $car_brand - car_brand
     * @param string $car_model - car_model
     * @param string $car_color - car_color
     * @param string $year_of_manufacture - year_of_manufacture
     * @param int $engine_volume - engine_volume
     * @param int $past_km - past kilometers
     * @param int $car_price - car_price
     * @param integer $fuel_type - fuel_type
     * @param string $gearbox - gearbox
     * @param string $car_description - car_description
     * @param string $other_equipment - other_equipment
     * @param string $el_windows - el_windows
     * @param string $el_seats - el_seats
     * @param string $no_key_start - no_key_start
     * @param string $airbag - airbag
     * @param string $tempomat - tempomat
     * @param string $heated_seat - heated_seat
     * @param string $parking_sensor - parking_sensor
     * @param string $isofix - isofix
     * @param string $alu_rimes - alu_rimes
     * @param string $air_condition - air_condition
     * @param string $towing_device - towing_device
     * @param string $alarm - alarm
     * @param boolean $active - active advertisement
     * @param boolean $reserved - reseerved - advertisement
     * @param boolean $sold - sold advertisement
     * @param string $car_image - car_image
     * @param int $car_id -  spesific car advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateCarInfoAdvertisement($connection, $car_id, $car_brand, $car_model, $car_color, $year_of_manufacture, $engine_volume, $past_km, $fuel_type, $gearbox, $car_price, $car_description, $other_equipment, $el_windows, $el_seats, $no_key_start, $airbag, $tempomat, $heated_seat, $parking_sensor, $isofix, $alu_rimes, $air_condition, $towing_device, $alarm){

        $sql = "UPDATE car_advertisement
                SET car_brand = :car_brand,
                    car_model = :car_model,
                    car_color = :car_color,
                    year_of_manufacture = :year_of_manufacture,
                    engine_volume = :engine_volume,
                    past_km = :past_km,
                    fuel_type = :fuel_type,
                    gearbox = :gearbox,
                    car_price = :car_price,
                    car_description = :car_description,
                    other_equipment = :other_equipment,
                    el_windows = :el_windows,
                    el_seats = :el_seats,
                    no_key_start = :no_key_start,
                    airbag = :airbag,
                    tempomat = :tempomat,
                    heated_seat = :heated_seat,
                    parking_sensor = :parking_sensor,
                    isofix = :isofix,
                    alu_rimes = :alu_rimes,
                    air_condition = :air_condition,
                    towing_device = :towing_device,
                    alarm = :alarm
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
        $stmt->bindValue(":car_brand", $car_brand, PDO::PARAM_STR);
        $stmt->bindValue(":car_model", $car_model, PDO::PARAM_STR);
        $stmt->bindValue(":car_color", $car_color, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_manufacture", $year_of_manufacture, PDO::PARAM_INT);
        $stmt->bindValue(":engine_volume", $engine_volume, PDO::PARAM_INT);
        $stmt->bindValue(":past_km", $past_km, PDO::PARAM_INT);
        $stmt->bindValue(":fuel_type", $fuel_type, PDO::PARAM_STR);
        $stmt->bindValue(":gearbox", $gearbox, PDO::PARAM_STR);
        $stmt->bindValue(":car_price", $car_price, PDO::PARAM_INT);
        $stmt->bindValue(":car_description", $car_description, PDO::PARAM_STR);
        $stmt->bindValue(":other_equipment", $other_equipment, PDO::PARAM_STR);
        $stmt->bindValue(":el_windows", $el_windows, PDO::PARAM_BOOL);
        $stmt->bindValue(":el_seats", $el_seats, PDO::PARAM_BOOL);
        $stmt->bindValue(":no_key_start", $no_key_start, PDO::PARAM_BOOL);
        $stmt->bindValue(":airbag", $airbag, PDO::PARAM_BOOL);
        $stmt->bindValue(":tempomat", $tempomat, PDO::PARAM_BOOL);
        $stmt->bindValue(":heated_seat", $heated_seat, PDO::PARAM_BOOL);
        $stmt->bindValue(":parking_sensor", $parking_sensor, PDO::PARAM_BOOL);
        $stmt->bindValue(":isofix", $isofix, PDO::PARAM_BOOL);
        $stmt->bindValue(":alu_rimes", $alu_rimes, PDO::PARAM_BOOL);
        $stmt->bindValue(":air_condition", $air_condition, PDO::PARAM_BOOL);
        $stmt->bindValue(":towing_device", $towing_device, PDO::PARAM_BOOL);
        $stmt->bindValue(":alarm", $alarm, PDO::PARAM_BOOL);
        
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny informácií inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateCarInfoAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CAR ADVERTISEMENT TITLE IMAGE
     *
     * @param object $connection - database connection
     * @param string $car_image - car advertisement title image
     * @param int $car_id -  spesific car advertisement
     * 
     * @return boolean if update is successful
     */
    public static function updateCarImageAdvertisement($connection, $car_image, $car_id){

        $sql = "UPDATE car_advertisement
                SET car_image = :car_image
                WHERE car_id = :car_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":car_id", $car_id, PDO::PARAM_INT);
        $stmt->bindValue(":car_image", $car_image, PDO::PARAM_STR);
        
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny statusu inzerátu sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateCarImageAdvertisement, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN NUMBER OF CARS ADVERTISEMENT INFO FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return int numebr of all active or deactive advertisement
     */
    public static function countAllCarsAdvertisement($connection, $status, $columns = "*"){
        $sql = "SELECT COUNT($columns)
                FROM car_advertisement
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
            error_log("Chyba pri funckii countAllCarsAdvertisement, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

}