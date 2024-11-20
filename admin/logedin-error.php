<?php

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

if (isset($_GET["logedin_error"]) && is_string($_GET["logedin_error"])){
    $error_message = $_GET["logedin_error"];
} 

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error message</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/error-message.css">

</head>
<body>

    <main>

        <h1><?= htmlspecialchars($error_message) ?></h1>
        
    </main>

</body>
</html>