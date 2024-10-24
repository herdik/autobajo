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

// control if user choose image from image gallery 
$image_sequence = null;

$tire_brands = Tire::getAllTiresInfo($connection, 'tire_brand', '%');
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia pneumatík</title>

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
    <link rel="stylesheet" href="../css/reg-form-tire.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/reg-form-query.css">

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Registrácia pneumatík</h1>

            <form id="registration-form" action="after-reg-add-tire.php" method="POST" enctype="multipart/form-data">

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                        <label for="tire-category">Kategória:</label>
                        <select name="tire_category" id="tire-category" onfocus='this.size=3;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="Osobné">Osobné</option>
                            <option value="SUV">SUV</option>
                            <option value="Nákladné">Nákladné</option>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <label for="answerTiresBrand">Značka:</label>
                        <input type="text" id="tire-brand" name="tire_brand" placeholder="Zadaj/Vyber" list="tires_brand" autocomplete="off" value="" required />
                        <datalist id="tires_brand">
                        
                            <?php foreach($tire_brands as $tire_brand): ?>
                                <option><?= htmlspecialchars($tire_brand); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <label for="tires-model">Model:</label>
                        <input type="text" id="model-tires" name="tire_model" placeholder="Zadaj/Vyber" list="tires-model" autocomplete="off" value="" required />
                        <datalist id="tires-model">
                        
                            <!-- <option data-value=""></option> -->
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">
                    <label for="type">Obdobie:</label>
                        <select name="type" id="type" onfocus='this.size=3;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="Letné">Letné</option>
                            <option value="Zimné">Zimné</option>
                            <option value="Celoročné">Celoročné</option>
                        </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="year">Rok výroby</label>
                        <input id="year" type="number" name="year_of_manufacture" value="<?= htmlspecialchars(date("Y")); ?>" step="1" required>
                    </div>

                    <div class="basic-car-info">
                    <label for="with">Šírka</label>
                    <select name="width" id="width" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                        <option value="6.4">6.4</option>
                        <?php for ($i = 6.5; $i <= 17.5; $i+=0.5): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                    <?php for ($i = 27; $i <= 39; $i++): ?>
                        <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>

                    <?php for ($i = 115; $i <= 455; $i+=10): ?>
                        <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php if ($i === 235 || $i === 275 || $i === 295 || $i === 335 || $i === 435): ?>
                            <option value="<?= htmlspecialchars($i+5); ?>"><?= htmlspecialchars($i+5); ?></option>
                        <?php elseif ($i == 315): ?>
                            <option value="<?= htmlspecialchars($i+3); ?>"><?= htmlspecialchars($i+3); ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <option value="460">460</option>
                    <option value="480">480</option>
                    <option value="495">495</option>
                    <option value="500">500</option>
                    <option value="525">525</option>
                    <option value="540">540</option>
                    <option value="620">620</option>
                    </select>
                    </div>

                    <div class="basic-car-info">   
                    <label for="height">Výška</label>
                    <select name="height" id="height" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                        <?php for ($i = 6; $i <= 13.5; $i+=0.5): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>

                        <?php for ($i = 25; $i <= 100; $i+=5): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                            <?php if ($i === 80): ?>
                                <option value="<?= htmlspecialchars($i+2); ?>"><?= htmlspecialchars($i+2); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="construction">Konštrukcia:</label>
                        <select name="construction" id="construction" onfocus='this.size=4;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="R">R</option>
                            <option value="D">D</option>
                            <option value="ZR">ZR</option>
                            <option value="B">B</option>
                        </select>
                    </div>

                    <div class="basic-car-info">
                    <label for="average">Priemer:</label>
                        <select name="average" id="average" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 10; $i <= 30; $i++): ?>
                            
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                            <?php if ($i === 16 || $i === 17): ?>
                                <option value="<?= htmlspecialchars($i+0.5); ?>"><?= htmlspecialchars($i+0.5); ?></option>
                            <?php elseif ($i == 19): ?>
                                <option value="<?= htmlspecialchars($i+0.5); ?>"><?= htmlspecialchars($i+0.5); ?></option>
                                <option value="<?= htmlspecialchars($i+0.9); ?>"><?= htmlspecialchars($i+0.9); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                        </select>
                    </div>

                    <div class="basic-car-info">  
                        <label for="weight-index">Hmotnostný index</label>
                        <select name="weight_index" id="weight-index" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 60; $i <= 170; $i++): ?>
                            <option value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                        </select>
                    </div>   
                     
                    <?php $alphas = range('A', 'Z'); ?>
                    

                    <div class="basic-car-info">
                        <label for="speed-index">Rýchlostný index:</label>
                        <select name="speed_index" id="speed-index" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php foreach ($alphas as $letter): ?>
                            <?php if ($letter != "A"): ?>
                            <option value="<?= htmlspecialchars($letter); ?>"><?= htmlspecialchars($letter); ?></option>
                            <?php else: ?>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= htmlspecialchars($letter . $i); ?>"><?= htmlspecialchars($letter . $i); ?></option>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="basic-car-info">  
                        <label for="price">Cena pneumatiky:</label> 
                        <input id="price" type="number" name="tire_price" placeholder="Zadaj" required>
                    </div>

                    <div class="basic-car-info">  
                        <span>Opis pneumatiky</span>
                        <textarea name="tire_description" id="tire-description" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div> 

                    <div class="basic-car-info">
                        <label for="image-name" id="choose-img-text">Vybrať</label>
                        <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                            <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Titulný obrázok</p>
                        <?php else: ?>
                            <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                        <?php endif; ?>
                        
                        <input id="image-name" type="file" name="tire_image">
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
    <script src="../js/select-tire-model.js"></script>  

</body>
</html>


