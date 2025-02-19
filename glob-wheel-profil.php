<?php

require "./classes/Database.php";
require "./classes/Wheel.php";
require "./classes/WheelImage.php";

// connection to Database
$database = new Database();
$connection = $database->connectionDB();


if ((isset($_GET["wheel_id"]) and is_numeric($_GET["wheel_id"])) and (isset($_GET["active_advertisement"]) and is_numeric($_GET["active_advertisement"]))){
    $wheel_infos = Wheel::getWheel($connection, $_GET["wheel_id"]);
    $wheel_images = WheelImage::getAllWheelsImages($connection, $_GET["wheel_id"]);

    // active true means aktice advertisement active false/0 means advertisement in history
    $active_advertisement = $_GET["active_advertisement"];
} else {
    $wheel_infos = null;
    $active_advertisement = null;
    $wheel_images = null;
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<base href="http://localhost/autobajo/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil pneumatík</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/wheel-profil.css">
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

        <?php if ($wheel_infos["wheel_image"] === "no-photo-car.jpg"): ?>
            <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
        <?php else: ?>
            <img src="./uploads/wheels/<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>/<?= htmlspecialchars($wheel_infos["wheel_image"]) ?>" alt="">
        <?php endif; ?>
        
        <?php foreach ($wheel_images as $wheel_image): ?>
            <?php if ($wheel_image["image_name"] != $wheel_infos["wheel_image"]): ?>
                <?php if ($wheel_image["image_name"] === "no-photo-car.jpg"): ?>
                    <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                <?php else: ?>
                    <img src="./uploads/wheels/<?= htmlspecialchars($wheel_image["wheel_id"]) ?>/<?= htmlspecialchars($wheel_image["image_name"]) ?>" alt="">
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="img-info"></div>

        </div>

        <div class="right arrow"></div>   

    </dialog>

    <main>

        <section class="advertisement-wheel">
            
            <article class="heading">
                <div class="main-image">

                    <?php if ($wheel_infos["wheel_image"] === "no-photo-car.jpg"): ?>
                        <img src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                    <?php else: ?>
                        <img src="./uploads/wheels/<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>/<?= htmlspecialchars($wheel_infos["wheel_image"]) ?>" alt="">
                    <?php endif; ?>

                    <?php if ($wheel_infos["reserved"]): ?>
                        <div class="advert-label">
                            Rezervované
                        </div>
                    <?php elseif ($wheel_infos["sold"]): ?>
                        <div class="advert-label">
                            Predané
                        </div>
                    <?php endif; ?>

                    <div class="gallery-text">Otvoriť galériu</div>

                </div>

                <div class="main-wheel-info main-product-info">

                    <div class="wheel-brand">
                        <h2 class="wheel-name"><?= htmlspecialchars($wheel_infos["wheel_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($wheel_infos["wheel_model"]) ?></h3>
                    </div>

                    <div class="wheel-description">
                        <h2>Farba: <?= htmlspecialchars($wheel_infos["wheel_color"]) ?></h2>
                    </div>

                    <div class="wheel-infos">

                        <div class="wheel category product-category">
                            
                            <span class="sub-heading text">Kategória</span>
                            <span class="sub-heading material-symbols-outlined set-icon">apps</span>
                            <span><?= htmlspecialchars($wheel_infos["wheel_category"]) ?></span>
                        </div>

                        <div class="wheel average product-category">
                            
                            <span class="sub-heading text">Priemer</span>
                            <span class="sub-heading material-symbols-outlined set-icon">hide_source</span>
                            <span><?= htmlspecialchars($wheel_infos["wheel_average"]) ?></span>
                        </div>
                        
                    </div>

                    <div class="wheel-infos">
                        
                        <div class="wheel width product-category">
                            
                            <span class="sub-heading text">Šírka</span>
                            <span class="sub-heading material-symbols-outlined set-icon">format_letter_spacing</span>
                            <span><?= htmlspecialchars($wheel_infos["width"]) ?></span>
                        </div>

                        <div class="wheel spacing product-category">
                            <span class="sub-heading text">Rozteč</span>
                            <span class="sub-heading material-symbols-outlined set-icon">adjust</span>
                            <span><?= htmlspecialchars($wheel_infos["spacing"]) ?></span>
                        </div>

                        <div class="wheel et product-category">
                            
                            <span class="sub-heading text">ET</span>
                            <span class="sub-heading material-symbols-outlined set-icon">ET</span>
                            <span><?= htmlspecialchars($wheel_infos["et"]) ?></span>
                        </div>

                    </div>
                
                </div>

            </article>

            <article class="management-part">

                <div class="slider">
                    <?php foreach ($wheel_images as $wheel_image): ?>
                        <?php if ($wheel_image["image_name"] === "no-photo-car.jpg"): ?>
                            <img class="slide" src="./img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                        <?php else: ?>
                            <img class="slide" src="./uploads/wheels/<?= htmlspecialchars($wheel_image["wheel_id"]) ?>/<?= htmlspecialchars($wheel_image["image_name"]) ?>" alt="">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </article>

            <article class="wheels-condition part">
                <h2>Popis disku </h2> 

                <div class="check box">
                    <p><?= htmlspecialchars($wheel_infos["wheel_description"]) ?></p>
                    
                </div>
            </article>

            <article class="wheels-price part">
                <h2>Cena disku</h2> 

                <div class="wheel-price box">
                
                    <h2><?= htmlspecialchars(number_format($wheel_infos["wheel_price"],0,","," ")) ?> &#8364; s DPH</h2>
                    
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
