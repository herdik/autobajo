<?php

require "../classes/Database.php";
require "../classes/TireWheel.php";

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

if (isset($_GET["tire_wheel_id"]) and is_numeric($_GET["tire_wheel_id"])){
    $tire_wheel_infos = TireWheel::getTireWheel($connection, $_GET["tire_wheel_id"]);
    $tire_brands = TireWheel::getAllTireWheelsInfo($connection, 'tire_brand', '%');
    $wheel_brands = TireWheel::getAllTireWheelsInfo($connection, 'wheel_brand', '%');
    $wheel_colors = TireWheel::getAllTireWheelsInfo($connection, 'wheel_color', '%');   
} else {
    $tire_wheel_infos = null;
    $tire_brands = null;
    $wheel_brand = null;
    $wheel_colors = null;
}
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editácia pneumatík na diskoch</title>

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
    <link rel="stylesheet" href="../css/reg-form-tire-wheel.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/reg-form-query.css">

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Editácia pneumatík na diskoch</h1>

            <form id="registration-form" action="after-edit-tire-wheel-form.php" method="POST">

            <input type="hidden" name="tire_wheel_id" value="<?= htmlspecialchars($tire_wheel_infos["tire_wheel_id"]) ?>">

                <h2>Pneumatika</h2>

                <div class="main-car-info">

                    <div class="basic-tire-info">
                        <label for="tire-category">Kategória:</label>
                        <select name="tire_category" id="tire-category" onfocus='this.size=3;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_category"]) === 'Osobné') ? 'selected' : ''; ?> value="Osobné">Osobné</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_category"]) === 'SUV') ? 'selected' : ''; ?> value="SUV">SUV</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_category"]) === 'Nákladné') ? 'selected' : ''; ?> value="Nákladné">Nákladné</option>
                        </select>

                    </div>

                    <div class="basic-tire-info">
                        <label for="answerTiresBrand">Značka:</label>
                        <input type="text" id="tire-brand" name="tire_brand" placeholder="Zadaj/Vyber" list="tires_brand" autocomplete="off" value="<?= htmlspecialchars($tire_wheel_infos["tire_brand"]) ?>" required />
                        <datalist id="tires_brand">
                        
                            <?php foreach($tire_brands as $tire_brand): ?>
                                <option><?= htmlspecialchars($tire_brand); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-tire-info">
                        <label for="tires-model">Model:</label>
                        <input type="text" id="model-tires" name="tire_model" placeholder="Zadaj/Vyber" list="tires-model" autocomplete="off" value="<?= htmlspecialchars($tire_wheel_infos["tire_model"]) ?>" required />
                        <datalist id="tires-model">
                        
                            <?php foreach($tire_models as $tire_model): ?>
                                <option><?= htmlspecialchars($tire_model); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    <div class="basic-tire-info">
                    <label for="type">Obdobie:</label>
                        <select name="type" id="type" onfocus='this.size=3;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["type"]) === 'Letné') ? 'selected' : ''; ?> value="Letné">Letné</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["type"]) === 'Zimné') ? 'selected' : ''; ?> value="Zimné">Zimné</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["type"]) === 'Celoročné') ? 'selected' : ''; ?> value="Celoročné">Celoročné</option>
                        </select>
                    </div>

                    <div class="basic-tire-info">
                        <label for="year">Rok výroby</label>
                        <input id="year" type="number" name="year_of_manufacture" value="<?= htmlspecialchars($tire_wheel_infos["year_of_manufacture"]); ?>" step="1" required>
                    </div>

                    <div class="basic-tire-info">
                    <label for="tire-with">Šírka</label>
                    <select name="tire_width" id="tire-width" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <option value="6.4">6.4</option>
                        <?php for ($i = 6.5; $i <= 17.5; $i+=0.5): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                    <?php for ($i = 27; $i <= 39; $i++): ?>
                        <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>

                    <?php for ($i = 115; $i <= 455; $i+=10): ?>
                        <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php if ($i === 235 || $i === 275 || $i === 295 || $i === 335 || $i === 435): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == $i+5) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+5); ?>"><?= htmlspecialchars($i+5); ?></option>
                        <?php elseif ($i == 315): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == $i+3) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+3); ?>"><?= htmlspecialchars($i+3); ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "460") ? 'selected' : ''; ?> value="460">460</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "480") ? 'selected' : ''; ?> value="480">480</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "495") ? 'selected' : ''; ?> value="495">495</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "500") ? 'selected' : ''; ?> value="500">500</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "525") ? 'selected' : ''; ?> value="525">525</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "540") ? 'selected' : ''; ?> value="540">540</option>
                    <option <?php echo (htmlspecialchars($tire_wheel_infos["tire_width"]) == "620") ? 'selected' : ''; ?> value="620">620</option>
                    </select>
                    </div>

                    <div class="basic-tire-info">   
                    <label for="height">Výška</label>
                    <select name="height" id="height" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 6; $i <= 13.5; $i+=0.5): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["height"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>

                        <?php for ($i = 25; $i <= 100; $i+=5): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["height"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                            <?php if ($i === 80): ?>
                                <option <?php echo (htmlspecialchars($tire_wheel_infos["height"]) == $i+2) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+2); ?>"><?= htmlspecialchars($i+2); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-tire-info">
                        <label for="construction">Konštrukcia:</label>
                        <select name="construction" id="construction" onfocus='this.size=4;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <option <?php echo (htmlspecialchars($tire_wheel_infos["construction"]) === "R") ? 'selected' : ''; ?> value="R">R</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["construction"]) === "D") ? 'selected' : ''; ?> value="D">D</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["construction"]) === "ZR") ? 'selected' : ''; ?> value="ZR">ZR</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["construction"]) === "B") ? 'selected' : ''; ?> value="B">B</option>
                        </select>
                    </div>

                    <div class="basic-tire-info">
                    <label for="average">Priemer:</label>
                        <select name="average" id="average" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 10; $i <= 30; $i++): ?>
                            
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["average"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                            <?php if ($i === 16 || $i === 17): ?>
                                <option <?php echo (htmlspecialchars($tire_wheel_infos["average"]) == $i+0.5) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+0.5); ?>"><?= htmlspecialchars($i+0.5); ?></option>
                            <?php elseif ($i == 19): ?>
                                <option <?php echo (htmlspecialchars($tire_wheel_infos["average"]) == $i+0.5) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+0.5); ?>"><?= htmlspecialchars($i+0.5); ?></option>
                                <option <?php echo (htmlspecialchars($tire_wheel_infos["average"]) == $i+0.9) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i+0.9); ?>"><?= htmlspecialchars($i+0.9); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                        </select>
                    </div>

                    <div class="basic-tire-info">  
                        <label for="weight-index">Hmotnostný index</label>
                        <select name="weight_index" id="weight-index" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 60; $i <= 170; $i++): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["weight_index"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                        </select>
                    </div>   
                     
                    <?php $alphas = range('A', 'Z'); ?>
                    

                    <div class="basic-tire-info">
                        <label for="speed-index">Rýchlostný index:</label>
                        <select name="speed_index" id="speed-index" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php foreach ($alphas as $letter): ?>
                            <?php if ($letter != "A"): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["speed_index"]) === $letter) ? 'selected' : ''; ?> value="<?= htmlspecialchars($letter); ?>"><?= htmlspecialchars($letter); ?></option>
                            <?php else: ?>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option <?php echo (htmlspecialchars($tire_wheel_infos["speed_index"]) === $letter . $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($letter . $i); ?>"><?= htmlspecialchars($letter . $i); ?></option>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </select>
                    </div>

                </div> 

                <h2>Disk</h2>

                <div class="main-car-info">

                
                    <div class="basic-wheel-info">
                        <label for="wheel-category">Kategória:</label>
                        <select name="wheel_category" id="wheel-category" onfocus='this.size=2;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["wheel_category"]) === 'Hliníkové') ? 'selected' : ''; ?> value="Hliníkové">Hliníkové</option>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["wheel_category"]) === 'Plechové') ? 'selected' : ''; ?> value="Plechové">Plechové</option>
                        </select>

                    </div>

                    <div class="basic-wheel-info">
                        <label for="wheels-brand">Značka:</label>
                        <input type="text" id="wheels-brand" name="wheel_brand" placeholder="Zadaj/Vyber" list="wheels_brand" autocomplete="off" value="<?= htmlspecialchars($tire_wheel_infos["wheel_brand"]) ?>" required />
                        <datalist id="wheels_brand">
                        
                            <?php foreach($wheel_brands as $wheel_brand): ?>
                                <option><?= htmlspecialchars($wheel_brand); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-wheel-info">
                        <label for="model-wheels">Model:</label>
                        <input type="text" id="model-wheels" name="wheel_model" placeholder="Zadaj/Vyber" list="wheels-model" autocomplete="off" value="<?= htmlspecialchars($tire_wheel_infos["wheel_model"]) ?>" required />
                        <datalist id="wheels-model">
                        
                            <?php foreach($wheel_models as $wheel_model): ?>
                                <option><?= htmlspecialchars($wheel_model); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    
                    <div class="basic-wheel-info">
                    <label for="wheel-average">Priemer:</label>
                        <select name="wheel_average" id="wheel-average" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 10; $i < 24; $i++): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["wheel_average"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                        </select>
                    </div>

                    <?php require "../assets/array-reg-form-wheels.php"; ?>
                    <div class="basic-wheel-info">
                        <label for="spacing">Rozteč</label>
                        <select name="spacing" id="spacing" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php foreach ($spacings as $spacing): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["spacing"]) === $spacing) ? 'selected' : ''; ?> value="<?= htmlspecialchars($spacing); ?>"><?= htmlspecialchars($spacing); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="basic-wheel-info">
                    <label for="wheel-width">Šírka</label>
                    <select name="wheel_width" id="wheel-width" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 4.5; $i < 13.5; $i+=0.5): ?>
                        <option <?php echo (htmlspecialchars($tire_wheel_infos["wheel_width"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-wheel-info">   
                    <label for="et">ET</label>
                    <select name="et" id="et" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 0; $i <= 100; $i++): ?>
                            <option <?php echo (htmlspecialchars($tire_wheel_infos["et"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-wheel-info">
                        <label for="answerWheelsColor">Farba disku:</label>
                        <input type="text" id="answerWheelsColor" name="wheel_color" placeholder="Zadaj/Vyber" list="wheels-color" autocomplete="off"  value="<?= htmlspecialchars($tire_wheel_infos["wheel_color"]) ?>" required />
                        <datalist id="wheels-color">
                        
                            <?php foreach($wheel_colors as $wheel_color): ?>
                                <option><?= htmlspecialchars($wheel_color); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                </div> 
                
                <h2>Informácie</h2>
                <div class="main-car-info">


                    <div class="basic-car-info">  
                        <label for="price">Cena:</label> 
                        <input id="price" type="number" name="price" placeholder="Zadaj" value="<?= htmlspecialchars($tire_wheel_infos["price"]); ?>" required>
                    </div>

                    <div class="basic-car-info">  
                        <span>Opis pneumatiky s diskom</span>
                        <textarea name="description" id="tire-description" rows="5" placeholder="Nepovinný údaj"><?= htmlspecialchars($tire_wheel_infos["description"]); ?></textarea>
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
    <script src="../js/show-image-name.js"></script>       
    <script src="../js/reg-form.js"></script>       
    <script src="../js/select-tire-model.js"></script>  
    <script src="../js/select-wheel-model.js"></script>  

</body>
</html>


