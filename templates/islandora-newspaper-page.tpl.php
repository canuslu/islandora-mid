<?php

/**
 * @file
 * This is the template file for the object page for newspaper.
 *
 * Available variables:
 * - $object: The Islandora object rendered in this template file
 * - $islandora_content: A rendered image. By default this is the JPG datastream
 *   which is a medium sized image. Alternatively this could be a rendered
 *   viewer which displays the JP2 datastream image.
 * - $description: Rendered metadata descripton for the object.
 * - $metadata: Rendered metadata display for the binary object.
 *
 * @see template_preprocess_islandora_newspaper_page()
 * @see theme_islandora_newspaper_page()
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-newspaper-page.css'); ?>
<?php drupal_add_js(drupal_get_path('theme', 'miletos_muteferriqa').'/js/islandora-newspaper-page.js');?>

<?php
    $isPageOf = $object->relationships->get(ISLANDORA_RELS_EXT_URI, 'isPageOf')[0]['object']['value'];
    $isPageNum = $object->relationships->get(ISLANDORA_RELS_EXT_URI, 'isSequenceNumber')[0]['object']['value'];
    $return_url = "https://" . $_SERVER['HTTP_HOST'] . "/islandora/object/" . $isPageOf . "#page/" . $isPageNum . "/mode/1up";
?>

<div class="main-viewer-menu-right">
  <ul id="menu-right" class="nav nav-tabs tabs-right">
      <li id="tabs-right-zoomin" class="anime"></li>
      <li id="tabs-right-zoomout" class="anime"></li>
      <li id="tabs-right-home" class="anime"></li>
      <li id="tabs-right-fullscreen" class="anime"></li>
      <li id="tabs-right-rotate-left" class="anime"></li>
      <li id="tabs-right-rotate-right" class="anime"></li>
  </ul>
</div>
<div class="main-viewer-menu-left">
    <ul id="menu-left">
        <li class="anime click-redirect" id="viewer-book" title="Return to newspaper view.">
            <a href="<?php echo $return_url; ?>"></a>
        </li>
        <li class="anime" id="viewer-manage" title="Manage object." data-toggle="tab" href="#detail-manage"></li>
    </ul>
    <div class="menu-left-detail">
        <a href="#" id="close-menu-left-detail"></a>
        <div class="menu-left-detail-item" id="detail-manage">
            <div class="menu-left-detail-close">
            </div>
            <div class="tab-content">
                <h4>
                    <?php echo t('Manage Object'); ?>
                </h4>
                <div class="manage-detail tab-pane fade in scrollable">
                    <ul class="manage-links">
                        <li id="manage-link">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="islandora-newspaper-object">
  <div class="islandora-newspaper-content-wrapper clearfix">
    <?php if ($content): ?>
      <div class="islandora-newspaper-content">
        <?php print $content; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
