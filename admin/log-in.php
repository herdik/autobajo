<?php

require "../classes/Database.php";
require "../classes/User.php";
require "../classes/Url.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    // database connection
    $database = new Database();
    $connection = $database->connectionDB();


    $log_user_email = $_POST["user_email"];
    $log_password = $_POST["password"];

    
    // login is successful
    if (User::authentication($connection, $log_user_email, $log_password)){

        // user ID for user/admin who is logged in
        $id = User::getUserId($connection, $log_user_email)["user_id"];

        // prevents 'Fixation attack'
        session_regenerate_id(true);

        // Set session for user who is logged in
        $_SESSION["is_logged_in"] = true;
        
        // set session for user ID
        $_SESSION["logged_in_user_id"] = $id;

        // Nastavenie role uživatela
        $_SESSION["role"] = "admin";

        Url::redirectUrl("/autobajo/admin/my-dashboard.php");
     
    } else {
        $error = "Neúspešné prihlásenie !";
    }

}

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fail-login.css">
    <title>Neúspešné prihlásenie</title>
</head>
<body>
    <main>

        <?php if(!empty($error)): ?>
            <h1><?= $error ?></h1>
            <a href="../signin.php">Späť na prihlásenie</a>
        <?php endif; ?>


    </main>
    
</body>
</html>