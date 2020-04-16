<?php
/**
 * @file
 * Islandora solr search results wrapper template
 *
 * Variables available:
 * - $variables: all array elements of $variables can be used as a variable.
 *   e.g. $base_url equals $variables['base_url']
 * - $base_url: The base url of the current website. eg: http://example.com .
 * - $user: The user object.
 *
 * - $secondary_profiles: Rendered secondary profiles
 * - $results: Rendered search results (primary profile)
 * - $islandora_solr_result_count: Solr result count string
 * - $solrpager: The pager
 * - $solr_debug: debug info
 *
 * @see template_preprocess_islandora_solr_wrapper()
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-solr-wrapper.css'); ?>

<div class="col-md-12" id="islandora-solr-search-results">
    <div class="col-md-3 islandora-solr-facets">
        <h3><?php echo t('Filter the results'); ?></h3>
        <hr>
        <div id="islandora-solr-facets-wrapper">
        <?php
            $facets = module_invoke('islandora_solr', 'block_view', 'basic_facets');
            print render($facets['content']);
        ?>
        </div>
    </div>
    <div class="col-md-6 islandora-solr-results">
        <div class="row">
            <div class="col-md-3">
                <div id="islandora-solr-top" class="islandora-solr-result-count-wrapper">
                  <?php print $secondary_profiles; ?>
                  <div id="islandora-solr-result-count"><?php print $islandora_solr_result_count; ?></div>
                </div>
            </div>
            <div class="col-md-9 islandora-solr-pager-wrapper">
                <?php print $solr_pager; ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="islandora-solr-content">
              <?php print $results; ?>
              <?php print $solr_debug; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div id="islandora-solr-top"  class="islandora-solr-result-count-wrapper">
                  <?php print $secondary_profiles; ?>
                  <div id="islandora-solr-result-count"><?php print $islandora_solr_result_count; ?></div>
                </div>
            </div>
            <div class="col-md-9 islandora-solr-pager-wrapper">
                <?php print $solr_pager; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 islandora-solr-sort">
        <h3><?php echo t('Sort the results'); ?></h3>
        <hr>
        <div id="islandora-solr-sort-wrapper">
        <?php
            $sort = module_invoke('islandora_solr', 'block_view', 'sort');
            print render($sort['content']);
        ?>
        </div>
    </div>
</div>
