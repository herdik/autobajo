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
            <li><a href="#">Pneumatiky</a></li>
            <li><a href="#">Disky</a></li>
            <li><a href="./tires-service.php">Pneuservis</a></li>
            <li><a href="./admin-about-us.php">O nás</a></li>
            <li><a href="./log-out.php">Odhlásiť</a></li>
                
        </ul>

        
    </nav>

    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>

</header>