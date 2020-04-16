<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/islandora-basic-collection-grid.css'); ?>

<div class="islandora islandora-basic-collection">
  <div class="islandora-basic-collection-grid clearfix col-md-12">
  <?php foreach ($associated_objects_array as $key => $value): ?>
      <?php $model = $value['object']->models[0]; ?>
    <div class="islandora-basic-collection-object <?php print $value['class'];?> col-md-4 col-sm-3">
        <div class="col-md-6">
            <div class="islandora-basic-collection-thumb">
                <a href="/islandora/object/<?php echo $value['pid']; ?>" title="<?php echo t($value['dc_array']['dc:title']['value']); ?>"><img typeof="foaf:Image" class="img-responsive" src="/islandora/object/<?php echo $value['pid']; ?>/datastream/TN/view" alt="<?php echo t($value['dc_array']['dc:title']['value']); ?>"></a>
            </div>
        </div>
        <div class="col-md-6">
            <p>
            <span class="islandora-basic-collection-title"><strong><a href="/<?php echo $value['path']; ?>" title="<?php echo t($value['dc_array']['dc:title']['value']); ?>"><?php echo t($value['dc_array']['dc:title']['value']); ?></a></strong></span><br>
            <?php
                if ($model == "islandora:collectionCModel") {
                    echo '<span class="islandora-basic-collection-contributor"><strong>' . t('Description') . ': </strong> ' . t($value['dc_array']['dc:description']['value']) . '</span>';
                } else {
                    echo '<span class="islandora-basic-collection-contributor"><strong>' . t('Contributor') . ': </strong> ' . t($value['dc_array']['dc:contributor']['value']) . '</span><br>';
                    echo '<span class="islandora-basic-collection-subject"><strong>' . t('Subject') . ': </strong> ' . t($value['dc_array']['dc:subject']['value']) . '</span><br>';
                    echo '<span class="islandora-basic-collection-date"><strong>' . t('Date') . ': </strong> ' . t($value['dc_array']['dc:date']['value']) . '</span>';
                }
                ?>
            </p>
        </div>
    </div>
  <?php endforeach; ?>
</div>
</div>
