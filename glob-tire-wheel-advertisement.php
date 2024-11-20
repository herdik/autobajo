<?php
require "./classes/Database.php";
require "./classes/TireWheel.php";


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

if (isset($_GET["tire_wheel_history"]) and is_numeric($_GET["tire_wheel_history"])){
    // active_advertisement means show active advetisement or show history
    $active_advertisement = $_GET["tire_wheel_history"];

    // get all tire info according selected page nr 
    $tires_wheel_advertisements = TireWheel::getAllTireWheelsAdvertisement($connection, $active_advertisement, (($actual_page_nr - 1) * $show_nr_of_advert), $show_nr_of_advert, "tire_wheel_id, tire_brand, tire_model, type, tire_width, height, construction, average, wheel_brand, wheel_model, wheel_width, wheel_average, spacing, et, wheel_color, price, reserved, sold, tire_wheel_image");
} else {
    // active_advertisement means show active advetisement or show history
    $active_advertisement = 1;

    // get all tire info according selected page nr 
    $tires_wheel_advertisements = TireWheel::getAllTireWheelsAdvertisement($connection, $active_advertisement, (($actual_page_nr - 1) * $show_nr_of_advert), $show_nr_of_advert, "tire_wheel_id, tire_brand, tire_model, type, tire_width, height, construction, average, wheel_brand, wheel_model, wheel_width, wheel_average, spacing, et, wheel_color, price, reserved, sold, tire_wheel_image");
}

// number of all active or historical advertisemment 
$number_of_advert = TireWheel::countAllTireWheelsAdvertisement($connection, $active_advertisement);

// number of all pages for advertisement according how many advertisements will 
// be printed on website
$number_of_pages = ceil($number_of_advert / $show_nr_of_advert);

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inzeráty pneumatiky na diskoch</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/tires-wheels.css">
    <link rel="stylesheet" href="./query/global-header-query.css">
    <link rel="stylesheet" href="./query/advertisement-query.css">

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "./assets/header.php" ?>

    <main>

    <h1>Ponuka pneumatík na diskoch</h1>

<?php if ($number_of_advert != 0 || $tires_wheel_advertisements != null): ?>

<section class="tires-menu">

    <?php foreach ($tires_wheel_advertisements as $one_tire_wheel): ?>

    <!-- advertisement part -->
    <!-- if active advertisment is false added tire history to HREF -->
    
    <a href="./glob-tire-wheel-profil/<?= htmlspecialchars($one_tire_wheel["tire_wheel_id"]) ?>/<?= htmlspecialchars($active_advertisement) ?>"> 
    <article class="tire-wheel-advertisement advertisement">

    <!-- stamp for sold and reserved  -->
        <?php if ($one_tire_wheel["reserved"]): ?>
            <div class="advert-label">
                Rezervované
            </div>
        <?php elseif ($one_tire_wheel["sold"]): ?>
            <div class="advert-label">
                Predané
            </div>
        <?php endif; ?>
    <!-- stamp for sold and reserved  -->

    <!--image part of advertisement  -->  
        <?php if ($one_tire_wheel["tire_wheel_image"] != "no-photo-car.jpg"): ?>

            <div class="tire-picture advert-picture" style="
                            background: url(./uploads/tireswithwheels/<?= htmlspecialchars($one_tire_wheel["tire_wheel_id"]) ?>/<?= htmlspecialchars($one_tire_wheel["tire_wheel_image"]) ?>);
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            ">
            </div>
        
        <?php else: ?>
            <div class="tire-picture advert-picture" style="
                            background: url(./img/no-photo-car/no-photo-car.jpg);
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            ">
            </div>

        <?php endif ?>
        <!--image part of advertisement  -->

                <!-- infos part of advertisement -->
                <div class="basic-tire-info basic-advert-infos">
                    <div class="tire-wheel-part first">
                        <div class="tire-brand">
                            <h2 class="heading"><?= htmlspecialchars($one_tire_wheel["tire_brand"]) ?></h2>
                            <h3 class="model"><?= htmlspecialchars($one_tire_wheel["tire_model"]) ?></h3>
                        </div>

                        <div class="tire-type">
                            <h2>Typ/Obdobie:</h2>
                            <span class="product-type"><?= htmlspecialchars($one_tire_wheel["type"]) ?></span>
                        </div>

                        <div class="tire-infos advert-infos">

                            <div class="tire width main-advert">
                                <span class="sub-heading text">Šírka</span>
                                <span class="sub-heading material-symbols-outlined set-icon">format_letter_spacing</span>
                                <span><?= htmlspecialchars($one_tire_wheel["tire_width"]) ?></span>
                            </div>

                            <div class="tire height main-advert">
                                <span class="sub-heading text">Výška</span>
                                <span class="sub-heading material-symbols-outlined set-icon">expand</span>
                                <span><?= htmlspecialchars($one_tire_wheel["height"]) ?></span>
                            </div>

                            <div class="tire average main-advert">
                                <span class="sub-heading text">Priemer</span>
                                <span class="sub-heading material-symbols-outlined set-icon">hide_source</span>
                                <span><?= htmlspecialchars($one_tire_wheel["construction"]) . htmlspecialchars($one_tire_wheel["average"])?></span>
                            </div>
                
                        </div>
                        <div class="product">
                            <img src="./img/icon-tire.png" alt="tire" alt="">
                        </div>
                    </div>

                    <div class="tire-wheel-part">
                        <div class="tire-brand">
                            <h2 class="heading"><?= htmlspecialchars($one_tire_wheel["wheel_brand"]) ?></h2>
                            <h3 class="model"><?= htmlspecialchars($one_tire_wheel["wheel_model"]) ?></h3>
                        </div>

                        <div class="tire-type">
                            <h2>Farba:</h2>
                            <span class="product-type"><?= htmlspecialchars($one_tire_wheel["wheel_color"]) ?></span>
                        </div>

                        <div class="tire-infos advert-infos">

                        <div class="tire year main-advert">
                                <span class="sub-heading text">Šírka</span>
                                <span class="sub-heading material-symbols-outlined set-icon">format_letter_spacing</span>
                                <span><?= htmlspecialchars($one_tire_wheel["wheel_width"]) ?></span>
                            </div>

                            <div class="tire average main-advert">
                                <span class="sub-heading text">Priemer</span>
                                <span class="sub-heading material-symbols-outlined set-icon">hide_source</span>
                                <span><?= htmlspecialchars($one_tire_wheel["wheel_average"])?></span>
                            </div>

                            <div class="tire spacing main-advert">
                                <span class="sub-heading text">Rozteč</span>
                                <span class="sub-heading material-symbols-outlined set-icon">adjust</span>
                                <span><?= htmlspecialchars($one_tire_wheel["spacing"]) ?></span>
                            </div>

                            <div class="tire et main-advert">
                                <span class="sub-heading text">ET</span>
                                <span class="sub-heading material-symbols-outlined set-icon">ET</span>
                                <span><?= htmlspecialchars($one_tire_wheel["et"])?></span>
                            </div>
                
                
                        </div>
                        <div class="product">
                            <img src="./img/icon-wheel.png" alt="wheel" alt="">
                        </div>
                    </div>
                    <div class="tire-price">
                        <h2><?= htmlspecialchars(number_format($one_tire_wheel["price"],0,","," ")) ?> &#8364; s DPH</h2>
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
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "disabled" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $actual_page_nr - 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><</a>

                <!-- pages -->
                <?php for ($i = 0; $i < $number_of_pages; $i++): ?>
                    <a class="page-nr <?php echo ($actual_page_nr == $i + 1) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $i + 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $i + 1 ?></a>
                <?php endfor; ?>
                
                <!-- arrow right -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "disabled" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $actual_page_nr + 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>">></a>

            <!-- pagination part if max pages number are 5 -->        

            <!-- pagination part if max pages number are more than 5 -->
            <?php else: ?>

                <!-- arrow left -->
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "disabled" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $actual_page_nr - 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><</a>

                <!-- first page -->
                <a class="page-nr <?php echo ($actual_page_nr == 1) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= 1 ?></a>


                <!-- pages from second page until max page (without max page) -->
                <!-- system for pages show actual page and one page before and one page after -->
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <?php if ($actual_page_nr + 2 < $number_of_pages): ?>

                        <!-- if actual page is 2 print pages 2, 3, 4 -->
                        <?php if ($actual_page_nr == 2): ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + $actual_page_nr) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $i + $actual_page_nr ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $i + $actual_page_nr ?></a>

                        <!-- if actual page is one print page 2, 3, 4 -->
                        <?php elseif ($actual_page_nr < 2): ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + 1 + $actual_page_nr) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $i + 1 + $actual_page_nr ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $i + 1 + $actual_page_nr ?></a>

                        <!-- print one page before actual, actual page and one page after actual page -->
                        <?php else: ?>
                            <a class="page-nr <?php echo ($actual_page_nr == $i + $actual_page_nr - 1) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $i + $actual_page_nr - 1?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $i + $actual_page_nr - 1 ?></a>
                        <?php endif; ?>
                    
                    <?php else: ?>
                        <!-- printed still last three pages before last page -->
                        <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages - 3 + $i) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $number_of_pages - 3 + $i ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $number_of_pages - 3 + $i ?></a>
                    
                    <?php endif; ?>

                <?php endfor; ?>

                <!-- system for pages show actual page and one page before and one page after -->
                
                <!-- max page - last page -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "actual-page" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $number_of_pages ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>"><?= $number_of_pages ?></a>
                
                <!-- arrow right -->
                <a class="page-nr <?php echo ($actual_page_nr == $number_of_pages) ? "disabled" : ''; ?>" href="./glob-tire-wheel-advertisement.php?page_nr=<?= $actual_page_nr + 1 ?><?php echo (!$active_advertisement) ? "&tire_wheel_history=0" : ''; ?>">></a>
            
            <!-- pagination part if max pages number are more than 5 -->
            <?php endif; ?>

            </div>

            <!-- pagination part -->
        
        </section>

        <?php endif ?>
        

    </main>
    
    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>    
    <script src="./js/loading.js"></script>  
    <script src="./js/check-cookie.js"></script>         
</body>
</html>


