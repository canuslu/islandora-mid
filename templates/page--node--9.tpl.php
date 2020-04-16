<?php

/**
 * Promo page
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/promo.css'); ?>
<?php drupal_add_js(drupal_get_path('theme', 'miletos_muteferriqa').'/js/promo.js'); ?>

<?php
    if (user_is_logged_in()) {
        drupal_goto('/home');
    } else {
        drupal_goto('/promo/index.html');
    }
?>
