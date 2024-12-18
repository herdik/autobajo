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

// control if user choose image from image gallery 
$image_sequence = null;

$wheel_brands = Wheel::getAllWheelsInfo($connection, 'wheel_brand', '%');
$wheel_colors = Wheel::getAllWheelsInfo($connection, 'wheel_color', '%');
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia diskov</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/reg-form-wheel.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/reg-form-query.css">

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Registrácia diskov</h1>

            <form id="registration-form" action="after-reg-add-wheel.php" method="POST" enctype="multipart/form-data">

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                        <label for="wheel-category">Kategória:</label>
                        <select name="wheel_category" id="wheel-category" onfocus='this.size=2;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="Hliníkové">Hliníkové</option>
                            <option value="Plechové">Plechové</option>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <label for="wheels-brand">Značka:</label>
                        <input type="text" id="wheels-brand" name="wheel_brand" placeholder="Zadaj/Vyber" list="wheels_brand" autocomplete="off" value="" required />
                        <datalist id="wheels_brand">
                        
                            <?php foreach($wheel_brands as $wheel_brand): ?>
                                <option><?= htmlspecialchars($wheel_brand); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <label for="model-wheels">Model:</label>
                        <input type="text" id="model-wheels" name="wheel_model" placeholder="Zadaj/Vyber" list="wheels-model" autocomplete="off" value="" required />
                        <datalist id="wheels-model">
                        
                            <!-- <option data-value=""></option> -->
                    
                        </datalist>
                    </div>

                    
                    <div class="basic-car-info">
                    <label for="wheel-average">Priemer:</label>
                        <select name="wheel_average" id="wheel-average" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 10; $i < 24; $i++): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                        </select>
                    </div>

                    <?php require "../assets/array-reg-form-wheels.php"; ?>
                    <div class="basic-car-info">
                        <label for="spacing">Rozteč</label>
                        <select name="spacing" id="spacing" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php foreach ($spacings as $spacing): ?>
                            <option value="<?= htmlspecialchars($spacing); ?>"><?= htmlspecialchars($spacing); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="basic-car-info">
                    <label for="width">Šírka</label>
                    <select name="width" id="width" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 4.5; $i < 13.5; $i+=0.5): ?>
                        <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-car-info">   
                    <label for="et">ET</label>
                    <select name="et" id="et" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 0; $i <= 100; $i++): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="answerWheelsColor">Farba disku:</label>
                        <input type="text" id="answerWheelsColor" name="wheel_color" placeholder="Zadaj/Vyber" list="wheels-color" autocomplete="off" value="" required />
                        <datalist id="wheels-color">
                        
                            <?php foreach($wheel_colors as $wheel_color): ?>
                                <option><?= htmlspecialchars($wheel_color); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">  
                        <label for="price">Cena disku:</label> 
                        <input id="price" type="number" name="wheel_price" placeholder="Zadaj" required>
                    </div>

                    <div class="basic-car-info">  
                        <span>Opis disku</span>
                        <textarea name="wheel_description" id="tire-description" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div> 

                    <div class="basic-car-info">
                        <label for="image-name" id="choose-img-text">Vybrať</label>
                        <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                            <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Titulný obrázok</p>
                        <?php else: ?>
                            <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                        <?php endif; ?>
                        
                        <input id="image-name" type="file" name="wheel_image">
                    </div>
                </div> 
                

                <div class="confirm-btn">
                    <input class="btn" type="submit" name="submit" value="Pridať">
                </div>    
            </form>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../js/header.js"></script> 
    <script src="../js/show-image-name.js"></script>       
    <script src="../js/reg-form.js"></script>  
    <script src="../js/select-wheel-model.js"></script>  
    <script src="../js/loading.js"></script>        
    <script src="../js/confirm-uploading.js"></script>         
        

</body>
</html>


