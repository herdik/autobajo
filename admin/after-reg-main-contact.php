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
    $email_1 = $_POST["email_1"];
    $tel_1 = $_POST["tel_1"];
    $email_2 = $_POST["email_2"];
    $tel_2 = $_POST["tel_2"];
    

    $create_contact_info = Contact::createContactInfo($connection, $company_name, $street_number, $town_post_nr, $email_1, $tel_1, $email_2, $tel_2);

    
    if ($create_contact_info){
        Url::redirectUrl("/autobajo/admin/admin-about-us.php");
    } else {
        $not_added_contact_info = "Kontaktné údaje sa nepodarilo pridať";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_added_contact_info");
    }
    

} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>