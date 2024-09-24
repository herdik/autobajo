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
    <title>Registrácia diskov</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/reg-form-wheel.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <section class="registration">

            <h1>Registrácia diskov</h1>

            <form id="registration-form" action="after-reg-add-car.php" method="POST" enctype="multipart/form-data">

                <div class="main-car-info">

                
                    <div class="basic-car-info">
                        <label for="wheels-category">Kategória:</label>
                        <select name="wheels-category" id="wheels-category">
                            <option value="Hliníkové">Hliníkové</option>
                            <option value="Plechové">Plechové</option>
                        </select>

                    </div>

                    <div class="basic-car-info">
                        <label for="answerWheelsBrand">Značka:</label>
                        <input type="text" id="answerWheelsBrand" name="wheel_brand" placeholder="Zadaj/Vyber" list="wheels_brand" autocomplete="off" value="" required />
                        <datalist id="wheels_brand">
                        
                            <option data-value=""></option>
                    
                        </datalist>
                    </div> 

                    <div class="basic-car-info">
                        <label for="answerWheelsModel">Model:</label>
                        <input type="text" id="answerWheelsModel" name="wheel_model" placeholder="Zadaj/Vyber" list="wheels-model" autocomplete="off" value="" required />
                        <datalist id="wheels-model">
                        
                            <option data-value=""></option>
                    
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
                        <input type="text" id="answerWheelsColor" name="wheel-color" placeholder="Zadaj/Vyber" list="wheels_color" autocomplete="off" value="" required />
                        <datalist id="wheels_color">
                        
                            <option data-value=""></option>
                    
                        </datalist>
                    </div>

                    <div class="basic-car-info">  
                        <label for="price">Cena disku:</label> 
                        <input id="price" type="number" name="wheel_price" placeholder="Zadaj" required>
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
                

                <div class="confirm-btn">
                    <input class="btn" type="submit" name="submit" value="Pridať">
                </div>    
            </form>

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="../js/header.js"></script> 
    <script src="../js/show-image-name.js"></script>       
    <script src="../js/reg-form.js"></script>       
        

</body>
</html>


