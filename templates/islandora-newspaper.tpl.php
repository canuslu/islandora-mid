<?php

/**
 * @file
 * This is the template file for the object page for newspaper.
 *
 * Available variables:
 * - $islandora_content: A rendered vertical tabbed newspapper issue browser.
 * - $parent_collections: An array containing parent collection
 *                        IslandoraFedoraObject(s).
 * - $description: Rendered metadata descripton for the object.
 * - $metadata: Rendered metadata display for the binary object.
 *
 * @see template_preprocess_islandora_newspaper()
 */
?>

<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/islandora-newspaper.css'); ?>

<div id="islandora-newspaper-wrapper">
<div class="col-md-6">
    <div class="islandora-newspaper-metadata">
        <div class="islandora-newspaper-thumbnail">
            <img class="img-responsive" src='<?php echo "/islandora/object/$object->id/datastream/TN/view"; ?>'>
        </div>
        <hr>
        <?php print $description; ?>
    </div>
</div>
<div class="col-md-6">
    <div class="islandora-newspaper-object islandora">
        <div class="islandora-newspaper-content-wrapper clearfix">
            <?php if ($islandora_content): ?>
            <div class="islandora-newspaper-content">
                <?php print $islandora_content; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
