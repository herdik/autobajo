<header>

<div class="logo">
        <a href="./my-dashboard.php">
            <img src="../img/autobajo-logo-transparent.png" alt="">
        </a>
</div>

    <nav>

        <ul id="main-menu">
            
            <?php if ($_SESSION["role"] === "admin"): ?>
            <li><a href="./advertisement.php">Nový inzerát</a></li>            
            <?php endif ?> 
            
            <li><a href="./car-advertisement.php">Autá</a></li>
            <li><a href="./tire-advertisement.php">Pneumatiky</a></li>
            <li><a href="./wheel-advertisement.php">Disky</a></li>
            <li><a href="./tire-wheel-advertisement.php">Pneumatiky na diskoch</a></li>
            <li><a href="./tires-service.php">Pneuservis</a></li>
            <li><a href="./admin-about-us.php">O nás</a></li>
            <li><a href="./history-dashboard.php">História</a></li>
            <li><a href="./change-password.php?user_id=<?= htmlspecialchars($_SESSION["logged_in_user_id"]) ?>">Zmena hesla</a></li>
            <li><a href="./log-out.php">Odhlásiť</a></li>
                
        </ul>

        
    </nav>

    <div class="menu-icon">
        <!-- burger menu -->
        <span class="material-symbols-outlined current-menu-icon">menu</span> 
    </div>

</header>