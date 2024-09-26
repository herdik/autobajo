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


// database connection
$database = new Database();
$connection = $database->connectionDB();

$wheels_advertisements = Wheel::getAllWheelsAdvertisement($connection, "wheel_id, wheel_brand, wheel_model, wheel_average, spacing, width, et, wheel_color, wheel_image, wheel_price");

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
    <link rel="stylesheet" href="../css/wheels.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Ponuka diskov</h1>

        <?php if ($wheels_advertisements != null): ?>

        <section class="wheels-menu">

            <?php foreach ($wheels_advertisements as $one_wheel): ?>

            <a href="./wheel-profil.php?wheel_id=<?= htmlspecialchars($one_wheel["wheel_id"]) ?>"> 
            <article class="wheel-advertisement">
              
                <?php if ($one_wheel["wheel_image"] != "no-photo-car.jpg"): ?>

                    <div class="wheel-picture" style="
                                    background: url(../uploads/wheels/<?= htmlspecialchars($one_wheel["wheel_id"]) ?>/<?= htmlspecialchars($one_wheel["wheel_image"]) ?>);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>
                
                <?php else: ?>
                    <div class="wheel-picture" style="
                                    background: url(../img/no-photo-car/no-photo-car.jpg);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>

                <?php endif ?>

                <div class="basic-wheel-info">

                    <div class="wheel-brand">
                        <h2 class="heading"><?= htmlspecialchars($one_wheel["wheel_brand"]) ?></h2>
                        <h3 class="model"><?= htmlspecialchars($one_wheel["wheel_model"]) ?></h3>
                    </div>

                    <div class="wheel-color">
                        <h2>Farba:</h2>
                        <span class="product-color"><?= htmlspecialchars($one_wheel["wheel_color"]) ?></span>
                    </div>

                    <div class="wheel-infos">

                        <div class="wheel year">
                            <span class="sub-heading">Šírka</span>
                            <span><?= htmlspecialchars($one_wheel["width"]) ?></span>
                        </div>

                        <div class="wheel average">
                            <span class="sub-heading">Priemer</span>
                            <span><?= htmlspecialchars($one_wheel["wheel_average"])?></span>
                        </div>

                        <div class="wheel spacing">
                            <span class="sub-heading">Rozteč</span>
                            <span><?= htmlspecialchars($one_wheel["spacing"]) ?></span>
                        </div>

                        <div class="wheel et">
                            <!-- <i class="fa-solid fa-gas-pump"></i> -->
                            <span class="sub-heading">ET</span>
                            <span><?= htmlspecialchars($one_wheel["et"])?></span>
                        </div>
            
            
                    </div>

                    <div class="wheel-price">
                        <h2><?= htmlspecialchars(number_format($one_wheel["wheel_price"],0,","," ")) ?> &#8364;</h2>
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


