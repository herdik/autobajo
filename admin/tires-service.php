<?php
require "../classes/Database.php";
require "../classes/AluWheelBasicService.php";
require "../classes/AluWheelPremiumService.php";
require "../classes/MetalWheelBasicService.php";
require "../classes/MetalWheelPremiumService.php";
require "../classes/TruckService.php";
require "../classes/AdhesiveWeight.php";



// verifying by session if visitor have access to this website
require "../classes/Authorization.php";
// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

// if (isset($_GET["update-correct"]) and is_numeric($_GET["update-correct"])){
//     if ($_GET["update-correct"] == 1){
//         $succsess_update = true;
//     }
// } else {
    
// }


// database connection
$database = new Database();
$connection = $database->connectionDB();

$alu_wheel_basic = AluWheelBasicService::getAllAluWheelBasicService($connection);
$alu_wheel_premium = AluWheelPremiumService::getAllAluWheelPremiumService($connection);
$metal_wheel_basic = MetalWheelBasicService::getAllMetalWheelBasicService($connection);
$metal_wheel_premium = MetalWheelPremiumService::getAllMetalWheelPremiumService($connection);
$truck_service = TruckService::getAllTruckService($connection);
$adhesive_weight = AdhesiveWeight::getAllAdhesiveWeight($connection);

?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typ inzerátu</title>

    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/tires-service.css">
    <link rel="stylesheet" href="../query/header-query.css">

    <script src="https://kit.fontawesome.com/ed8b583ef3.js" crossorigin="anonymous"></script>

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <main>

        <h1>Cenník poskytovaných služieb <br> Pneuservis DB</h1>
        <section class="tires-service-menu">
        
            
            <article class="wheels">
                <h2>Hliníkové disky</h2>
                <h3>Vyváženie a montáž <a class="new_line add-alu-basic" href="./after-alu-price-list-basic-service.php?new_line=true">+</a></h3>

                <div class="container">

                    
                        <?php foreach($alu_wheel_basic as $one_alu_wheel_basic): ?>
                        <form id="alu-basic-service" action="./after-alu-price-list-basic-service.php" class="line-info alu-basic-service" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_alu_wheel_basic["alu_wheel_id"]) ?>" name="alu_wheel_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_alu_wheel_basic["type"]) ?>" name="type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" step="0.5" value="<?= htmlspecialchars($one_alu_wheel_basic["price"]) ?>" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn">
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>
                
                <h3>Vyzutie, obutie, vyváženie, montáž <a class="new_line add-alu-premium" href="./after-alu-price-list-premium-service.php?new_line=true">+</a></h3>
                <div class="container">

                    
                        <?php foreach($alu_wheel_premium as $one_alu_wheel_premium): ?>
                        <form id="alu-premium-service" action="./after-alu-price-list-premium-service.php" class="line-info alu-premium-service" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_alu_wheel_premium["alu_wheel_id"]) ?>" name="alu_wheel_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_alu_wheel_premium["type"]) ?>" name="type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" step="0.5" value="<?= htmlspecialchars($one_alu_wheel_premium["price"]) ?>" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn"> 
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>
                
                        
            </article>

            <article class="wheels">
                <h2>Plechové disky</h2>
                <h3>Vyváženie, montáž <a class="new_line add-metal-basic" href="./after-metal-price-list-basic-service.php?new_line=true">+</a></h3>
                <div class="container">

                    
                        <?php foreach($metal_wheel_basic as $one_metal_wheel_basic): ?>
                        <form id="metal-basic-service" action="./after-metal-price-list-basic-service.php" class="line-info metal-basic-service" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_metal_wheel_basic["metal_wheel_id"]) ?>" name="metal_wheel_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_metal_wheel_basic["type"]) ?>" name="type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" step="0.5" value="<?= htmlspecialchars($one_metal_wheel_basic["price"]) ?>" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn"> 
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>

                <h3>Vyzutie, obutie, vyváženie, montáž <a class="new_line add-metal-premium" href="./after-metal-price-list-premium-service.php?new_line=true">+</a></h3>
                <div class="container">

                    
                        <?php foreach($metal_wheel_premium as $one_metal_wheel_premium): ?>
                        <form id="metal-premium-service" action="./after-metal-price-list-premium-service.php" class="line-info metal-premium-service" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_metal_wheel_premium["metal_wheel_id"]) ?>" name="metal_wheel_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_metal_wheel_premium["type"]) ?>" name="type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" step="0.5" value="<?= htmlspecialchars($one_metal_wheel_premium["price"]) ?>" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn"> 
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>

                <h2>Nákladné autá do 3,5 t <a class="new_line add-truck-service" href="./after-price-list-truck-service.php?new_line=true">+</a></h2>
                
                <div class="container">

                    
                        <?php foreach($truck_service as $one_truck_service): ?>
                        <form id="truck-service" action="./after-price-list-truck-service.php" class="line-info truck-service" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_truck_service["truck_service_id"]) ?>" name="truck_service_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_truck_service["service_type"]) ?>" name="service_type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" step="0.5" value="<?= htmlspecialchars($one_truck_service["price"]) ?>" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn"> 
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>
                        
            </article>

            <article class="wheels">

                <h3>Lepiace závažie <a class="new_line add-adhesive-weight" href="./after-price-list-adhesive-weight.php?new_line=true">+</a></h3>
                <div class="container">

                    
                        <?php foreach($adhesive_weight as $one_adhesive_weight): ?>
                        <form id="adhesive-weight" action="./after-price-list-adhesive-weight.php" class="line-info adhesive-weight" method="POST">       
                                <input type="hidden" value="<?= htmlspecialchars($one_adhesive_weight["adhesive_weight_id"]) ?>" name="adhesive_weight_id">
                                <div class="product-info">
                                    <input type="text" value="<?= htmlspecialchars($one_adhesive_weight["type"]) ?>" name="type" id="">
                                </div>
                                
                                <div class="price">
                                    <input  type="number" value="<?= htmlspecialchars($one_adhesive_weight["price"]) ?>" step="0.01" name="price" id="">
                                </div>
                                
                                <input type="submit" value="X" id="delete-btn" name="btn">
                                <input type="submit" id="confirm-btn" value="OK" name="btn"> 
                        </form>
                        <?php endforeach ?>
                    
                    
                </div>
                        
            </article>
            
        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../js/header.js"></script>    
    <script src="../js/tire-service.js"></script>    
</body>
</html>


