<?php

require "../classes/Database.php";
require "../classes/Wheel.php";

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


if (isset($_GET["wheel_id"]) and is_numeric($_GET["wheel_id"])){
    $wheel_infos = Wheel::getWheel($connection, $_GET["wheel_id"]);
} else {
    $wheel_infos = null;
}

// control if user choose image from image gallery 
$image_sequence = null;

?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil pneumatík</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/wheel-profil.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="advertisement-wheel">
            
            <article class="heading">

                <?php if ($wheel_infos["wheel_image"] === "no-photo-car.jpg"): ?>
                    <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                <?php else: ?>
                    <img src="../uploads/wheels/<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>/<?= htmlspecialchars($wheel_infos["wheel_image"]) ?>" alt="">
                <?php endif; ?>

                <?php if ($wheel_infos["reserved"]): ?>
                    <div class="advert-label">
                        Rezervované
                    </div>
                <?php elseif ($wheel_infos["sold"]): ?>
                    <div class="advert-label">
                        Predané
                    </div>
                <?php elseif (!$wheel_infos["active"]): ?>
                    <div class="advert-label">
                        Neaktívny
                    </div>
                <?php endif; ?>

                <div class="main-wheel-info">

                    <div class="wheel-brand">
                        <h2 class="wheel-name"><?= htmlspecialchars($wheel_infos["wheel_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($wheel_infos["wheel_model"]) ?></h3>
                    </div>

                    <div class="wheel-description">
                        <h2>Farba: <?= htmlspecialchars($wheel_infos["wheel_color"]) ?></h2>
                    </div>

                    <div class="wheel-infos">

                        <div class="wheel category">
                            
                            <span class="sub-heading">Kategória</span>
                            <span><?= htmlspecialchars($wheel_infos["wheel_category"]) ?></span>
                        </div>

                        <div class="wheel average">
                            
                            <span class="sub-heading">Priemer</span>
                            <span><?= htmlspecialchars($wheel_infos["wheel_average"]) ?></span>
                        </div>
                        
                    </div>

                    <div class="wheel-infos">
                        
                        <div class="wheel width">
                            
                            <span class="sub-heading">Šírka</span>
                            <span><?= htmlspecialchars($wheel_infos["width"]) ?></span>
                        </div>

                        <div class="wheel spacing">
                            <span class="sub-heading">Rozteč</span>
                            <span><?= htmlspecialchars($wheel_infos["spacing"]) ?></span>
                        </div>

                        <div class="wheel et">
                            
                            <span class="sub-heading">ET</span>
                            <span><?= htmlspecialchars($wheel_infos["et"]) ?></span>
                        </div>

                    </div>
                
                </div>

            </article>

            <article class="management-part">

                <div class="slider-gallery">

                </div>
                

                <div class="administration">
                    <h2>Administrácia</h2>

                    <div class="administration-part">
                        <a class="btn" href="./edit-wheel-advertisement.php?wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Upraviť</a>
                        <a class="btn" href="./after-update-wheel-advert.php">Galéria</a>

                        <?php if ($wheel_infos["active"]): ?>
                            <a class="btn" href="./after-update-wheel-advert.php?active=false&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Dektivovať</a>
                        <?php else: ?>
                            <a class="btn-green" href="./after-update-wheel-advert.php?active=true&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Aktivovať</a>
                        <?php endif; ?>

                        <?php if ($wheel_infos["reserved"]): ?>
                            <a class="btn-green" href="./after-update-wheel-advert.php?reserved=false&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Dostupné</a>
                            <?php else: ?>
                                <a class="btn" href="./after-update-wheel-advert.php?reserved=true&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Rezervované</a>
                        <?php endif; ?>   
                        
                        <?php if ($wheel_infos["sold"]): ?>
                            <a class="btn-green" href="./after-update-wheel-advert.php?sold=false&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Dostupné</a>
                            <?php else: ?>
                                <a class="btn" href="./after-update-wheel-advert.php?sold=true&wheel_id=<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">Predané</a>
                        <?php endif; ?> 

                    </div>
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
                
                    <h2><?= htmlspecialchars(number_format($wheel_infos["wheel_price"],0,","," ")) ?> &#8364;</h2>
                    
                </div>

            </article>

        </section>

    </main>
    
    <?php require "../assets/footer.php" ?>
    
    <script src="../js/header.js"></script>                   
</body>
</html>
