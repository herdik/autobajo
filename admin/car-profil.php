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
    $car_equipments = ["Elektrické okná", "Elektrické sedadlá", "Bezkľúčové štartovanie", "Airbag", "Tempomat", "Vyhrievané sedadlá", "Parkovacie senzory", "Isofix", "Hlin. disky/Elektróny", "Klimatizácia", "Ťažné zariadenie", "Alarm"];
} else {
    $car_infos = null;
    $car_equipments = null;
}

// control if user choose image from image gallery 
$image_sequence = null;

// first index for $car_equipments loop
$inside_index = 12;

?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil auto</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/car-profil.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="advertisement-car">
            
            <article class="heading">

                <img src="../img/cars.jpg" alt="cars.jpg">

                <div class="main-car-info">

                    <div class="car-brand">
                        <h2 class="car-name"><?= htmlspecialchars($car_infos["car_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($car_infos["car_model"]) ?></h3>
                    </div>

                    <div class="car-description">
                        <h2><?= htmlspecialchars($car_infos["car_description"]) ?></h2>
                    </div>

                    <div class="car-infos">

                        <div class="car year">
                            <!-- <i class="fa-solid fa-hourglass-start"></i> -->
                            <span class="sub-heading">Rok výroby</span>
                            <span><?= htmlspecialchars($car_infos["year_of_manufacture"]) ?></span>
                        </div>

                        <div class="car kilometer">
                            <!-- <i class="fa-solid fa-car-side"></i> -->
                            <!-- <i class="fa-solid fa-route"></i> -->
                            <span class="sub-heading">Počet km</span>
                            <span><?= htmlspecialchars(number_format($car_infos["past_km"],0,","," ")) ?></span>
                        </div>

                        <div class="car fuel">
                            <!-- <i class="fa-solid fa-gas-pump"></i> -->
                            <span class="sub-heading">Palivo</span>
                            <span><?= htmlspecialchars($car_infos["fuel_type"]) ?></span>
                        </div>
                    </div>

                    <div class="car-infos">
                        <div class="car color">
                            <!-- <i class="fa-solid fa-palette"></i> -->
                            <span class="sub-heading">Farba</span>
                            <span><?= htmlspecialchars($car_infos["car_color"]) ?></span>
                        </div>
                        <div class="car gear">
                            <!-- <i class="fa-solid fa-gear"></i> -->
                            <span class="sub-heading">Prevodovka</span>
                            <span><?= htmlspecialchars($car_infos["gearbox"]) ?></span>
                        </div>
                        <div class="car engine">
                            <!-- <i class="fa-solid fa-gear"></i> -->
                            <span class="sub-heading">Prevodovka</span>
                            <span><?= htmlspecialchars($car_infos["engine_volume"]) ?></span>
                        </div>
                    </div>
                
                </div>

            </article>

            <article class="images">
            
                <label for="car-image" id="choose-img-text">Vybrať</label>
                <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                    <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Doplniť galériu</p>
                <?php else: ?>
                    <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                <?php endif; ?>
                
                <input id="car-image" type="file" name="car_image" multiple="multiple">
                    
            </article>

            <article class="other-info part">
                <h2>Výbava vozidla <i class="fa-solid fa-car"></i> <i class="fa-solid fa-toolbox"></i></i></h2> 
                
                <?php foreach($car_equipments as $car_equipment): ?>
                    <?php if ($car_infos[$inside_index]): ?>
                        <div class="check box">
                            <i class="fa-solid fa-clipboard-check"></i>
                            <span><?= htmlspecialchars($car_equipment) ?></span>
                            
                        </div>
                    <?php endif; ?>
                    <?php $inside_index++; ?>
                <?php endforeach; ?>
                
            </article>

            <article class="vehicle-condition part">
                <h2>Stav vozidla a doplnková výbava <i class="fa-solid fa-screwdriver-wrench"></i></h2> 

                <div class="check box">
                    <p><?= htmlspecialchars($car_infos["other_equipment"]) ?></p>
                    
                </div>
            </article>

            <article class="vehicle-price part">
                <h2>Cena vozidla <i class="fa-solid fa-money-bill-wave"></i></i></h2> 

                <div class="car-price box">
                
                    <h2><?= htmlspecialchars(number_format($car_infos["car_price"],0,","," ")) ?> &#8364;</h2>
                    
                </div>

            </article>

        </section>

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/show-image-name-car-advert.js"></script>  
    <script src="../js/header.js"></script>                   
</body>
</html>
