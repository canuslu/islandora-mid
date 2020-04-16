<?php

/**
 * @file
 * This is the template file for the print view of the page image.
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-book-page-img-print.css'); ?>

<?php if (isset($islandora_content)): ?>
  <div class="islandora_book_page_image">
    <?php print $islandora_content; ?>
  </div>
<?php endif; ?>
