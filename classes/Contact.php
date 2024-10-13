<?php

class Contact {


    /**
     *
     * ADD PLAYER/USER TO DATABASE
     *
     * @param object $connection - database connection
     * @param string $company_name - company_name
     * @param string $street_number - name of street and house number
     * @param string $town_post_nr - name of town and postal code
     * @param string $email_1 - email 1
     * @param string $tel_1 - telephone number 1
     * @param string $email_2 - email 2
     * @param string $tel_2 - telephone number 2
     
     *
     * @return boolean true or false
     * 
     */
    public static function createContactInfo($connection, $company_name, $street_number, $town_post_nr, $email_1, $tel_1, $email_2, $tel_2) {


        // sql scheme
        $sql = "INSERT INTO contact_info (company_name, street_number, town_post_nr, email_1, tel_1, email_2, tel_2)
        VALUES (:company_name, :street_number, :town_post_nr, :email_1, :tel_1, :email_2, :tel_2)";

        // prepare data to send to Database
        $stmt = $connection->prepare($sql);

        // filling and bind values will be execute to Database
        $stmt->bindValue(":company_name", $company_name, PDO::PARAM_STR);
        $stmt->bindValue(":street_number", $street_number, PDO::PARAM_STR);
        $stmt->bindValue(":town_post_nr", $town_post_nr, PDO::PARAM_STR);
        $stmt->bindValue(":email_1", $email_1, PDO::PARAM_STR);
        $stmt->bindValue(":tel_1", $tel_1, PDO::PARAM_STR);
        $stmt->bindValue(":email_2", $email_2, PDO::PARAM_STR);
        $stmt->bindValue(":tel_2", $tel_2, PDO::PARAM_STR);
        

        
        try {
            // execute all data to SQL Database to car_advertisement
            if($stmt->execute()){
                return true;
            } else {
                throw new Exception ("Vytvorenie nového kontaktu sa neuskutočnilo");
            }
        } catch (Exception $e) {
            error_log("Chyba pri funkcii createContactInfo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ALL CONTACT INFOS FROM DATABASE
     *
     * @param object $connection - connection to database
     *
     * @return array array of objects, one object mean one contact infos
     */
    public static function getAllContactInfos($connection, $columns = "*"){
        $sql = "SELECT $columns
                FROM contact_info";

        $stmt = $connection->prepare($sql);

        try {
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception ("Príkaz pre získanie všetkých dát o kontaktných informáciách sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funckii getAllContactInfos, príkaz pre získanie informácií z databázy zlyhal\n", 3, "./errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }

    /**
     *
     * RETURN BOOLEAN FROM DATABASE AFTER UPDATED CONTACT INFO
     *
     * @param object $connection - database connection
     * @param string $company_name - company_name
     * @param string $street_number - name of street and house number
     * @param string $town_post_nr - name of town and postal code
     * @param string $email_1 - email 1
     * @param string $tel_1 - telephone number 1
     * @param string $email_2 - email 2
     * @param string $tel_2 - telephone number 2
     * 
     * @return boolean if update is successful
     */
    public static function updateContactInfo($connection, $company_name, $street_number, $town_post_nr, $email_1, $tel_1, $email_2, $tel_2){

        $sql = "UPDATE contact_info
                SET company_name = :company_name,
                    street_number = :street_number,
                    town_post_nr = :town_post_nr, 
                    email_1 = :email_1, 
                    tel_1 = :tel_1, 
                    email_2 = :email_2, 
                    tel_2 = :tel_2";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        // filling and bind values will be execute to Database
        $stmt->bindValue(":company_name", $company_name, PDO::PARAM_STR);
        $stmt->bindValue(":street_number", $street_number, PDO::PARAM_STR);
        $stmt->bindValue(":town_post_nr", $town_post_nr, PDO::PARAM_STR);
        $stmt->bindValue(":email_1", $email_1, PDO::PARAM_STR);
        $stmt->bindValue(":tel_1", $tel_1, PDO::PARAM_STR);
        $stmt->bindValue(":email_2", $email_2, PDO::PARAM_STR);
        $stmt->bindValue(":tel_2", $tel_2, PDO::PARAM_STR);
        
        
        
        try {
            if($stmt->execute()){
                return true;
            } else {
                throw Exception ("Príkaz pre update zmeny kontaktných údajov sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii updateContactInfo, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


}