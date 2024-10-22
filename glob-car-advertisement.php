<?php
require "./classes/Database.php";
require "./classes/Car.php";


// database connection
$database = new Database();
$connection = $database->connectionDB();

// get actual page nr or create pagenr 1 if is not with method GET
if (isset($_GET["page_nr"]) and is_numeric($_GET["page_nr"])){
    $actual_page_nr = $_GET["page_nr"];
} else {
    $actual_page_nr = 1;
}

// how many advertisement will be printed on website
$show_nr_of_advert = 5;


if (isset($_GET["car_history"]) and is_numeric($_GET["car_history"])){
    // active_advertisement means show active advetisement or show history
    $active_advertisement = $_GET["car_history"];

    // get all car info according selected page nr 
    $cars_advertisements = Car::getAllCarsAdvertisement($connection, $active_advertisement, (($actual_page_nr - 1) * $show_nr_of_advert), $show_nr_of_advert, "car_id, car_brand, car_model, year_of_manufacture, past_km, fuel_type, car_description, car_price, reserved, sold, car_image");
} else {
    // active_advertisement means show active advetisement or show history
    $active_advertisement = 1;

    // get all car info according selected page nr 
    $cars_advertisements = Car::getAllCarsAdvertisement($connection, $active_advertisement, (($actual_page_nr - 1) * $show_nr_of_advert), $show_nr_of_advert, "car_id, car_brand, car_model, year_of_manufacture, past_km, fuel_type, car_description, car_price, reserved, sold, car_image");
}

// number of all active or historical advertisemment 
$number_of_advert = Car::countAllCarsAdvertisement($connection, $active_advertisement);

// number of all pages for advertisement according how many advertisements will 
// be printed on website
$number_of_pages = ceil($number_of_advert / $show_nr_of_advert);

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inzeráty autá</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <!-- ICONS MENU -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <!-- ICONS MENU -->

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/cars.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./query/advertisement-query.css">

</head>
<body>

    <?php require "./assets/header.php" ?>

    <main>

        <h1>Ponuka automobilov</h1>

        <?php if ($number_of_advert != 0 || $cars_advertisements != null): ?>

        <section class="cars-menu">

            <?php foreach ($cars_advertisements as $one_car): ?>

            <!-- advertisement part -->
            <!-- if active advertisment is false added car history to HREF -->
            <a href="./glob-car-profil.php?car_id=<?= htmlspecialchars($one_car["car_id"]) ?>&active_advertisement=<?= htmlspecialchars($active_advertisement) ?>"> 
            <article class="car-advertisement advertisement">

            <!-- stamp for sold and reserved  -->
                <?php if ($one_car["reserved"]): ?>
                    <div class="advert-label">
                        Rezervované
                    </div>
                <?php elseif ($one_car["sold"]): ?>
                    <div class="advert-label">
                        Predané
                    </div>
                <?php endif; ?>
            <!-- stamp for sold and reserved  -->

            <!--image part of advertisement  -->
                <?php if ($one_car["car_image"] != "no-photo-car.jpg"): ?>

                    <div class="car-picture picture" style="
                                    background: url(./uploads/cars/<?= htmlspecialchars($one_car["car_id"]) ?>/<?= htmlspecialchars($one_car["car_image"]) ?>);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>
                
                <?php else: ?>
                    <div class="car-picture picture" style="
                                    background: url(./img/no-photo-car/no-photo-car.jpg);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    ">
                    </div>

                <?php endif ?>
            <!--image part of advertisement  -->

            <!-- infos part of advertisement -->
                <div class="basic-car-info info">

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
            </a>    
            <!-- infos part of advertisement -->
            <?php endforeach ?>

            <!-- advertisement part -->      
             
            <!-- pagination part -->

            <div class="pagination">


            <!-- pagination part if max pages number are 5 -->
            <?php if ($number_of_pages < 6): ?>

                <!-- arrow left -->
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "disabled" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $actual_page_nr - 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><</a>

                <!-- pages -->
                <?php for ($i = 0; $i < $number_of_pages; $i++): ?>
                    <a class="page-nr <?php echo ($actual_page_nr == $i + 1) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $i + 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $i + 1 ?></a>
                <?php endfor; ?>
                
                <!-- arrow right -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "disabled" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $actual_page_nr + 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>">></a>

            <!-- pagination part if max pages number are 5 -->        

            <!-- pagination part if max pages number are more than 5 -->
            <?php else: ?>

                <!-- arrow left -->
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "disabled" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $actual_page_nr - 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><</a>

                <!-- first page -->
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= 1 ?></a>


                <!-- pages from second page until max page (without max page) -->
                <!-- system for pages show actual page and one page before and one page after -->
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <?php if ($actual_page_nr + 2 < $number_of_pages): ?>

                        <!-- if actual page is 2 print pages 2, 3, 4 -->
                        <?php if ($actual_page_nr == 2): ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + $actual_page_nr) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $i + $actual_page_nr ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $i + $actual_page_nr ?></a>

                        <!-- if actual page is one print page 2, 3, 4 -->
                        <?php elseif ($actual_page_nr < 2): ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + 1 + $actual_page_nr) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $i + 1 + $actual_page_nr ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $i + 1 + $actual_page_nr ?></a>

                        <!-- print one page before actual, actual page and one page after actual page -->
                        <?php else: ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + $actual_page_nr - 1) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $i + $actual_page_nr - 1?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $i + $actual_page_nr - 1 ?></a>
                        <?php endif; ?>
                    
                    <?php else: ?>
                        <!-- printed still last three pages before last page -->
                        <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages - 3 + $i) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $number_of_pages - 3 + $i ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $number_of_pages - 3 + $i ?></a>
                    
                    <?php endif; ?>

                <?php endfor; ?>

                <!-- system for pages show actual page and one page before and one page after -->
                
                <!-- max page - last page -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "actual-page" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $number_of_pages ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>"><?= $number_of_pages ?></a>
                
                <!-- arrow right -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "disabled" : ''; ?>" href="./glob-car-advertisement.php?page_nr=<?= $actual_page_nr + 1 ?><?php echo (!$active_advertisement) ? "&car_history=0" : ''; ?>">></a>
            
            <!-- pagination part if max pages number are more than 5 -->
            <?php endif; ?>

            </div>

            <!-- pagination part -->     

        </section>

        

        <?php endif ?>


        

    </main>
    
    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>     
    <!-- <script src="./js/header-nav-visibility.js"></script>               -->
</body>
</html>


