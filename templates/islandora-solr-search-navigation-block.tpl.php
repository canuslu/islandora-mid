<?php
/**
 * @file
 * Islandora solr search navigation block.
 *
 * Variables available:
 * - $return_link: link to reutrn to original search.
 * - $prev_link: Link to previous object in search result.
 * - $next_link: link to next object in the search result.
 *
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-solr-search-navigation-block.css'); ?>

<div class="solr-search-nav-links">
  <div id="islandora-solr-search-prev-link" class="col-md-4 solr-search-nav-link"><?php if (isset($prev_link)){ echo '<i class="fas fa-chevron-left"></i> '; print $prev_link;} ?></div>
  <div id="islandora-solr-search-return-link" class="col-md-4 solr-search-nav-link"><?php print $return_link; ?></div>
  <div id="islandora-solr-search-next-link" class="col-md-4 solr-search-nav-link"><?php if (isset($next_link)){ print $next_link; echo ' <i class="fas fa-chevron-right"></i>';} ?></div>
</div>
