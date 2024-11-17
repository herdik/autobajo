<?php

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavný panel - administrácia</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- ICONS MENU -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <!-- ICONS MENU -->

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/dashboard-query.css">

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Hlavný panel</h1>
        <section class="dashboard-menu">

            
            <a class="menu-part" href="./advertisement.php
            ">
            <article class="div-menu-part part-advertisement">
                <img class="div-menu-images" src="../img/advertisement.jpg" alt="">
                <span class="cars advert-text longword">Nový inzerát</span>
            </article>
            </a>
            <a class="menu-part" href="./car-advertisement.php
            ">
            <article class="div-menu-part part-cars">
                <img class="div-menu-images" src="../img/cars.jpg" alt="">
                <span class="cars advert-text">Autá</span>
            </article>
            </a>

            <a class="menu-part" href="./tire-advertisement.php
            ">
            <article class="div-menu-part part-tires">
                <img class="div-menu-images" src="../img/tires.jpg" alt="">
                <span class="tires advert-text">Pneumatiky</span>
            </article>
            </a>

            <a class="menu-part" href="./wheel-advertisement.php
            ">
            <article class="div-menu-part part-rimes">
                <img class="div-menu-images" src="../img/rim.jpg" alt="">
                <span class="rimes advert-text">Disky</span>
            </article>
            </a>

            <a class="menu-part" href="./tires-service.php
            ">
            <article class="div-menu-part part-servis">
                <img class="div-menu-images" src="../img/servis.jpg" alt="">
                <span class="servis advert-text">Pneuservis</span>
            </article>
            </a>

            <a class="menu-part" href="./tire-wheel-advertisement.php
            ">
            <article class="div-menu-part part-tires-wheels">
                <img class="div-menu-images" src="../img/tires-wheels.jpg" alt="">
                <span class="servis advert-text tires-wheels">Pneumatiky s&nbsp;diskami</span>
            </article>
            </a>
            <a class="menu-part" href="./history-dashboard.php
            ">
            <article class="div-menu-part part-history">
                <img class="div-menu-images" src="../img/history.jpg" alt="">
                <span class="servis advert-text">História</span>
            </article>
            </a>
            <a class="menu-part" href="./admin-about-us.php
            ">
            <article class="div-menu-part part-about-us">
                <img class="div-menu-images" src="../img/about-us.jpg" alt="">
                <span class="servis advert-text">O nás</span>
            </article>
            </a>
            <a class="menu-part" href="./change-password.php?user_id=<?= htmlspecialchars($_SESSION["logged_in_user_id"]) ?>">
            <article class="div-menu-part part-password">
                <img class="div-menu-images" src="../img/password.jpg" alt="">
                <span class="servis advert-text">Zmena hesla</span>
            </article>
            </a>
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>  
    <script src="../js/loading.js"></script>            
</body>
</html>


