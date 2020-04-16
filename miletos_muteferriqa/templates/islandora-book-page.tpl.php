<?php
/**
 * @file
 * Template file to style output.
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/islandora-book-page.css'); ?>
<?php drupal_add_js(drupal_get_path('theme', 'miletos_muteferriqa').'/js/islandora-book-page.js');?>
<?php
    $isPageOf = $object->relationships->get(ISLANDORA_RELS_EXT_URI, 'isPageOf')[0]['object']['value'];
    $isPageNum = $object->relationships->get(ISLANDORA_RELS_EXT_URI, 'isSequenceNumber')[0]['object']['value'];
    $return_url = "/islandora/object/" . $isPageOf . "#page/" . $isPageNum . "/mode/1up";
?>

<?php if (isset($viewer)): ?>
  <div id="book-page-viewer">
    <?php print $viewer; ?>
  </div>
<?php elseif (isset($object['JPG']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['JPG'])): ?>
  <div id="book-page-image">
    <?php
      $params = array(
        'path' => url("islandora/object/{$object->id}/datastream/JPG/view"),
        'attributes' => array(),
      );
      print theme('image', $params);
    ?>
  </div>
<?php endif; ?>
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
        <li class="anime click-redirect" id="viewer-book" title="Return to book view.">
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
<!-- @todo Add table of metadata values -->
