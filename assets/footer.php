<footer>
    <?php $made_in = 2024;
          $current_year = ' - ' . date("Y");  ?>

    <p>AutoBajo - Vytvorilo štúdio JH <?= htmlspecialchars($made_in) ?> <?= (date("Y") > $made_in) ? htmlspecialchars($current_year) : ''; ?></p>

</footer>
<script src="./js/check-cookie.js"></script> 