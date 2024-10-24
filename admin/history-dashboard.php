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
    <title>História - administrácia</title>

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

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>História - administrácia</h1>
        <section class="dashboard-menu">

            
            <a class="menu-part" href="./car-advertisement.php?car_history=0
            ">
            <article class="div-menu-part part-cars">
                <img class="div-menu-images" src="../img/cars.jpg" alt="">
                <span class="cars advert-text">Autá</span>
            </article>
            </a>

            <a class="menu-part" href="./tire-advertisement.php?tire_history=0
            ">
            <article class="div-menu-part part-tires">
                <img class="div-menu-images" src="../img/tires.jpg" alt="">
                <span class="tires advert-text">Pneumatiky</span>
            </article>
            </a>

            <a class="menu-part" href="./wheel-advertisement.php?wheel_history=0
            ">
            <article class="div-menu-part part-rimes">
                <img class="div-menu-images" src="../img/rim.jpg" alt="">
                <span class="rimes advert-text">Disky</span>
            </article>
            </a>

            
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>            
</body>
</html>


