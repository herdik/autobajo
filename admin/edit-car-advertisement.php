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

// connection to Database
$database = new Database();
$connection = $database->connectionDB();


if (isset($_GET["car_id"]) and is_numeric($_GET["car_id"])){
    $car_infos = Car::getCar($connection, $_GET["car_id"]);
    $car_equipments = ["Elekt. okná", "Elekt. sedadlá", "Bezkľúč. štartovanie", "Airbag", "Tempomat", "Vyhriev. sedadlá", "Park. senzory", "Isofix", "Hlin. disky", "Klimatizácia", "Ťažné zariadenie", "Alarm"];
    $car_equipments_hmtl = ["el-windows", "el-seats", "no-key-start", "airbag", "tempomat", "heated-seat", "parking-sensor", "isofix", "alu-rimes", "air-condition", "towing-device", "alarm"];
    $car_models = Car::getAllCarsInfo($connection, 'car_model', $car_infos["car_brand"]);
    $car_colors = Car::getAllCarsInfo($connection, 'car_color', '%');
} else {
    $car_infos = null;
    $car_equipments = null;
    $car_equipments_hmtl = null;
    $car_models = null;
    $car_colors = null;
}

// control if user choose image from image gallery 
$image_sequence = null;

// first index for $car_equipments loop
$inside_index = 13;

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editácia auta</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/edit-form-car.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/reg-form-query.css">

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Editácia auta</h1>

            <form id="registration-form" action="after-edit-car-form.php" method="POST">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_infos["car_id"]) ?>">
                <div class="main-car-info">
                    
                    <div class="basic-car-info">
                        
                        <select name="car_brand" id="car-brand" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php require "../assets/array-car-brand.php" ?>
                        <?php foreach ($car_brands as $car_brand): ?>
                            <option <?php echo (htmlspecialchars($car_infos["car_brand"]) === $car_brand) ? 'selected' : ''; ?> value="<?= htmlspecialchars($car_brand); ?>"><?= htmlspecialchars($car_brand); ?></option>
                        <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <input type="text" id="car-model" name="car_model" placeholder="Model auta" list="car-models" autocomplete="off" value="<?= htmlspecialchars($car_infos["car_model"]) ?>" required />
                        <datalist id="car-models">
                            <?php foreach($car_models as $car_model): ?>
                                <option><?= htmlspecialchars($car_model); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <input type="text" id="answerCarColor" name="car_color" placeholder="Farba auta" list="car-colors" autocomplete="off" value="<?= htmlspecialchars($car_infos["car_color"]) ?>" required />
                        <datalist id="car-colors">
                            <?php foreach($car_colors as $car_color): ?>
                                <option><?= htmlspecialchars($car_color); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="year_of_manufacture" placeholder="Rok výroby" value="<?= htmlspecialchars($car_infos["year_of_manufacture"]) ?>" required>
                    </div>

                    <div class="basic-car-info">
                        <input type="number" name="engine_volume" placeholder="Objem motora" value="<?= htmlspecialchars($car_infos["engine_volume"]) ?>" required>
                    </div>

                    <div class="basic-car-info">   
                        <input type="number" name="past_km" placeholder="Počet km" value="<?= htmlspecialchars($car_infos["past_km"]) ?>" required>
                    </div>
                    
                    <div class="basic-car-info">
                        <label for="fuel-type">Druh paliva:</label>
                        <select name="fuel_type" id="fuel-type" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option <?php echo (htmlspecialchars($car_infos["fuel_type"]) === 'Benzín') ? 'selected' : ''; ?> value='Benzín'>Benzín</option>
                            <option <?php echo (htmlspecialchars($car_infos["fuel_type"]) === 'Diesel') ? 'selected' : ''; ?> value="Diesel">Diesel</option>
                            <option <?php echo (htmlspecialchars($car_infos["fuel_type"]) === 'LPG') ? 'selected' : ''; ?> value="LPG">LPG</option>
                            <option <?php echo (htmlspecialchars($car_infos["fuel_type"]) === 'Hybrid') ? 'selected' : ''; ?> value="Hybrid">Hybrid</option>
                            <option <?php echo (htmlspecialchars($car_infos["fuel_type"]) === 'Elektro') ? 'selected' : ''; ?> value="Elektro">Elektro</option>
                        </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="gearbox">Prevodovka:</label>
                        <select name="gearbox" id="gearbox" onfocus='this.size=2;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option <?php echo (htmlspecialchars($car_infos["gearbox"]) === 'Manuálna') ? 'selected' : ''; ?> value="Manuálna">Manuálna</option>
                            <option <?php echo (htmlspecialchars($car_infos["gearbox"]) === 'Automatická') ? 'selected' : ''; ?> value="Automatická">Automatická</option>
                        </select>
                    </div>

                    <div class="basic-car-info">   
                        <label for="car-price">Cena:</label>
                        <input type="number" name="car_price" placeholder="Cena" value="<?= htmlspecialchars($car_infos["car_price"]) ?>" required>
                    </div>

                    <div class="basic-car-info">  
                        <label for="car-kw">KW:</label>
                        <input type="number" name="kw" placeholder="KW" value="<?= htmlspecialchars($car_infos["kw"]) ?>" required id="car-kw">
                    </div>

                    <div class="basic-car-info">  
                        <span>Parametre vozidla</span>
                        <textarea name="car_description" id="car-description" rows="5" placeholder="Nepovinný údaj"><?= htmlspecialchars($car_infos["car_description"]) ?></textarea>
                    </div>   
                     
                    <div class="basic-car-info">
                        <span>Dopln. výbava vozidla</span>
                        <textarea name="other_equipment" id="other-equipment" rows="5" placeholder="Nepovinný údaj"><?= htmlspecialchars($car_infos["other_equipment"]) ?></textarea>
                    </div>

                </div> 
                <div class="supplementary-car-info">
                
                    <p class="supplementary-equipment">Výbava</p>    

                    <div class="car-equipment">
                        <?php for ($i = 0; $i < 12; $i++): ?>
                            
                        <div class="car-equipment-category">
                            <label for="<?= htmlspecialchars($car_equipments_hmtl[$i]) ?>"><?= htmlspecialchars($car_equipments[$i]) ?></label>
                            
                            <?php if ($car_infos[$inside_index]): ?>
                                <input type="checkbox" name="vehicle_equipment[]" id="el-windows" value="<?= htmlspecialchars($i) ?>"  checked>
                            <?php else: ?>
                                <input type="checkbox" name="vehicle_equipment[]" id="el-windows" value="<?= htmlspecialchars($i) ?>">
                            <?php endif; ?>
                            
                        </div>
                        <?php $inside_index++ ?>
                        <?php endfor; ?>
                        
                    </div>
                </div>

                <div class="confirm-btn">
                    <input class="btn" type="submit" name="submit" value="Potvrdiť">
                </div>    
            </form>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script src="../js/header.js"></script>     
    <script src="../js/reg-form.js"></script>       
    <script src="../js/select-car-model.js"></script>  

</body>
</html>


