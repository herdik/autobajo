<?php

require "./classes/Database.php";
require "./classes/TireWheel.php";
require "./classes/TireWheelImage.php";

// connection to Database
$database = new Database();
$connection = $database->connectionDB();


if ((isset($_GET["tire_wheel_id"]) and is_numeric($_GET["tire_wheel_id"])) and (isset($_GET["active_advertisement"]) and is_numeric($_GET["active_advertisement"]))){
    $tire_wheel_infos = TireWheel::getTireWheel($connection, $_GET["tire_wheel_id"]);
    $tire_wheel_images = TireWheelImage::getAllTireWheelsImages($connection, $_GET["tire_wheel_id"]);

    // active true means aktice advertisement active false/0 means advertisement in history
    $active_advertisement = $_GET["active_advertisement"];
} else {
    $tire_wheel_infos = null;
    $active_advertisement = null;
    $tire_wheel_images = null;
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
<base href="http://localhost/autobajo/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil pneumatík na diskoch</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/tire-wheel-profil.css">
    <link rel="stylesheet" href="./query/global-header-query.css">
    <link rel="stylesheet" href="./query/profil-query.css">

</head>
<body>
    
<div class="loader">
        <div class="loader-animation"></div>
    </div>
   
    <?php require "./assets/header.php" ?>

    <dialog class="gallery-slider" id="gallery-slider">

        <div class="close">X</div>

        <div class="left arrow"></div>

        <div class="show-image">

        <?php if ($tire_wheel_infos["tire_wheel_image"] === "no-photo-car.jpg"): ?>
            <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
        <?php else: ?>
            <img src="./uploads/tireswithwheels/<?= htmlspecialchars($tire_wheel_infos["tire_wheel_id"]) ?>/<?= htmlspecialchars($tire_wheel_infos["tire_wheel_image"]) ?>" alt="">
        <?php endif; ?>
        
        <?php foreach ($tire_wheel_images as $tire_wheel_image): ?>
            <?php if ($tire_wheel_image["image_name"] != $tire_wheel_infos["tire_wheel_image"]): ?>
                <?php if ($tire_wheel_image["image_name"] === "no-photo-car.jpg"): ?>
                    <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                <?php else: ?>
                    <img src="./uploads/tireswithwheels/<?= htmlspecialchars($tire_wheel_image["tire_wheel_id"]) ?>/<?= htmlspecialchars($tire_wheel_image["image_name"]) ?>" alt="">
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="img-info"></div>

        </div>

        <div class="right arrow"></div>   

    </dialog>

    <main>

        <section class="advertisement-tire">
            
        <article class="heading">
                <div class="main-image">    

                    <?php if ($tire_wheel_infos["tire_wheel_image"] === "no-photo-car.jpg"): ?>
                        <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                    <?php else: ?>
                        <img src="./uploads/tireswithwheels/<?= htmlspecialchars($tire_wheel_infos["tire_wheel_id"]) ?>/<?= htmlspecialchars($tire_wheel_infos["tire_wheel_image"]) ?>" alt="">
                    <?php endif; ?>

                    <?php if ($tire_wheel_infos["reserved"]): ?>
                        <div class="advert-label">
                            Rezervované
                        </div>
                    <?php elseif ($tire_wheel_infos["sold"]): ?>
                        <div class="advert-label">
                            Predané
                        </div>
                    <?php endif; ?>
                    <div class="gallery-text">Otvoriť galériu</div> 

                </div>
                
                <div class="main-tire-info main-product-info">

                    <div class="product-part part-tire">

                    
                        <div class="tire-brand">
                            <h2 class="tire-name"><?= htmlspecialchars($tire_wheel_infos["tire_brand"]) ?></h2>
                            <h3 class="model"><?= htmlspecialchars($tire_wheel_infos["tire_model"]) ?></h3>
                        </div>

                        <div class="tire-description">
                            <h2>Typ/Obdobie: <?= htmlspecialchars($tire_wheel_infos["type"]) ?></h2>
                        </div>

                        <div class="tire-infos">

                            <div class="tire year product-category">
                                <span class="sub-heading text">Rok výroby</span>
                                <span class="sub-heading material-symbols-outlined set-icon">pending_actions</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["year_of_manufacture"]) ?></span>
                            </div>

                            <div class="tire category product-category">
                                <span class="sub-heading text">Kategória</span>
                                <span class="sub-heading material-symbols-outlined set-icon">traffic_jam</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["tire_category"]) ?></span>
                            </div>

                            <div class="tire width product-category">
                                <span class="sub-heading text">Šírka</span>
                                <span class="sub-heading material-symbols-outlined set-icon">format_letter_spacing</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["tire_width"]) ?></span>
                            </div>
                        </div>

                        <div class="tire-infos">
                            <div class="tire height product-category">
                                <span class="sub-heading text">Výška</span>
                                <span class="sub-heading material-symbols-outlined set-icon">expand</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["height"]) ?></span>
                            </div>
                            <div class="tire average product-category">
                                <span class="sub-heading text">Priemer</span>
                                <span class="sub-heading material-symbols-outlined set-icon">hide_source</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["construction"]) .  htmlspecialchars($tire_wheel_infos["average"])?></span>
                            </div>
                            <div class="tire index product-category">
                                <span class="sub-heading text">H/R index</span>
                                <span class="sub-heading material-symbols-outlined set-icon">rocket_launch</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["weight_index"]) . htmlspecialchars($tire_wheel_infos["speed_index"])?></span>
                            </div>
                        </div>

                        <div class="product">
                            <img src="./img/icon-tire.png" alt="tire" alt="">
                        </div>
                    </div>

                    <div class="product-part">

                        <div class="tire-brand">
                            <h2 class="tire-name"><?= htmlspecialchars($tire_wheel_infos["wheel_brand"]) ?></h2>
                            <h3 class="model"><?= htmlspecialchars($tire_wheel_infos["wheel_model"]) ?></h3>
                        </div>

                        <div class="tire-description">
                            <h2>Farba: <?= htmlspecialchars($tire_wheel_infos["wheel_color"]) ?></h2>
                        </div>

                        <div class="tire-infos">

                            <div class="tire category product-category">
                                
                                <span class="sub-heading text">Kategória</span>
                                <span class="sub-heading material-symbols-outlined set-icon">apps</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["wheel_category"]) ?></span>
                            </div>

                            <div class="tire average product-category">
                                
                                <span class="sub-heading text">Priemer</span>
                                <span class="sub-heading material-symbols-outlined set-icon">hide_source</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["wheel_average"]) ?></span>
                            </div>
                            
                        </div>

                        <div class="tire-infos">
                            
                            <div class="tire width product-category">
                                
                                <span class="sub-heading text">Šírka</span>
                                <span class="sub-heading material-symbols-outlined set-icon">format_letter_spacing</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["wheel_width"]) ?></span>
                            </div>

                            <div class="tire spacing product-category">
                                <span class="sub-heading text">Rozteč</span>
                                <span class="sub-heading material-symbols-outlined set-icon">adjust</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["spacing"]) ?></span>
                            </div>

                            <div class="tire et product-category">
                                
                                <span class="sub-heading text">ET</span>
                                <span class="sub-heading material-symbols-outlined set-icon">ET</span>
                                <span><?= htmlspecialchars($tire_wheel_infos["et"]) ?></span>
                            </div>

                        </div>

                        <div class="product">
                            <img src="./img/icon-wheel.png" alt="tire" alt="">
                        </div>
                    </div>
                </div>

            </article>

            <article class="management-part">

                <div class="slider">
                    <?php foreach ($tire_wheel_images as $tire_wheel_image): ?>
                        <?php if ($tire_wheel_image["image_name"] === "no-photo-car.jpg"): ?>
                            <img class="slide" src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                        <?php else: ?>
                            <img class="slide" src="./uploads/tireswithwheels/<?= htmlspecialchars($tire_wheel_image["tire_wheel_id"]) ?>/<?= htmlspecialchars($tire_wheel_image["image_name"]) ?>" alt="">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </article>

            <article class="tires-condition part">
                <h2>Popis</h2> 

                <div class="check box">
                    <p><?= htmlspecialchars($tire_wheel_infos["description"]) ?></p>
                    
                </div>
            </article>

            <article class="tires-price part">
                <h2>Cena</h2> 

                <div class="tire-price box">
                
                    <h2><?= htmlspecialchars(number_format($tire_wheel_infos["price"],0,","," ")) ?> &#8364; s DPH</h2>
                    
                </div>

            </article>

        </section>

    </main>
    
    <?php require "./assets/footer.php" ?>
    
    <script src="./js/header.js"></script>  
    <script src="./js/show-gallery.js"></script>  
    <script src="./js/slider-animation.js"></script>     
    <script src="./js/loading.js"></script>    
    <script src="./js/check-cookie.js"></script>               
</body>
</html>
