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


// database connection
$database = new Database();
$connection = $database->connectionDB();

$cars_advertisements = Car::getAllCarsAdvertisement($connection, "car_id, car_brand, car_model, year_of_manufacture, past_km, fuel_type, car_description, car_price, car_image");

if (count($cars_advertisements) === 0) {
    $contact_infos["company_name"] = "";
    $contact_infos["street_number"] = "";
    $contact_infos["town_post_nr"] = "";
    $contact_infos["email_1"] = "";
    $contact_infos["tel_1"] = "";
    $contact_infos["email_2"] = "";
    $contact_infos["tel_2"] = "";
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
    <link rel="stylesheet" href="../css/cars.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Ponuka automobilov</h1>
        <section class="cars-menu">

            <?php foreach ($cars_advertisements as $one_car): ?>
            <article class="car-advertisement">
                
                <?php if ($one_car["car_image"] != "no-photo-car.jpg"): ?>

                    <div class="car-picture" style="
                                    background: url(../uploads/<?= htmlspecialchars($one_car["car_id"]) ?>/<?= htmlspecialchars($one_car["car_image"]) ?>);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>
                
                <?php else: ?>
                    <div class="car-picture" style="
                                    background: url(../img/no-photo-car/no-photo-car.jpg);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>

                <?php endif ?>

                <div class="basic-car-info">

                    <div class="car-brand">
                        <h2 class="heading"><?= htmlspecialchars($one_car["car_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($one_car["car_model"]) ?></h3>
                    </div>

                    <div class="car-description">
                        <h2><?= htmlspecialchars($one_car["car_description"]) ?></h2>
                    </div>

                    <div class="car-infos">

                        <div class="car year">
                            <!-- <i class="fa-solid fa-hourglass-start"></i> -->
                            <span class="sub-heading">Rok výroby</span>
                            <span><?= htmlspecialchars($one_car["year_of_manufacture"]) ?></span>
                        </div>

                        <div class="car kilometer">
                            <!-- <i class="fa-solid fa-car-side"></i> -->
                            <!-- <i class="fa-solid fa-route"></i> -->
                            <span class="sub-heading">Počet km</span>
                            <span><?= htmlspecialchars(number_format($one_car["past_km"],0,","," ")) ?></span>
                        </div>

                        <div class="car fuel">
                            <!-- <i class="fa-solid fa-gas-pump"></i> -->
                            <span class="sub-heading">Palivo</span>
                            <span><?= htmlspecialchars($one_car["fuel_type"]) ?></span>
                        </div>
            
            
                    </div>

                    <div class="car-price">
                        <h2><?= htmlspecialchars(number_format($one_car["car_price"],0,","," ")) ?> &#8364;</h2>
                    </div>

                    
                </div>
            </article>
            <?php endforeach ?>
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>            
</body>
</html>


