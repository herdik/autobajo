<?php

// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

// control if user choose image from image gallery 
$image_sequence = null;

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia auta</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/reg-form-car.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Registrácia auta</h1>

            <form id="registration-form" action="after-reg-add-car.php" method="POST" enctype="multipart/form-data">

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                        <input type="text" id="answerCarBrand" name="car_brand" placeholder="Značka auta" list="car-brands" autocomplete=“off” value="" required>
                        <datalist id="car-brands">
                        
                            <option data-value=""></option>
                    
                        </datalist>

                    </div>

                    <div class="basic-car-info">
                        <input type="text" id="answerCarModel" name="car_model" placeholder="Model auta" list="car-models" autocomplete=“off” value="" required>
                        <datalist id="car-models">
                        
                            <option data-value=""></option>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <input type="text" name="car_color" placeholder="Farba auta" required>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="year_of_manufacture" placeholder="Rok výroby" required>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="engine_volume" placeholder="Objem motora" required>
                    </div>

                    <div class="basic-car-info">   
                        <input type="number" name="car_price" placeholder="Cena" required>
                    </div>

                    <div class="basic-car-info">
                        <label for="fuel-type">Druh paliva:</label>
                        <select name="fuel_type" id="fuel-type">
                            <option value="Benzín">Benzín</option>
                            <option value="Diesel">Diesel</option>
                            <option value="LPG">LPG</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="Elektro">Elektro</option>
                        </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="gearbox">Prevodovka:</label>
                        <select name="gearbox" id="gearbox">
                            <option value="Manuálna">Manuálna</option>
                            <option value="Automatická">Automatická</option>
                        </select>
                    </div>

                    <div class="basic-car-info">  
                        <span>Opis vozidla</span>
                        <textarea name="car_description" id="car-description" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div>   
                     
                    <div class="basic-car-info">
                        <span>Dopln. výbava vozidla</span>
                        <textarea name="vehicle_equipment" id="vehicle-equipment" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div>

                    <div class="basic-car-info">
                        <label for="car-image" id="choose-img-text">Vybrať</label>
                        <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                            <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Titulný obrázok</p>
                        <?php else: ?>
                            <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                        <?php endif; ?>
                        
                        <input id="car-image" type="file" name="car_image">
                    </div>
                </div> 
                <div class="supplementary-car-info">
                
                    <p class="supplementary-equipment">Výbava</p>    

                    <div class="car-equipment">
                        <div class="car-equipment-category">
                            <label for="el-windows">Elekt. okná</label>
                            <input type="checkbox" name="el_windows" id="el-windows">
                        </div>

                        <div class="car-equipment-category">
                            <label for="el-seats">Elekt. sedadlá</label>
                            <input type="checkbox" name="el_seats" id="el-seats">
                        </div>

                        <div class="car-equipment-category">
                            <label for="no-key-start">Bezkľúč. štartovanie</label>
                            <input type="checkbox" name="no_key_start" id="no-key-start">
                        </div>

                        <div class="car-equipment-category">
                            <label for="airbag">Airbag</label>
                            <input type="checkbox" name="airbag" id="airbag">
                        </div>

                        <div class="car-equipment-category">
                            <label for="tempomat">Tempomat</label>
                            <input type="checkbox" name="tempomat" id="tempomat">
                        </div>

                        <div class="car-equipment-category">
                            <label for="heated-seat">Vyhriev. sedadlá</label>
                            <input type="checkbox" name="heated_seat" id="heated-seat">
                        </div>

                        <div class="car-equipment-category">
                            <label for="parking-sensor">Park. senzory</label>
                            <input type="checkbox" name="parking_sensor" id="parking-sensor">
                        </div>

                        <div class="car-equipment-category">
                            <label for="isofix">Isofix</label>
                            <input type="checkbox" name="isofix" id="isofix">
                        </div>

                        <div class="car-equipment-category">
                            <label for="alu-rimes">Hlin. disky</label>
                            <input type="checkbox" name="alu_rimes" id="alu-rimes">
                        </div>
                        <div class="car-equipment-category">
                            <label for="air-condition">Klimatizácia</label>
                            <input type="checkbox" name="air_condition" id="air-condition">
                        </div>
                        <div class="car-equipment-category">
                            <label for="towing-device">Ťažné zariadenie</label>
                            <input type="checkbox" name="towing_device" id="towing-device">
                        </div>
                        <div class="car-equipment-category">
                            <label for="alarm">Alarm</label>
                            <input type="checkbox" name="alarm" id="alarm">
                        </div>
                    </div>
                </div>

                <div class="confirm-btn">
                    <input class="btn" type="submit" name="submit" value="Pridať">
                </div>    
            </form>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script> 
    <script src="../js/show-image-name.js"></script>           
</body>
</html>


