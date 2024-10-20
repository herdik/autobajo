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
    <link rel="stylesheet" href="./query/header-query.css">

</head>
<body>

<?php require "./assets/header.php" ?>

    <main>

        <section class="div-menu">
            
            <a href="./glob-car-advertisement.php">
                <article class="div-menu-part part-cars">
                    <img class="div-menu-images" src="./img/cars.jpg" alt="">
                    <span class="cars advert-text">Autá</span>
                </article>
            </a>

            <a href="./glob-tire-advertisement.php">
                <article class="div-menu-part part-tires">
                    <img class="div-menu-images" src="./img/tires.jpg" alt="">
                    <span class="tires advert-text">Pneumatiky</span>
                </article>
            </a>

            <a href="./glob-wheel-advertisement.php">
                <article class="div-menu-part part-rimes">
                    <img class="div-menu-images" src="./img/rim.jpg" alt="">
                    <span class="rimes advert-text">Disky</span>
                </article>
            </a>

            <a href="./global-tires-service.php">
                <article class="div-menu-part part-servis">
                    <img class="div-menu-images" src="./img/servis.jpg" alt="">
                    <span class="servis advert-text">Pneuservis</span>
                </article>
            </a>
            
        </section>
        
    </main>

    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>
    <script src="./js/header-nav-visibility.js"></script>
</body>
</html>
