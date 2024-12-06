<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/signin.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/global-header-query.css">
    <link rel="stylesheet" href="./query/sign-in-query.css">

</head>
<body>

    <div class="loader">
        <div class="loader-animation"></div>
    </div>

    <?php require "./assets/header.php" ?>

    <main>
        
        <section class="signin-form">
            
            <img src="./img/autobajo-logo-transparent.png" alt="">
            
            <h1>Prihlásenie</h1>
            <form action="./admin/log-in.php" method="POST">
                <input type="email" name="user_email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Heslo" required><br>
                <input type="submit" value="Prihlásiť">
            </form>

        </section>

    </main>

    <?php require "./assets/footer.php" ?>
    <script src="./js/header.js"></script>
    <script src="./js/loading.js"></script> 
    <script src="./js/check-cookie.js"></script>
</body>
</html>