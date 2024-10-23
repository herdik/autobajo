<?php

require "./classes/Contact.php";

// verifying by session if visitor have access to this website
require "./classes/Database.php";

// database connection
$database = new Database();
$connection = $database->connectionDB();

$contact_infos = Contact::getAllContactInfos($connection);

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nás</title>

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
    <link rel="stylesheet" href="./css/about-us.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./query/about-query.css">
</head>
<body>

    <?php require "./assets/header.php" ?>

    <main>

        <h1>Kde nás nájdete</h1>
        <section class="dashboard-menu">

        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5279.72137274204!2d18.191746!3d48.574217!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4714b5dc8e927bdb%3A0xea55f8f22bfe576c!2sPneuservis%20DB!5e0!3m2!1ssk!2sno!4v1724495873423!5m2!1ssk!2sno" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        

        <div class="container">
            <h2 class="paragraph">Kontakt</h2>
            <p class="small-text">Vitajte na stránkách spoločnosti <span class="no-wrap"> Pneuservis DB.</span> <br><br>Sme firma zaoberajúca sa predajom áut, pneumatík, diskov a v neposlednom rade ponúkame vynikajúce služby v oblasti pneuservisu.</p>
            <br>
            <p class="bigger-text">Môžete nás navštíviť osobne na nižšie spomínanej adrese. Taktiež nás môžete kontaktovať telefonicky, alebo mailom. </p>

            <br>

            
            
            <form id="main-contact-form">
                
                <div class="contact-info">

                <?php foreach($contact_infos as $contact_info): ?>
                    
                    <div class="company-contact-info">

                        <div class="working-time">
                            <p>Otváracie hodiny</p>
                            <p>Pondelok-Piatok:</p>
                            <p><?= htmlspecialchars($contact_info["mon_fri_morning_open"]) . " - " .  htmlspecialchars($contact_info["mon_fri_morning_close"]) . ", " . htmlspecialchars($contact_info["mon_fri_afternoon_open"]) . " - " . htmlspecialchars($contact_info["mon_fri_afternoon_close"])?></p>
                            <p><?= "Sobota: ". htmlspecialchars($contact_info["saturday_open"]) . " - " . htmlspecialchars($contact_info["saturday_close"]) ?></p>
                            <p><?= "Nedeľa: ". htmlspecialchars($contact_info["sunday"]) ?></p>
                            
                        </div>


                        <div class="company-info">
                            <p><?= htmlspecialchars($contact_info["company_name"]) ?></p>
                            
                            <p><?= htmlspecialchars($contact_info["street_number"]) ?></p>
                            
                            <p class="address"><?= htmlspecialchars($contact_info["town_post_nr"]) ?></p>
                        </div>

                    </div>

                    <div class="basic-contact-info">
                        <div class="person">
                            <label for="email1"><?= htmlspecialchars($contact_info["name_1"]) ?></label><br>
                            <i class="fa-regular fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($contact_info["email_1"]) ?>"><?= htmlspecialchars($contact_info["email_1"]) ?></a><br>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:+<?= htmlspecialchars($contact_info["tel_1"]) ?>">+<?= htmlspecialchars($contact_info["tel_1"]) ?></a>
                        </div>
                        
                        <div class="person person2">
                            <label for="email2"><?= htmlspecialchars($contact_info["name_2"]) ?></label><br>
                            <i class="fa-regular fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($contact_info["email_2"]) ?>"><?= htmlspecialchars($contact_info["email_2"]) ?></a><br>
                            <i class="fa-solid fa-phone"></i> <a href="tel:+<?= htmlspecialchars($contact_info["tel_2"]) ?>">+<?= htmlspecialchars($contact_info["tel_2"]) ?></a>
                        </div>   
                    </div>
 
                <?php endforeach; ?>    
                </div>
                
            </form> 
        </div>
            

        </section>
        

    </main>
    
    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>       
</body>
</html>
