<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/Contact.php";

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    // database connection
    $database = new Database();
    $connection = $database->connectionDB();

    // value from registration form for car advertisement
    $company_name = $_POST["company_name"];
    $street_number = $_POST["street_number"];
    $town_post_nr = $_POST["town_post_nr"];
    $name_1 = $_POST["name_1"];
    $email_1 = $_POST["email_1"];
    $tel_1 = $_POST["tel_1"];
    $name_2 = $_POST["name_2"];
    $email_2 = $_POST["email_2"];
    $tel_2 = $_POST["tel_2"];
    $mon_fri_morning_open = $_POST["mon_fri_morning_open"];
    $mon_fri_morning_close = $_POST["mon_fri_morning_close"];
    $mon_fri_afternoon_open = $_POST["mon_fri_afternoon_open"];
    $mon_fri_afternoon_close = $_POST["mon_fri_afternoon_close"];
    $saturday_open = $_POST["saturday_open"];
    $saturday_close = $_POST["saturday_close"];
    $sunday = $_POST["sunday"];
    
    
    $update_contact_info = Contact::updateContactInfo($connection, $company_name, $street_number, $town_post_nr, $name_1, $email_1, $tel_1, $name_2, $email_2, $tel_2, $mon_fri_morning_open, $mon_fri_morning_close, $mon_fri_afternoon_open, $mon_fri_afternoon_close, $saturday_open, $saturday_close, $sunday);

    
    if ($update_contact_info){
        header('content-type: application/json');
        echo json_encode($update_contact_info);
    } else {
        $not_added_contact_info = "Kontaktné údaje sa nepodarilo pridať";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_contact_info");
    }
    

} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>