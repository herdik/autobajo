<?php

class User {




    /**
     *
     * RETURN ONE PLAYER FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $player_Id - id for one player
     * @return array asoc array with one player
     */
    public static function getPlayer($connection, $player_Id, $columns = "first_name, second_name, country, player_club, player_club_id, player_Image, player_cue, player_break_cue, player_jump_cue"){
        $sql = "SELECT $columns
                FROM player_user
                WHERE player_Id = :player_Id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":player_Id", $player_Id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one player
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o hráčovi sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getPlayer, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }


    /**
     *
     * RETURN ONE USER FROM DATABASE
     *
     * @param object $connection - connection to database
     * @param integer $player_Id - id for one user
     * @return array asoc array with one user
     */
    public static function getUser($connection, $player_Id){
        $sql = "SELECT  player_Id,
                        user_email,
                        first_name, 
                        second_name, 
                        country, 
                        player_club,
                        player_club_id,
                        player_Image, 
                        player_cue, 
                        player_break_cue, 
                        player_jump_cue
                FROM player_user
                WHERE player_Id = :player_Id";
        

        // connect sql amend to database
        $stmt = $connection->prepare($sql);

        // all parameters to send to Database
        $stmt->bindValue(":player_Id", $player_Id, PDO::PARAM_INT);

        try {
            if($stmt->execute()){
                // asscoc array for one player
                return $stmt->fetch();
            } else {
                throw Exception ("Príkaz pre získanie všetkých dát o užívateľovi sa nepodaril");
            }
        } catch (Exception $e){
            // 3 je že vyberiem vlastnú cestu k súboru
            error_log("Chyba pri funkcii getUser, získanie informácií z databázy zlyhalo\n", 3, "../errors/error.log");
            echo "Výsledná chyba je: " . $e->getMessage();
        }
    }



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


}