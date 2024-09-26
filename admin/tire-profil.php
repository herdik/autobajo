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


if (isset($_GET["tire_id"]) and is_numeric($_GET["tire_id"])){
    $tire_infos = Tire::getTire($connection, $_GET["tire_id"]);
} else {
    $tire_infos = null;
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
    <link rel="stylesheet" href="../css/tire-profil.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="advertisement-tire">
            
            <article class="heading">

                <img src="../img/tires.jpg" alt="tires.jpg">

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

            <article class="images">
            
                <label for="car-image" id="choose-img-text">Vybrať</label>
                <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                    <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Doplniť galériu</p>
                <?php else: ?>
                    <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                <?php endif; ?>
                
                <input id="car-image" type="file" name="tire_image" multiple="multiple">
                    
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
    <script src="../js/show-image-name-car-advert.js"></script>  
    <script src="../js/header.js"></script>                   
</body>
</html>
