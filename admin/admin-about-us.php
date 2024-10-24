<?php

require "../classes/Authorization.php";
require "../classes/Contact.php";

// verifying by session if visitor have access to this website
require "../classes/Database.php";

// get session
session_start();
// authorization for visitor - if has access to website 
if (!Auth::isLoggedIn()){
    die ("nepovolený prístup");
} 

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
    <link rel="stylesheet" href="../css/about-us.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/about-query.css">

</head>
<body>

    <?php require "../assets/admin-header.php" ?>

    <dialog class="confirm-window" id="confirm-window">

       <h1>Údaje boli zaregistrované!</h1> 

    </dialog>

    <main>

        <h1>Kde nás nájdete</h1>
        <section class="dashboard-menu">

        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5279.72137274204!2d18.191746!3d48.574217!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4714b5dc8e927bdb%3A0xea55f8f22bfe576c!2sPneuservis%20DB!5e0!3m2!1ssk!2sno!4v1724495873423!5m2!1ssk!2sno" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        

        <div class="container">
            <h2 class="paragraph">Kontakt</h2>
            <p class="small-text">Vitajte na stránkách spoločnosti Pneuservis DB. <br><br>Sme firma zaoberajúca sa predajom áut, pneumatík, diskov a v neposlednom rade ponúkame vynikajúce služby v oblasti pneuservisu.</p>
            <br>
            <p class="bigger-text">Môžete nás navštíviť osobne na nižšie spomínanej adrese. Taktiež nás môžete kontaktovať telefonicky, alebo mailom. </p>

            <br>

            
            
            <form id="main-contact-form" action="after-reg-main-contact.php" method="POST">
                
            <div class="contact-info">

            <?php foreach($contact_infos as $contact_info): ?>
                <div class="opening-time">

                    <div class="days">
                        <label for="mon-fri-mor-open">Pondelok-Piatok doobeda</label>
                        <input type="time" name="mon_fri_morning_open" id="mon-fri-mor-open" value="<?= htmlspecialchars($contact_info["mon_fri_morning_open"]) ?>">
                        <input type="time" name="mon_fri_morning_close" id="mon-fri-mor-close" value="<?= htmlspecialchars($contact_info["mon_fri_morning_close"]) ?>">
                    </div>
                    
                    <div class="days">
                        <label for="mon-fri-aft-open">Pondelok-Piatok poobede</label>
                        <input type="time" name="mon_fri_afternoon_open" id="mon-fri-aft-open" value="<?= htmlspecialchars($contact_info["mon_fri_afternoon_open"]) ?>">
                        <input type="time" name="mon_fri_afternoon_close" id="mon-fri-aft-close" value="<?= htmlspecialchars($contact_info["mon_fri_afternoon_close"]) ?>">
                    </div>

                </div>

                <div class="weekend-time">
                    <div class="weekend">
                        <label for="saturday-open">Sobota od</label>
                        <input type="time" name="saturday_open" id="saturday-open" value="<?= htmlspecialchars($contact_info["saturday_open"]) ?>">
                    </div>
                    <div class="weekend">
                        <label for="saturday-close">Sobota do</label>
                        <input type="time" name="saturday_close" id="saturday-slose" value="<?= htmlspecialchars($contact_info["saturday_close"]) ?>">
                    </div>
                    <div class="weekend">
                        <label for="sunday">Nedeľa</label>
                        <input type="text" name="sunday" id="sunday" value="<?= htmlspecialchars($contact_info["sunday"]) ?>">
                    </div>
                </div>
                

                
                    <label for="company-name">Názov spoločnosti</label>
                    <input type="text" name="company_name" id="company-name" placeholder="Názov spoločnosti" value="<?= htmlspecialchars($contact_info["company_name"]) ?>" required>
                    <label for="street-number">Ulica a číslo domu</label>
                    <input type="text" name="street_number" id="street-number" placeholder="Ulica a číslo domu" value="<?= htmlspecialchars($contact_info["street_number"]) ?>" required>
                    <label for="town-post-nr">Smerovacie číslo a mesto</label>
                    <input type="text" name="town_post_nr" id="town-post-nr" placeholder="Smerovacie číslo a mesto" value="<?= htmlspecialchars($contact_info["town_post_nr"]) ?>" required>

                    <div class="basic-contact-info">
                        <div class="person">
                            <label for="name-1">Osoba 1</label>
                            <input type="text" name="name_1" id="name-1" placeholder="Osoba 1" value="<?= htmlspecialchars($contact_info["name_1"]) ?>" required>
                            <label for="email1">Email 1</label>
                            <input type="email" name="email_1" id="email1" placeholder="Email" value="<?= htmlspecialchars($contact_info["email_1"]) ?>" required>
                            <label for="tel1">Telefónne číslo 1</label>
                            <input type="tel" name="tel_1" id="tel1" placeholder="421 123 456" pattern="[0-9]{3} [0-9]{3} [0-9]{3} [0-9]{3}" value="<?= htmlspecialchars($contact_info["tel_1"]) ?>" required>
                            <small class="tel1 hide">Format: 421 123 456</small>
                        </div>
                        
                        <div class="person person2">
                            <label for="name-2">Osoba 2</label>
                            <input type="text" name="name_2" id="name-2" placeholder="Osoba 2" value="<?= htmlspecialchars($contact_info["name_2"]) ?>" required>
                            <label for="email2">Email 2</label>
                            <input type="email" name="email_2" id="email2" placeholder="Email" value="<?= htmlspecialchars($contact_info["email_2"]) ?>" required>
                            <label for="tel2">Telefónne číslo 2</label>
                            <input type="tel" name="tel_2" id="tel2" placeholder="421 123 456" pattern="[0-9]{3} [0-9]{3} [0-9]{3} [0-9]{3}" value="<?= htmlspecialchars($contact_info["tel_2"]) ?>" required>
                            <small class="tel2 hide">Format: 421 123 456</small>
                        </div>   
                    </div>

                    <div class="confirm-btn">
                        <input class="btn" id="btn-contact" type="submit" name="submit" value="Potvrdiť">
                    </div> 
                <?php endforeach; ?>    
                </div>
                
            </form> 
        </div>
            

        </section>
        

    </main>
    
    <?php require "../assets/footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="../js/header.js"></script>     
    <script src="../js/about-us.js"></script>     
    <script src="../js/contact-info.js"></script>     
         
</body>
</html>




