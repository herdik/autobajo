<?php

require "../classes/Database.php";
require "../classes/Tire.php";

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


if ((isset($_GET["tire_id"]) and is_numeric($_GET["tire_id"])) and (isset($_GET["active_advertisement"]) and is_numeric($_GET["active_advertisement"]))){
    $tire_infos = Tire::getTire($connection, $_GET["tire_id"]);

    // active true means aktice advertisement active false/0 means advertisement in history
    $active_advertisement = $_GET["active_advertisement"];
} else {
    $tire_infos = null;
    $active_advertisement = null;
}

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
    <link rel="stylesheet" href="../css/tire-profil.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="advertisement-tire">
            
            <article class="heading">

                <?php if ($tire_infos["tire_image"] === "no-photo-car.jpg"): ?>
                    <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                <?php else: ?>
                    <img src="../uploads/tires/<?= htmlspecialchars($tire_infos["tire_id"]) ?>/<?= htmlspecialchars($tire_infos["tire_image"]) ?>" alt="">
                <?php endif; ?>

                <?php if ($tire_infos["reserved"]): ?>
                    <div class="advert-label">
                        Rezervované
                    </div>
                <?php elseif ($tire_infos["sold"]): ?>
                    <div class="advert-label">
                        Predané
                    </div>
                <?php elseif (!$tire_infos["active"]): ?>
                    <div class="advert-label">
                        Neaktívny
                    </div>
                <?php endif; ?>

                <div class="main-tire-info">

                    <div class="tire-brand">
                        <h2 class="tire-name"><?= htmlspecialchars($tire_infos["tire_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($tire_infos["tire_model"]) ?></h3>
                    </div>

                    <div class="tire-description">
                        <h2>Typ/Obdobie: <?= htmlspecialchars($tire_infos["type"]) ?></h2>
                    </div>

                    <div class="tire-infos">

                        <div class="tire year">
                            <span class="sub-heading">Rok výroby</span>
                            <span><?= htmlspecialchars($tire_infos["year_of_manufacture"]) ?></span>
                        </div>

                        <div class="tire category">
                            <span class="sub-heading">Kategória</span>
                            <span><?= htmlspecialchars($tire_infos["tire_category"]) ?></span>
                        </div>

                        <div class="tire width">
                            <span class="sub-heading">Šírka</span>
                            <span><?= htmlspecialchars($tire_infos["width"]) ?></span>
                        </div>
                    </div>

                    <div class="tire-infos">
                        <div class="tire height">
                            <span class="sub-heading">Výška</span>
                            <span><?= htmlspecialchars($tire_infos["height"]) ?></span>
                        </div>
                        <div class="tire average">
                            <span class="sub-heading">Priemer</span>
                            <span><?= htmlspecialchars($tire_infos["construction"]) .  htmlspecialchars($tire_infos["average"])?></span>
                        </div>
                        <div class="tire index">
                            <span class="sub-heading">H/R index</span>
                            <span><?= htmlspecialchars($tire_infos["weight_index"]) . htmlspecialchars($tire_infos["speed_index"])?></span>
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
                        <a class="btn" href="./edit-tire-advertisement.php?tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Upraviť</a>
                        <a class="btn" href="./after-update-tire-advert.php">Galéria</a>

                        <?php if ($tire_infos["active"]): ?>
                            <a class="btn" href="./after-update-tire-advert.php?active=false&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Dektivovať</a>
                        <?php else: ?>
                            <a class="btn-green" href="./after-update-tire-advert.php?active=true&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Aktivovať</a>
                        <?php endif; ?>


                        <?php if ($active_advertisement): ?>
                            <?php if ($tire_infos["reserved"]): ?>
                                <a class="btn-green" href="./after-update-tire-advert.php?reserved=false&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Dostupné</a>
                                <?php else: ?>
                                    <a class="btn" href="./after-update-tire-advert.php?reserved=true&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Rezervované</a>
                            <?php endif; ?>   
                            
                            <?php if ($tire_infos["sold"]): ?>
                                <a class="btn-green" href="./after-update-tire-advert.php?sold=false&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Dostupné</a>
                                <?php else: ?>
                                    <a class="btn" href="./after-update-tire-advert.php?sold=true&tire_id=<?= htmlspecialchars($tire_infos["tire_id"]) ?>">Predané</a>
                            <?php endif; ?> 
                        <?php endif; ?>

                    </div>
                </div>


            </article>

            <article class="tires-condition part">
                <h2>Popis pneumatiky </h2> 

                <div class="check box">
                    <p><?= htmlspecialchars($tire_infos["tire_description"]) ?></p>
                    
                </div>
            </article>

            <article class="tires-price part">
                <h2>Cena pneumatiky</h2> 

                <div class="tire-price box">
                
                    <h2><?= htmlspecialchars(number_format($tire_infos["tire_price"],0,","," ")) ?> &#8364;</h2>
                    
                </div>

            </article>

        </section>

    </main>
    
    <?php require "../assets/footer.php" ?>
    
    <script src="../js/header.js"></script>                   
</body>
</html>
