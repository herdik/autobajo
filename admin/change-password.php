<?php 


    require "../classes/Database.php";
    require "../classes/User.php";

    // verifying by session if visitor have access to this website
    require "../classes/Authorization.php";
    // get session
    session_start();
    // authorization for visitor - if has access to website 
    if (!Auth::isLoggedIn()){
        die ("nepovolený prístup");
    }

    // connection to Database
    $database = new Database();
    $connection = $database->connectionDB();

?>



<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editácia hráča</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/change-password.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/password-query.css">

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration-form">
            <h1>Zmena hesla</h1>
            <form action="after-change-password.php" method="POST">
            
            <?php if ($_SESSION["role"] === "admin"): ?>
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION["logged_in_user_id"]) ?>">
            <?php endif; ?>
                <input type="password" name="password" id="password-user" placeholder="Nové heslo"><br>
                <input type="password" name="password_confirmed" id="password-confirmed" placeholder="Nové heslo"><br>
                <p id="password-status">Heslá sa nezhodujú</p>
                <input class="btn" type="submit" name="submit" value="Potvrdiť" enable>
  
            </form>

        </section>
        
        
    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>
    <script src="../js/password-checker.js"></script>
    <script src="../js/loading.js"></script>  
</body>
</html>