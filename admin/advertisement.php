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

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/advertisement.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Typ inzerátu</h1>
        <section class="dashboard-menu">

            <a href="./reg-form-car.php
            ">  
                <article class="div-menu-part part-cars">
                    <img class="div-menu-images" src="../img/cars-advert.jpg" alt="">
                    <span class="cars">Pridať auto</span>
                </article>
            </a>

            <a href="./reg-form-tire.php
            ">
            <article class="div-menu-part part-tires">
                <img class="div-menu-images" src="../img/tires-advert.jpg" alt="">
                <span class="tires">Pridať pneumatiky</span>
            </article>
            </a>

            <a href="./reg-form-wheel.php
            ">
            <article class="div-menu-part part-rimes">
                <img class="div-menu-images" src="../img/rimes-advert.jpg" alt="">
                <span class="rimes">Pridať disky</span>
            </article>
            </a>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>            
</body>
</html>


