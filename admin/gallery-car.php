<?php

require "../classes/Database.php";
require "../classes/CarImage.php";

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
    $car_id = $_GET["car_id"];
    $car_images = CarImage::getAllCarsImages($connection, $car_id);
} else {
    $car_images = null;
}
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galéria</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/gallery.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Galéria</h1>
        <section class="dashboard-menu">

            
        <article class="div-menu-part">
                
                    <?php foreach ($car_images as $car_image): ?>
                    <div class="div-menu-images">
                    
                        <img src="../uploads/cars/<?= htmlspecialchars($car_id) ?>/<?= htmlspecialchars($car_image["image_name"]) ?>" alt="">
                    
                    </div>
                    <?php endforeach; ?>
                    
            </article>

            
            <!-- <article class="div-menu-part">
                    <h2>Všetky obrázky</h2>
                    <a href="./tires-service.php">
                    <div class="div-menu-images">
                        <img  src="../img/gal-images.jpg" alt="">
                    </div>
                </a>
            </article> -->
            
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>        
</body>
</html>


