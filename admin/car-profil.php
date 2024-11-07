<?php
require "../classes/Database.php";
require "../classes/Car.php";
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


if ((isset($_GET["car_id"]) and is_numeric($_GET["car_id"])) and (isset($_GET["active_advertisement"]) and is_numeric($_GET["active_advertisement"]))){
    $car_infos = Car::getCar($connection, $_GET["car_id"]);
    $car_equipments = ["Elektrické okná", "Elektrické sedadlá", "Bezkľúčové štartovanie", "Airbag", "Tempomat", "Vyhrievané sedadlá", "Parkovacie senzory", "Isofix", "Hlin. disky/Elektróny", "Klimatizácia", "Ťažné zariadenie", "Alarm"];
    $car_images = CarImage::getAllCarsImages($connection, $_GET["car_id"]);

    
    // active true means aktice advertisement active false/0 means advertisement in history
    $active_advertisement = $_GET["active_advertisement"];
} else {
    $car_infos = null;
    $car_equipments = null;
    $active_advertisement = null;
    $car_images = null;
}

// first index for $car_equipments loop
$inside_index = 13;
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil auto</title>

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
    <link rel="stylesheet" href="../css/car-profil.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/profil-query.css">

</head>
<body>
    
    <?php require "../assets/admin-header.php" ?>

    <dialog class="gallery-slider" id="gallery-slider">

        <div class="close">X</div>

        <div class="left arrow"></div>

        <div class="show-image">

        <?php if ($car_infos["car_image"] === "no-photo-car.jpg"): ?>
            <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
        <?php else: ?>
            <img src="../uploads/cars/<?= htmlspecialchars($car_infos["car_id"]) ?>/<?= htmlspecialchars($car_infos["car_image"]) ?>" alt="">
        <?php endif; ?>
        
        <?php foreach ($car_images as $car_image): ?>
            <?php if ($car_image["image_name"] != $car_infos["car_image"]): ?>
                <?php if ($car_image["image_name"] === "no-photo-car.jpg"): ?>
                    <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                <?php else: ?>
                    <img src="../uploads/cars/<?= htmlspecialchars($car_image["car_id"]) ?>/<?= htmlspecialchars($car_image["image_name"]) ?>" alt="">
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="img-info"></div>

        </div>

        <div class="right arrow"></div>   

    </dialog>

    <main>

        <section class="advertisement-car">
            
            <article class="heading">
                <div class="main-image">

                    <?php if ($car_infos["car_image"] === "no-photo-car.jpg"): ?>
                        <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                    <?php else: ?>
                        <img src="../uploads/cars/<?= htmlspecialchars($car_infos["car_id"]) ?>/<?= htmlspecialchars($car_infos["car_image"]) ?>" alt="">
                    <?php endif; ?>
                    
                    <?php if ($car_infos["reserved"]): ?>
                        <div class="advert-label">
                            Rezervované
                        </div>
                    <?php elseif ($car_infos["sold"]): ?>
                        <div class="advert-label">
                            Predané
                        </div>
                    <?php elseif (!$car_infos["active"]): ?>
                        <div class="advert-label">
                            Neaktívny
                        </div>
                    <?php endif; ?>

                    <div class="gallery-text">Otvoriť galériu</div>
                    
                </div>
                <div class="main-car-info main-product-info">

                    <div class="car-brand">
                        <h2 class="car-name"><?= htmlspecialchars($car_infos["car_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($car_infos["car_model"]) ?></h3>
                    </div>

                    <div class="car-description">
                        <h2><?= htmlspecialchars($car_infos["car_description"]) ?></h2>
                    </div>

                    <div class="car-description watts">
                        <span class="sub-heading text bolder">KW</span>
                        <span class="sub-heading material-symbols-outlined set-icon">electric_bolt</span>
                        <span><?= htmlspecialchars($car_infos["kw"]) ?></span>
                    </div>

                    <div class="car-infos">

                        <div class="car year product-category">
                            <span class="sub-heading text">Rok výroby</span>
                            <span class="sub-heading material-symbols-outlined set-icon">pending_actions</span>

                            <span><?= htmlspecialchars($car_infos["year_of_manufacture"]) ?></span>
                        </div>

                        <div class="car kilometer product-category">
                            <span class="sub-heading text">Počet km</span>
                            <span class="sub-heading material-symbols-outlined set-icon">unpaved_road</span>

                            <span><?= htmlspecialchars(number_format($car_infos["past_km"],0,","," ")) . " km"?></span>
                        </div>

                        <div class="car fuel product-category">
                            <span class="sub-heading text">Palivo</span>
                            <span class="sub-heading material-symbols-outlined set-icon">local_gas_station</span>

                            <span><?= htmlspecialchars($car_infos["fuel_type"]) ?></span>
                        </div>
                    </div>

                    <div class="car-infos">
                        <div class="car color product-category">
                            <span class="sub-heading text">Farba</span>
                            <span class="sub-heading material-symbols-outlined set-icon">palette</span>

                            <span><?= htmlspecialchars($car_infos["car_color"]) ?></span>
                        </div>
                        <div class="car gear product-category">
                            <span class="sub-heading text">Prevodovka</span>
                            <span class="sub-heading material-symbols-outlined set-icon">auto_transmission</span>

                            <span><?= htmlspecialchars($car_infos["gearbox"]) ?></span>
                        </div>
                        <div class="car engine product-category">
                            <span class="sub-heading text">Objem motora</span>
                            <span class="sub-heading material-symbols-outlined set-icon">manufacturing</span>

                            <span><?= htmlspecialchars($car_infos["engine_volume"]) ?></span>
                        </div>
                    </div>
                
                </div>

            </article>

            <article class="management-part">
                 
                <div class="administration">
                    <h2>Administrácia</h2>
                    <input type="hidden" id="current-id" name="car_id" value="<?= htmlspecialchars($car_infos["car_id"]) ?>">
                    <div class="administration-part">
                        <a class="btn" href="./edit-car-advertisement.php?car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Upraviť</a>
                        <a class="btn" href="./gallery-car.php?car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Galéria</a>

                        <?php if ($car_infos["active"]): ?>
                            <a class="btn" href="./after-update-car-advert.php?active=false&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Dektivovať</a>
                        <?php else: ?>
                            <a class="btn-green" href="./after-update-car-advert.php?active=true&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Aktivovať</a>
                        <?php endif; ?>

                        <?php if ($active_advertisement): ?>
                            <?php if ($car_infos["reserved"]): ?>
                                <a class="btn-green" id="btn-reserved" href="./after-update-car-advert.php?reserved=false&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Dostupné</a>
                                <?php else: ?>
                                    <a class="btn" id="btn-reserved" href="./after-update-car-advert.php?reserved=true&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Rezervované</a>
                            <?php endif; ?>   
                            
                            <?php if ($car_infos["sold"]): ?>
                                <a class="btn-green" id="btn-sold" href="./after-update-car-advert.php?sold=false&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Dostupné</a>
                                <?php else: ?>
                                    <a class="btn" id="btn-sold" href="./after-update-car-advert.php?sold=true&car_id=<?= htmlspecialchars($car_infos["car_id"]) ?>">Predané</a>
                            <?php endif; ?> 
                        <?php endif; ?>

                    </div>
                </div>
                
                
            </article>

            <article class="other-info part">
                <h2>Výbava vozidla</h2> 
                
                <?php foreach($car_equipments as $car_equipment): ?>
                    <?php if ($car_infos[$inside_index]): ?>
                        <div class="check box">
                            <span class="material-symbols-outlined">verified_user</span>
                            <span><?= htmlspecialchars($car_equipment) ?></span>
                            
                        </div>
                    <?php endif; ?>
                    <?php $inside_index++; ?>
                <?php endforeach; ?>
                
            </article>

            <article class="vehicle-condition part">
                <h2>Stav vozidla a doplnková výbava</h2> 

                <div class="check box">
                    <p><?= htmlspecialchars($car_infos["other_equipment"]) ?></p>
                    
                </div>
            </article>

            <article class="vehicle-price part">
                <h2>Cena vozidla</h2> 

                <div class="car-price box">
                
                    <h2><?= htmlspecialchars(number_format($car_infos["car_price"],0,","," ")) ?> &#8364; s DPH</h2>
                    
                </div>

            </article>

        </section>

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script src="../js/header.js"></script>                   
    <script src="../js/show-gallery.js"></script>                   
    <script src="../js/update-car-advert.js"></script>                   
</body>
</html>
