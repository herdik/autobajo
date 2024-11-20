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
    <title>Typ inzerátu</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/advertisement.css">
    <link rel="stylesheet" href="../query/header-query.css"> 
    <link rel="stylesheet" href="../query/new-advert-query.css"> 

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Typ inzerátu</h1>
        <section class="dashboard-menu">

            <a class="main-part" href="./reg-form-car.php
            ">  
                <article class="div-menu-part part-cars">
                    <img class="div-menu-images" src="../img/cars-advert.jpg" alt="">
                    <span class="cars">Pridať auto</span>
                </article>
            </a>

            <a class="main-part" href="./reg-form-tire.php
            ">
            <article class="div-menu-part part-tires">
                <img class="div-menu-images" src="../img/tires-advert.jpg" alt="">
                <span class="tires">Pridať pneumatiky</span>
            </article>
            </a>

            <a class="main-part" href="./reg-form-wheel.php
            ">
            <article class="div-menu-part part-rimes">
                <img class="div-menu-images" src="../img/rimes-advert.jpg" alt="">
                <span class="rimes">Pridať disky</span>
            </article>
            </a>

            <a class="main-part" href="./reg-form-tire-wheel.php
            ">
            <article class="div-menu-part part-tires-wheels">
                <img class="div-menu-images" src="../img/tires-wheels.jpg" alt="">
                <span class="rimes">Pridať pneumatiky s&nbsp;diskami</span>
            </article>
            </a>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>      
    <script src="../js/loading.js"></script>        
</body>
</html>


