<?php

require "../classes/Database.php";
require "../classes/User.php";
require "../classes/Url.php";


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

    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    if (User::updateUserPassword($connection, $password, $user_id)) {
        Url::redirectUrl("/autobajo/admin/my-dashboard.php");
    } else {
        $not_updated_password = "Heslo sa nepodarilo zmeniť";
        Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_updated_password");
    } 
} else {
    $not_authorization = "Nepovolený prístup";
    Url::redirectUrl("/autobajo/admin/logedin-error.php?logedin_error=$not_authorization");
}
?>