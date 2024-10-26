<?php

require "../classes/Database.php";
require "../classes/CarImage.php";

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


if (isset($_GET["car_id"]) and is_numeric($_GET["car_id"])){
    $car_id = $_GET["car_id"];
    $car_images = CarImage::getAllCarsImages($connection, $car_id);
} else {
    $car_id = null;
    $car_images = null;
}

// control if user choose image from image gallery 
$image_sequence = null;
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galéria</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- ICONS MENU -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <!-- ICONS MENU -->

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/gallery.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/gallery-query.css">

</head>
<body>
    <?php require "../assets/admin-header.php" ?>
    <main>
    
        
        <h2>Pridať obrázky do galérie</h2>
        <section class="add-new-images">
            <form id="registration-form-images" action="./after-add-del-title-car-img-gallery.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">

                <div class="add-image gallery">
                    
                    <label for="image-name-gallery" id="choose-img-text">Vybrať</label>
                    <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                        <p id="picture-titel" style="opacity:1; color:white;">Vybrané obrázky: 0</p>
                    <?php else: ?>
                        <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                    <?php endif; ?>
                    
                    <!-- add images to gallery -->
                    <input type="hidden" name="gallery" value="true">
                    <input id="image-name-gallery" name="car_image[]" class="gallery-img" type="file"  multiple required>
                    <input class="btn" id="btn-gall" type="submit" name="submit" value="Pridať">

                    

                </div>
            </form>
        </section>
        <h2 class="title-image">Vybrať nový titulný obrázok</h2>
        <section class="add-new-images">
            <form id="registration-form-image" action="./after-add-del-title-car-img-gallery.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">

                <div class="add-image title">
                    
                    <label for="image-name-title" id="choose-img-text">Vybrať</label>
                    <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                        <p id="picture-titel" style="opacity:1; color:white;">Vybrané obrázky: 0</p>
                    <?php else: ?>
                        <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                    <?php endif; ?>
                    
                    <!-- title img -->
                    <input type="hidden" name="gallery" value="false">

                    <input id="image-name-title" type="file" name="car_image" required>
                    <input class="btn" id="btn-title" type="submit" name="submit" value="Pridať">

                </div>
            </form>
        </section>
        <section class="admin-gallery">
        
                
                <div class="add-delete">
                           
                    <div class="add-part">
                        <div class="button-info">
                            <h3>Vybrať titulný obrázok z Galérie</h3> 
                        </div>
                        
                        <input class="btn" id="image-name-add"type="submit" name="add" value="Pridať">

                        <form class="edit-form" action="./after-add-del-title-car-img-gallery.php" method="POST">

                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="gallery" value="false">
                            <input type="hidden" id="image-id-add" name="image_id" value="">

                            <input class="btn" id="image-submit-add" type="submit" name="submit" value="Potvrdiť">

                        </form> 
                    </div>

                    <div class="deleted-part">
                        <div class="button-info">
                            <h3>Odstrániť obrázok z Galérie</h3>
                        </div>
                        <input class="btn" id="image-name-delete"type="submit" name="delete" value="Vymazať">

                        <form class="edit-form" id="delete-form" method="POST">

                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="gallery" value="true">
                            <input type="hidden" id="image-id-delete" name="image_id[]" value="">

                            <input class="btn" id="image-submit-delete" type="submit" name="submit" value="Potvrdiť">

                        </form> 

                    </div>

                </div>
          
        </section>

        <h1 class="error-message hide-error">Počet chybných hlásení: </h1>               
        <h1>Galéria</h1>
        <section class="dashboard-menu">
         

            <article class="images-part">
               
                    <?php foreach ($car_images as $car_image): ?>
                    <div class="div-menu-images">
                        
                        <input type="hidden" name="image_id" value="<?= htmlspecialchars($car_image["image_id"]) ?>">

                        <?php if ($car_image["image_name"] === "no-photo-car.jpg"): ?>

                            <img src="../img/no-photo-car/no-photo-car.jpg" alt="no-photo-car">
                        <?php else: ?>
                            
                            <img src="../uploads/cars/<?= htmlspecialchars($car_id) ?>/<?= htmlspecialchars($car_image["image_name"]) ?>" alt="">
                        <?php endif; ?>
                    
                    </div>
                    <?php endforeach; ?>

                    
               
            </article>

            
        </section>
        
        
    </main>
    
    <?php require "../assets/footer.php" ?>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../js/header.js"></script>    
    <script src="../js/show-image-info-advertisement.js"></script>   
    <script src="../js/reg-form.js"></script>   
    <script src="../js/choose-car-image-gallery.js"></script>   
            
</body>
</html>


