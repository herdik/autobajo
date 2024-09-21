<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoBajo</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php require "./assets/header.php" ?>

    <main>

        <section class="div-menu">
            
            <article class="div-menu-part part-cars">
                <img class="div-menu-images" src="./img/cars.jpg" alt="">
                <span class="cars">Autá</span>
            </article>

            <article class="div-menu-part part-tires">
                <img class="div-menu-images" src="./img/tires.jpg" alt="">
                <span class="tires">Pneumatiky</span>
            </article>

            <article class="div-menu-part part-rimes">
                <img class="div-menu-images" src="./img/rim.jpg" alt="">
                <span class="rimes">Disky</span>
            </article>

            <a href="./global-tires-service.php">
            <article class="div-menu-part part-servis">
                <img class="div-menu-images" src="./img/servis.jpg" alt="">
                <span class="servis">Pneuservis</span>
            </article>
            </a>
            
        </section>
        
d
    </main>

    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>
</body>
</html>
