<?php
require "../classes/Database.php";
require "../classes/Car.php";

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

// control if user choose image from image gallery 
$image_sequence = null;

$car_colors = Car::getAllCarsInfo($connection, 'car_color', '%');

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia auta</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/reg-form-car.css">
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

            <h1>Registrácia auta</h1>

            <!-- <form id="registration-form" action="after-reg-add-car.php" method="POST" enctype="multipart/form-data"> -->

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                       
                        <select name="car_brand" id="car-brand" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php require "../assets/array-car-brand.php" ?>
                        <?php for ($i = 0; $i < count($car_brands); $i++): ?>
                            <option value="<?= htmlspecialchars($car_brands[$i]); ?>"><?= htmlspecialchars($car_brands[$i]); ?></option>
                        <?php endfor; ?>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <input type="text" id="car-model" name="car_model" placeholder="Model auta" list="car-models" autocomplete="off" value="" required />
                        <datalist id="car-models">
                            <!-- <option>ahojko</option> -->
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <input size="3" type="text" id="answerCarColor" name="car_color" placeholder="Farba auta" list="car-colors" autocomplete="off" value="" required />
                        <datalist id="car-colors">
                            <?php foreach($car_colors as $car_color): ?>
                                <option><?= htmlspecialchars($car_color); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="year_of_manufacture" placeholder="Rok výroby" value="<?= htmlspecialchars(date("Y")); ?>" required>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="engine_volume" placeholder="Objem motora" required>
                    </div>

                    <div class="basic-car-info">   
                        <input type="number" name="past_km" placeholder="Počet km" required>
                    </div>

                    <div class="basic-car-info">
                        <label for="fuel-type">Druh paliva:</label>
                        <select name="fuel_type" id="fuel-type" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="Benzín">Benzín</option>
                            <option value="Diesel">Diesel</option>
                            <option value="LPG">LPG</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="Elektro">Elektro</option>
                        </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="gearbox">Prevodovka:</label>
                        <select name="gearbox" id="gearbox" onfocus='this.size=2;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option value="Manuálna">Manuálna</option>
                            <option value="Automatická">Automatická</option>
                        </select>
                    </div>

                    <div class="basic-car-info">  
                        
                        <input type="number" name="car_price" placeholder="Cena" required id="car-price">
                    </div>

                    <div class="basic-car-info">  
                        <input type="number" name="kw" placeholder="KW" required id="car-kw">
                    </div>

                    <div class="basic-car-info">  
                        <span>Parametre vozidla</span>
                        <textarea name="car_description" id="car-description" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div>   
                     
                    <div class="basic-car-info">
                        <span>Dopln. výbava vozidla</span>
                        <textarea name="other_equipment" id="other-equipment" rows="5" placeholder="Nepovinný údaj"></textarea>
                    </div>

                    <div class="basic-car-info">
                        <label for="image-name" id="choose-img-text">Vybrať</label>
                        <?php if (htmlspecialchars($image_sequence) == NULL): ?>
                            <p id="picture-titel" style="opacity:1; color:white; font-size:24px;">Titulný obrázok</p>
                        <?php else: ?>
                            <p style="opacity:1;">Zvolený obrázok: Obrázok č.<?= htmlspecialchars($image_sequence) ?></p>
                        <?php endif; ?>
                        
                        <input id="image-name" type="file" name="car_image">
                    </div>
                </div> 
                <div class="supplementary-car-info">
                
                    <p class="supplementary-equipment">Výbava</p>    

                    <div class="car-equipment">
                        <div class="car-equipment-category">
                            <label for="el-windows">Elekt. okná</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="el-windows" value="0">
                        </div>

                        <div class="car-equipment-category">
                            <label for="el-seats">Elekt. sedadlá</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="el-seats" value="1">
                        </div>

                        <div class="car-equipment-category">
                            <label for="no-key-start">Bezkľúč. štartovanie</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="no-key-start" value="2">
                        </div>

                        <div class="car-equipment-category">
                            <label for="airbag">Airbag</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="airbag" value="3">
                        </div>

                        <div class="car-equipment-category">
                            <label for="tempomat">Tempomat</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="tempomat" value="4">
                        </div>

                        <div class="car-equipment-category">
                            <label for="heated-seat">Vyhriev. sedadlá</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="heated-seat" value="5">
                        </div>

                        <div class="car-equipment-category">
                            <label for="parking-sensor">Park. senzory</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="parking-sensor" value="6">
                        </div>

                        <div class="car-equipment-category">
                            <label for="isofix">Isofix</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="isofix" value="7">
                        </div>

                        <div class="car-equipment-category">
                            <label for="alu-rimes">Hlin. disky</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="alu-rimes" value="8">
                        </div>
                        <div class="car-equipment-category">
                            <label for="air-condition">Klimatizácia</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="air-condition" value="9">
                        </div>
                        <div class="car-equipment-category">
                            <label for="towing-device">Ťažné zariadenie</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="towing-device" value="10">
                        </div>
                        <div class="car-equipment-category">
                            <label for="alarm">Alarm</label>
                            <input type="checkbox" name="vehicle_equipment[]" id="alarm" value="11">
                        </div>
                    </div>
                </div>

                <div class="confirm-btn">
                    <input class="btn" type="submit" name="submit" value="Pridať">
                </div>    
            <!-- </form> -->

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../js/header.js"></script> 
    <script src="../js/show-image-name.js"></script>       
    <script src="../js/reg-form.js"></script>       
    <script src="../js/select-car-model.js"></script>  
    <script src="../js/loading.js"></script>        
    <script src="../js/confirm-uploading.js"></script>        
    
        

</body>
</html>


