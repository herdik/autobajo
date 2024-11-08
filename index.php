<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoBajo</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <!-- ICONS MENU -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <!-- ICONS MENU -->

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/global-header-query.css">
    <link rel="stylesheet" href="./query/index-query.css">

</head>
<body>

<?php require "./assets/header.php" ?>

    <main>

        <div class="menu-border-animation">

            <div class="comp-logo">
                <img src="./img/autobajo-logo-transparent.png" alt="">
            </div>
            <h1>AutoBajo / Pneuservis DB</h1>
            <p>predaj  ojazdených automobilov, pneumatík a diskov</p>

            <section class="div-menu">
                
            <a class="menu-part" href="./glob-car-advertisement.php">
                    <article class="div-menu-part part-cars">
                        <img class="div-menu-images" src="./img/cars.jpg" alt="">
                        <span class="cars advert-text">Autá</span>
                    </article>
                </a>

                <a class="menu-part" href="./glob-tire-advertisement.php">
                    <article class="div-menu-part part-tires">
                        <img class="div-menu-images" src="./img/tires.jpg" alt="">
                        <span class="tires advert-text">Pneumatiky</span>
                    </article>
                </a>

                <a class="menu-part part-hide" href="./global-tires-service.php">
                    <article class="div-menu-part part-servis">
                        <img class="div-menu-images" src="./img/servis.jpg" alt="">
                        <span class="servis advert-text">Pneuservis</span>
                    </article>
                </a>

                <a class="menu-part" href="./glob-wheel-advertisement.php">
                    <article class="div-menu-part part-rimes">
                        <img class="div-menu-images" src="./img/rim.jpg" alt="">
                        <span class="rimes advert-text">Disky</span>
                    </article>
                </a>

            
                <a class="menu-part" href="./glob-tire-wheel-advertisement.php">
                    <article class="div-menu-part part-tires-wheels">
                        <img class="div-menu-images-last" src="./img/tires-wheels.jpg" alt="">
                        <span class="tires-wheels advert-text">Pneumatiky s diskami</span>
                    </article>
                </a>
                
            </section>
        </div>
    </main>

    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>
</body>
</html>
