<header>

<div class="logo">
        <a href="./my-dashboard.php">
            <img src="../img/autobajo-logo-transparent.png" alt="">
        </a>
</div>

    <nav>

        <ul id="main-menu">
            
            <?php if ($_SESSION["role"] === "admin"): ?>
            <li><a href="./reg-add-player.php">Nový inzerát</a></li>            
            <?php endif ?> 
            
            <li><a href="#">Autá</a></li>
            <li><a href="#">Pneumatiky</a></li>
            <li><a href="#">Disky</a></li>
            <li><a href="#">Pneuservis</a></li>
            <li><a href="#">O nás</a></li>
            <li><a href="./log-out.php">Odhlásiť</a></li>
                
        </ul>

        
    </nav>

    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>

</header>