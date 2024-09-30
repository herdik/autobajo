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


// database connection
$database = new Database();
$connection = $database->connectionDB();

if (isset($_GET["tire_history"]) and is_numeric($_GET["tire_history"])){
    // active_advertisement means show active advetisement or show history
    $active_advertisement = $_GET["tire_history"];
    $tires_advertisements = Tire::getAllTiresAdvertisement($connection, $active_advertisement, "tire_id, tire_brand, tire_model, type, width, height, construction, average, tire_price, reserved, sold, tire_image");
} else {
    // active_advertisement means show active advetisement or show history
    $active_advertisement = 1;
    $tires_advertisements = Tire::getAllTiresAdvertisement($connection, $active_advertisement, "tire_id, tire_brand, tire_model, type, width, height, construction, average, tire_price, reserved, sold, tire_image");
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
    <link rel="stylesheet" href="../css/tires.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Ponuka pneumatík</h1>

        <?php if ($tires_advertisements != null): ?>

        <section class="tires-menu">

            <?php foreach ($tires_advertisements as $one_tire): ?>

            <a href="./tire-profil.php?tire_id=<?= htmlspecialchars($one_tire["tire_id"]) ?>&active_advertisement=<?= htmlspecialchars($active_advertisement) ?>"> 
            <article class="tire-advertisement">

                <?php if ($one_tire["reserved"]): ?>
                    <div class="advert-label">
                        Rezervované
                    </div>
                <?php elseif ($one_tire["sold"]): ?>
                    <div class="advert-label">
                        Predané
                    </div>
                <?php endif; ?>
              
                <?php if ($one_tire["tire_image"] != "no-photo-car.jpg"): ?>

                    <div class="tire-picture" style="
                                    background: url(../uploads/tires/<?= htmlspecialchars($one_tire["tire_id"]) ?>/<?= htmlspecialchars($one_tire["tire_image"]) ?>);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>
                
                <?php else: ?>
                    <div class="tire-picture" style="
                                    background: url(../img/no-photo-car/no-photo-car.jpg);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>

                <?php endif ?>

                <div class="basic-tire-info">

                    <div class="tire-brand">
                        <h2 class="heading"><?= htmlspecialchars($one_tire["tire_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($one_tire["tire_model"]) ?></h3>
                    </div>

                    <div class="tire-type">
                        <h2>Typ/Obdobie:</h2>
                        <span class="product-type"><?= htmlspecialchars($one_tire["type"]) ?></span>
                    </div>

                    <div class="tire-infos">

                        <div class="tire width">
                            <!-- <i class="fa-solid fa-hourglass-start"></i> -->
                            <span class="sub-heading">Šírka</span>
                            <span><?= htmlspecialchars($one_tire["width"]) ?></span>
                        </div>

                        <div class="tire height">
                            <span class="sub-heading">Výška</span>
                            <span><?= htmlspecialchars($one_tire["height"]) ?></span>
                        </div>

                        <div class="tire average">
                            <!-- <i class="fa-solid fa-gas-pump"></i> -->
                            <span class="sub-heading">Priemer</span>
                            <span><?= htmlspecialchars($one_tire["construction"]) . htmlspecialchars($one_tire["average"])?></span>
                        </div>
            
            
                    </div>

                    <div class="tire-price">
                        <h2><?= htmlspecialchars(number_format($one_tire["tire_price"],0,","," ")) ?> &#8364;</h2>
                    </div>

                    
                </div>
                
            </article>
            </a>        
            
            <?php endforeach ?>
        
        </section>

        <?php endif ?>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script>            
</body>
</html>


