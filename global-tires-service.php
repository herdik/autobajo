<?php
require "./classes/Database.php";
require "./classes/AluWheelBasicService.php";
require "./classes/AluWheelPremiumService.php";
require "./classes/MetalWheelBasicService.php";
require "./classes/MetalWheelPremiumService.php";
require "./classes/TruckService.php";
require "./classes/AdhesiveWeight.php";



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

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <!-- ICONS MENU -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <!-- ICONS MENU -->

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/global-tires-service.css">
    <link rel="stylesheet" href="./query/header-query.css">
    
</head>
<body>

    <?php require "./assets/header.php" ?>
    
    <main>

        <h1>Cenník poskytovaných služieb <br> Pneuservis DB
        </h1>
        <section class="tires-service-menu">
            
            <article class="wheels">
                <h2>Hliníkové disky</h2>
                <h3>Vyváženie a montáž </h3>

                <div class="container">

                    
                        <?php foreach($alu_wheel_basic as $one_alu_wheel_basic): ?>
                        <div class="line-info">       
                                <div class="product-info">
                                <span><?= htmlspecialchars($one_alu_wheel_basic["type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_alu_wheel_basic["price"]) ?> &#8364;/kus</span>
                                </div>
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>
                
                <h3>Vyzutie, obutie, vyváženie, montáž</h3>
                <div class="container">

                    
                        <?php foreach($alu_wheel_premium as $one_alu_wheel_premium): ?>
                        <div action="./after-alu-price-list-premium-service.php" class="line-info" method="POST">       
                               
                                <div class="product-info">
                                    <span><?= htmlspecialchars($one_alu_wheel_premium["type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_alu_wheel_premium["price"]) ?> &#8364;/kus</span>
                                    
                                </div>
                                
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>
                
                <h2>Plechové disky</h2>
                <h3>Vyváženie, montáž</h3>
                <div class="container">

                    
                        <?php foreach($metal_wheel_basic as $one_metal_wheel_basic): ?>
                        <div class="line-info">       
                               
                                <div class="product-info">
                                    <span><?= htmlspecialchars($one_metal_wheel_basic["type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_metal_wheel_basic["price"]) ?> &#8364;/kus</span>
                                </div>
                                
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>

                <h3>Vyzutie, obutie, vyváženie, montáž </h3>
                <div class="container">

                    
                        <?php foreach($metal_wheel_premium as $one_metal_wheel_premium): ?>
                        <div class="line-info">       
                                
                                <div class="product-info">
                                    <span><?= htmlspecialchars($one_metal_wheel_premium["type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_metal_wheel_premium["price"]) ?> &#8364;/kus</span>
                                </div>
                                 
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>

                <h2>Nákladné autá do 3,5 t</h2>
                
                <div class="container">

                    
                        <?php foreach($truck_service as $one_truck_service): ?>
                        <div class="line-info">       
                                
                                <div class="product-info">
                                    <span><?= htmlspecialchars($one_truck_service["service_type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_truck_service["price"]) ?> &#8364;/kus</span>
                                </div>
                                
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>

                <h3>Lepiace závažie</h3>
                <div class="container">

                    
                        <?php foreach($adhesive_weight as $one_adhesive_weight): ?>
                        <div class="line-info">       
                                
                                <div class="product-info">
                                    <span><?= htmlspecialchars($one_adhesive_weight["type"]) ?></span>
                                </div>
                                
                                <div class="price">
                                    <span><?= htmlspecialchars($one_adhesive_weight["price"]) ?>  &#8364;/kus</span>
                                    
                                </div>
                                
                        </div>
                        <?php endforeach ?>
                    
                    
                </div>
                        
            </article>

            <article class="wheels">
                <p>Ceny platné od 01.09.2022 <br> Ceny sú uvedené s DPH <br> Majiteľ: Dalibor Bajzík <br> Zodpovedný vedúci: Marek Dovičin
                </p>
            </article>
            
        </section>
        

    </main>
    
    <?php require "./assets/footer.php" ?>

    <script src="./js/header.js"></script>     
    <script src="./js/header-nav-visibility.js"></script>   
    
</body>
</html>


