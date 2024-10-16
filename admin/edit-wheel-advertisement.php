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


if (isset($_GET["wheel_id"]) and is_numeric($_GET["wheel_id"])){
    $wheel_infos = Wheel::getWheel($connection, $_GET["wheel_id"]);
    $wheel_brands = Wheel::getAllWheelsInfo($connection, 'wheel_brand', '%');
    $wheel_models = Wheel::getAllWheelsInfo($connection, 'wheel_model', $wheel_infos["wheel_brand"]);
    $wheel_colors = Wheel::getAllWheelsInfo($connection, 'wheel_color', '%');
} else {
    $wheel_infos = null;
    $wheel_brands = null;
    $wheel_models = null;
    $wheel_colors = null;
}
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editácia diskov</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/edit-form-wheel.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Editácia diskov</h1>

            <form id="registration-form" action="after-edit-wheel-form.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="wheel_id" value="<?= htmlspecialchars($wheel_infos["wheel_id"]) ?>">

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                        <label for="wheel-category">Kategória:</label>
                        <select name="wheel_category" id="wheel-category">
                            <option <?php echo (htmlspecialchars($wheel_infos["wheel_category"]) === 'Hliníkové') ? 'selected' : ''; ?> value="Hliníkové">Hliníkové</option>
                            <option <?php echo (htmlspecialchars($wheel_infos["wheel_category"]) === 'Plechové') ? 'selected' : ''; ?> value="Plechové">Plechové</option>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <label for="wheels-brand">Značka:</label>
                        <input type="text" id="wheels-brand" name="wheel_brand" placeholder="Zadaj/Vyber" list="wheels_brand" autocomplete="off" value="<?= htmlspecialchars($wheel_infos["wheel_brand"]) ?>" required />
                        <datalist id="wheels_brand">
                        
                            <?php foreach($wheel_brands as $wheel_brand): ?>
                                <option><?= htmlspecialchars($wheel_brand); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <label for="model-wheels">Model:</label>
                        <input type="text" id="model-wheels" name="wheel_model" placeholder="Zadaj/Vyber" list="wheels-model" autocomplete="off" value="<?= htmlspecialchars($wheel_infos["wheel_model"]) ?>" required />
                        <datalist id="wheels-model">
                        
                            <?php foreach($wheel_models as $wheel_model): ?>
                                <option><?= htmlspecialchars($wheel_model); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    
                    <div class="basic-car-info">
                    <label for="wheel-average">Priemer:</label>
                        <select name="wheel_average" id="wheel-average" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php for ($i = 10; $i < 24; $i++): ?>
                            <option <?php echo (htmlspecialchars($wheel_infos["wheel_average"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                        </select>
                    </div>

                    <?php require "../assets/array-reg-form-wheels.php"; ?>
                    <div class="basic-car-info">
                        <label for="spacing">Rozteč</label>
                        <select name="spacing" id="spacing" onfocus='this.size=5;' onblur='this.size=1;' 
                        onchange='this.size=1; this.blur();'>
                        <?php foreach ($spacings as $spacing): ?>
                            <option <?php echo (htmlspecialchars($wheel_infos["spacing"]) === $spacing) ? 'selected' : ''; ?> value="<?= htmlspecialchars($spacing); ?>"><?= htmlspecialchars($spacing); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="basic-car-info">
                    <label for="width">Šírka</label>
                    <select name="width" id="width" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 4.5; $i < 13.5; $i+=0.5): ?>
                        <option <?php echo (htmlspecialchars($wheel_infos["width"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-car-info">   
                    <label for="et">ET</label>
                    <select name="et" id="et" onfocus='this.size=5;' onblur='this.size=1;' 
                    onchange='this.size=1; this.blur();'>
                    <?php for ($i = 0; $i <= 100; $i++): ?>
                            <option <?php echo (htmlspecialchars($wheel_infos["et"]) == $i) ? 'selected' : ''; ?> value="<?= htmlspecialchars($i); ?>"><?= htmlspecialchars($i); ?></option>
                    <?php endfor; ?>
                    </select>
                    </div>

                    <div class="basic-car-info">
                        <label for="answerWheelsColor">Farba disku:</label>
                        <input type="text" id="answerWheelsColor" name="wheel_color" placeholder="Zadaj/Vyber" list="wheels-color" autocomplete="off" value="<?= htmlspecialchars($wheel_infos["wheel_color"]) ?>" required />
                        <datalist id="wheels-color">
                        
                            <?php foreach($wheel_colors as $wheel_color): ?>
                                <option><?= htmlspecialchars($wheel_color); ?></option>
                            <!-- <option data-value=""></option> -->
                            <?php endforeach; ?>
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">  
                        <label for="price">Cena disku:</label> 
                        <input id="price" type="number" name="wheel_price" placeholder="Zadaj" value="<?= htmlspecialchars($wheel_infos["wheel_price"]) ?>" required>
                    </div>

                    <div class="basic-car-info">  
                        <span>Opis disku</span>
                        <textarea name="wheel_description" id="wheel-description" rows="5" placeholder="Nepovinný údaj"><?= htmlspecialchars($wheel_infos["wheel_description"]) ?></textarea>
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
    <script src="../js/select-wheel-model.js"></script>

</body>
</html>


