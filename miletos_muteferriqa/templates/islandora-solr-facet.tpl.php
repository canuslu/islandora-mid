<?php

/**
 * @file
 * Template file for default facets
 *
 * @TODO document available variables
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-solr-facet.css'); ?>

<ul class="<?php print $classes; ?>">
  <?php foreach ($buckets as $key => $bucket): ?>
    <li>
        <span class="plusminus">
          <?php print $bucket['link_plus']; ?>
          <?php print $bucket['link_minus']; ?>
        </span>
      <span clas="link">
          <?php print t($bucket['link']); ?>
      </span>
      <span class="count">(<?php print $bucket['count']; ?>)</span>

    </li>
  <?php endforeach; ?>
</ul>
