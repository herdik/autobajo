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

                <img src="../img/rim.jpg" alt="">

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

            <article class="images">
            
                <label for="car-image" id="choose-img-text">Vybrať</label>
                <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                    <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Doplniť galériu</p>
                <?php else: ?>
                    <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                <?php endif; ?>
                
                <input id="car-image" type="file" name="wheel_image" multiple="multiple">
                    
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
    <script src="../js/show-image-name-car-advert.js"></script>  
    <script src="../js/header.js"></script>                   
</body>
</html>
