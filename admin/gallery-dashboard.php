<?php

require "../classes/Database.php";
require "../classes/Car.php";

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


if (isset($_GET["car_id"]) and is_numeric($_GET["car_id"])){
    $car_infos = Car::getCar($connection, $_GET["car_id"]);
} else {
    $car_infos = null;
}

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrázky - administrácia</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/gallery-dashboard.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Administrácia obrázkov</h1>
        <section class="dashboard-menu">

            
        <article class="div-menu-part">
                    <h2">Titulný obrázok</h2>
                    <a href="./title-image-car.php?car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">
                    <div class="div-menu-images">
                        <?php if ($car_infos["car_image"] === "no-photo-car.jpg"): ?>
                        <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                    <?php else: ?>
                        <img src="../uploads/cars/<?= htmlspecialchars($car_infos["car_id"]) ?>/<?= htmlspecialchars($car_infos["car_image"]) ?>" alt="">
                    <?php endif; ?>
                    </div>
                    </a>
            </article>

            
            <article class="div-menu-part">
                    <h2>Všetky obrázky</h2>
                    <a href="./gallery-car.php?car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">
                    <div class="div-menu-images">
                        <img  src="../img/gal-images.jpg" alt="">
                    </div>
                </a>
            </article>
            
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>            
</body>
</html>


