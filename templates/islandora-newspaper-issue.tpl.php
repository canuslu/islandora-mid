<?php

/**
 * @file
 * This is the template file for the object page for a newspaper issue.
 *
 * Available variables:
 * - $object: The newspaper issue object.
 * - $pages: Pages of this object in order.
 * - $description: Rendered metadata descripton for the object.
 * - $metadata: Rendered metadata display for the binary object.
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/islandora-newspaper-issue.css'); ?>
<?php drupal_add_js(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/js/islandora-newspaper-issue.js');?>

<?php
    $module_path = drupal_get_path('module', 'islandora_openseadragon');
    $library_path = libraries_get_path('openseadragon');
    drupal_add_js("$library_path/openseadragon.js", array('weight' => -4));
    drupal_add_js("$module_path/js/djtilesource.js", array('weight' => -3));
 ?>

<div class="islandora-newspaper-issue clearfix">
    <div id="bookReaderContainer">
    <?php if (isset($viewer)): ?>
    <div id="book-viewer">
        <?php print $viewer; ?>
    </div>

    <div class="main-viewer-menu-right">
        <ul id="menu-right" class="nav nav-tabs tabs-right">
            <li class="BRicon searchin anime" title="<?php echo t('Search in text'); ?>"></li>
            <ul class="BRicon display-wrapper" title="<?php echo t('Change display mode'); ?>">
                <li class="BRicon twopg anime" title="<?php echo t('Two-page view'); ?>"></li>
                <li class="BRicon onepg anime" title="<?php echo t('One-page view'); ?>"></li>
                <li class="BRicon thumb anime" title="<?php echo t('Thumbnail view'); ?>"></li>
            </ul>
            <li class="BRicon zoom_in anime" title="<?php echo t('Zoom in'); ?>"></li>
            <li class="BRicon zoom_out anime" title="<?php echo t('Zoom out'); ?>"></li>
            <li class="BRicon book_left anime" title="<?php echo t('Flip left'); ?>"></li>
            <li class="BRicon book_right anime" title="<?php echo t('Flip right'); ?>"></li>
            <li class="BRicon book_page anime" title="<?php echo t('Page Mode'); ?>" data-toggle="modal" data-target="#pagemodal"></li>
        </ul>
        <div class="menu-right-detail active">
        </div>
    </div>

    <div id="pagemodal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="main-viewer-menu-right">
                        <ul id="menu-right" class="nav nav-tabs tabs-right">
                            <li id="tabs-right-zoomin" class="anime" title='<?php echo t("Zoom in"); ?>'></li>
                            <li id="tabs-right-zoomout" class="anime" title='<?php echo t("Zoom out"); ?>'></li>
                            <li id="tabs-right-home" class="anime" title='<?php echo t("Return to home"); ?>'></li>
                            <li id="tabs-right-fullscreen" class="anime" title='<?php echo t("Togge fullscreen"); ?>'></li>
                            <li id="tabs-right-rotate-left" class="anime" title='<?php echo t("Rotate left"); ?>'></li>
                            <li id="tabs-right-rotate-right" class="anime" title='<?php echo t("Rotate right"); ?>'></li>
                            <li id="tabs-right-highlight" class="anime" title='<?php echo t("Toggle highlights"); ?>'></li>
                        </ul>
                    </div>
                    <div id="islandora-openseadragon">

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="match-wrapper col-md-4">
                        <button id="prev-match" class="btn btn-primary"><?php echo t("Previous Match"); ?></button>
                        <button id="next-match" class="btn btn-primary"><?php echo t("Next Match"); ?></button>
                    </div>
                    <div class="return-book-viewer col-md-4">
                        <button id="return-book-viewer" class="btn btn-primary"><?php echo t("Return to Book View"); ?></button>
                    </div>
                    <div class="page-wrapper col-md-4">
                        <button id="prev-page" class="btn btn-primary"><?php echo t("Previous Page"); ?></button>
                        <button id="next-page" class="btn btn-primary"><?php echo t("Next Page"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-viewer-menu-left">
        <ul id="menu-left">
            <li class="active anime" id="viewer-info" data-toggle="tab" href="#detail-info"></li>
            <li class="anime click-redirect" id="viewer-pages" title="See all pages."><a href="/islandora/object/<?php echo $object->id; ?>/issue_pages"></a></li>
            <li class="anime" id="viewer-mlt" title="See similar items." data-toggle="tab" href="#detail-mlt"></li>
            <li class="anime click-redirect" id="viewer-bookmark">
                <?php
                    $pid =  str_replace('islandora:', '', $object->id);
                    $res = db_query("select * from islandora_entity_bridge_mapping where pid LIKE '%" . $pid . "%'");
                    $record = $res->fetchAssoc();
                ?>
                <?php print flag_create_link('islandora_bookmark', $record['iebid']); ?>
            </li>
            <li class="anime" id="viewer-manage" title="Manage object." data-toggle="tab" href="#detail-manage"></li>
        </ul>
        <div class="menu-left-detail">
            <a href="#" id="close-menu-left-detail"></a>
            <div class="menu-left-detail-item active" id="detail-info">
                <div class="menu-left-detail-close">
                </div>
                <div class="tab-content">
                    <h4>
                        <?php echo t('Metadata'); ?>
                    </h4>
                    <div id="home" class="info-detail tab-pane fade in active scrollable">
                        <?php print $metadata; ?>
                    </div>
                </div>
            </div>
            <div class="menu-left-detail-item" id="detail-mlt">
                <div class="menu-left-detail-close"></div>
                <div class="tab-content">
                    <h4>
                        <?php echo t('Similar Items'); ?>
                    </h4>
                    <div id="mlt" class="info-mlt tab-pane fade in scrollable">
                        <?php
                            $object_id = $object->id;
                            $url = $_SERVER['SERVER_ADDR'] . ':8080/solr/collection1/mlt?q=PID:%22' . $object_id . '%22&fq=RELS_EXT_hasModel_uri_s:"info:fedora/islandora:newspaperIssueCModel"&rows=3&fl=PID,mods_titleInfo_title_mt,mods_name_namePart_mt,mods_originInfo_dateIssued_t&wt=json&indent=true';
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            $data = json_decode(curl_exec($curl), true);

                            if ($data['response']['numFound'] == 0) {
                                echo "<p class='mlt-not-found'>No similar items found.</p>";
                            } else {
                                $pids = array();
                                $names = array();
                                $creators = array();
                                $dates = array();
                                mb_internal_encoding("UTF-8");

                                foreach ($data['response']['docs'] as $result) {
                                    array_push($pids, $result['PID']);
                                    array_push($dates, $result['mods_originInfo_dateIssued_t']);
                                    array_push($names, implode(", ", $result['mods_titleInfo_title_mt']));
                                    array_push($creators, implode(", ", $result['mods_name_namePart_mt']));
                                }

                                echo "<ul class='list-of-mlt'>";
                                for ($i = 0; $i < count($pids); $i++) {
                                    echo "<li class='mlt-item'>";
                                    echo "<span class='mlt-item-title'><a href='/islandora/object/" . $pids[$i] . "'>" . $names[$i] . "</a></span><br>";
                                    echo "<span class='mlt-item-creator'>" . $creators[$i] . "</span><br>";
                                    echo "<span class='mlt-item-date'>" . $dates[$i] ."</span>";
                                    echo "</li><hr>";
                                }
                                echo "</ul>";
                            }
                        ?>
                    </div>
                </div>
            </div>
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

    <?php endif; ?>
    </div>
</div>
