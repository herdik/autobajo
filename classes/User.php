<?php

class User {


    /**
     *
     * RETURN ID USER FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param string $user_email - $user_email from form for one user
     * @return int ID for one user
     */
    public static function getUserId($connection, $user_email){
        $sql = "SELECT  user_id
                FROM user
                WHERE user_email = :user_email";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":user_email", $user_email, PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                // asscoc array for one player and we want to get player_Id
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých ID o užívateľovi sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getUserId, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * Authentication for ONE USER FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param string $user_email - $user_email from form for one user
     * @param string $password - $password from form to signIn
     * @return array asoc array with one user
     */
    public static function authentication($connection, $log_user_email, $log_password){
        $sql = "SELECT password
                FROM user
                WHERE user_email = :user_email";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":user_email", $log_user_email, PDO::PARAM_STR);
        

        try {
            if($stmt->execute()){
                if ($user = $stmt->fetch()){
                    return password_verify($log_password, $user["password"]);
                }
            } else {
                throw Exception ("Overenie hesla pre užívateľa sa nepodarilo");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii authentication, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ONE USER FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $user_id - $user_id who is logged in
     * @return array asoc array with one user
     */
    public static function getUserRole($connection, $user_id){
        $sql = "SELECT role
                FROM user
                WHERE user_id = :user_id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one player
                return $stmt->fetch()["role"];
            } else {
                throw Exception ("Príkaz pre získanie role o užívateľovi sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getUserRole, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


}