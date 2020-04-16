<?php
/**
 * @file
 * Template file to style output.
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/islandora-book-book.css'); ?>
<?php drupal_add_js(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/js/islandora-book-book.js'); ?>
<?php
    $module_path = drupal_get_path('module', 'islandora_openseadragon');
    $library_path = libraries_get_path('openseadragon');
    drupal_add_js("$library_path/openseadragon.js", array('weight' => -4));
    drupal_add_js("$module_path/js/djtilesource.js", array('weight' => -3));
 ?>

<div id="bookReaderContainer">
<?php if (isset($viewer)): ?>
    <div id="book-viewer">
        <?php print $viewer; ?>
        <button id="menu-bottom-toggler" type="button" class="btn btn-default"></button>
    </div>
    <div id ="viewer-toolbar">
        <ul id="menu-bottom-object">
            <li class="BRicon metadata anime" data-toggle="modal" data-target="#metadata-modal" title="<?php echo t('Metadata'); ?>"></li>
            <li class="BRicon similaritems anime" data-toggle="modal" data-target="#mlt-modal" title="<?php echo t('Similar Items'); ?>"></li>
            <li class="BRicon book_page anime" data-toggle="modal" data-target="#pagemodal" title="<?php echo t('Page Mode'); ?>" ></li>
            <li class="BRicon searchin anime" data-toggle="modal" data-target="#searchin-modal" title="<?php echo t('Search in text'); ?>"></li>
            <li class="BRicon flag_bookmark anime" title="">
                <?php
                    $pid =  str_replace('islandora:', '', $object->id);
                    $res = db_query("select * from islandora_entity_bridge_mapping where pid LIKE '%" . $pid . "%'");
                    $record = $res->fetchAssoc();
                ?>
                <?php print flag_create_link('islandora_bookmark', $record['iebid']); ?>
            </li>
        </ul>
        <ul id="menu-bottom-viewer" class="nav nav-tabs tabs-right">
            <li class="BRicon zoom_in anime" title="<?php echo t('Zoom in'); ?>"></li>
            <li class="BRicon zoom_out anime" title="<?php echo t('Zoom out'); ?>"></li>
            <li class="BRicon anime" id="prev-book-search-match" title="<?php echo t('Flip left'); ?>"></li>
            <li class="BRicon anime" id="next-book-search-match" title="<?php echo t('Flip right'); ?>"></li>
        </ul>
    </div>

    <div id="metadata-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Metadata</h4>
                </div>
                <div class="modal-body">
                    <?php print $metadata; ?>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified">
                        <button id="metadata-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#metadata-modal"><?php echo t("Metadata"); ?></button>
                        <button id="mlt-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#mlt-modal"><?php echo t("Similar Items"); ?></button>
                        <button id="search-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#searchin-modal"><?php echo t("Search in object"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mlt-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Similar Items</h4>
                </div>
                <div class="modal-body">
                    <?php
                            $object_id = $object->id;
                            $url = $_SERVER['SERVER_ADDR'] . ':8080/solr/collection1/mlt?q=PID:%22' . $object_id . '%22&fq=RELS_EXT_hasModel_uri_s:"info:fedora/islandora:bookCModel"&rows=3&fl=PID,mods_titleInfo_title_mt,mods_name_namePart_mt,mods_originInfo_dateCreated_t&wt=json&indent=true';
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
                                    array_push($dates, $result['mods_originInfo_dateCreated_t']);
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
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified">
                        <button id="metadata-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#metadata-modal"><?php echo t("Metadata"); ?></button>
                        <button id="mlt-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#mlt-modal"><?php echo t("Similar Items"); ?></button>
                        <button id="search-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#searchin-modal"><?php echo t("Search in object"); ?></button>
                    </div>
                </div>
            </div>
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
                    <div id="islandora-openseadragon"></div>
                    <ul id="openseadragon-menu" class="nav nav-tabs tabs-right">
                        <li id="tabs-right-zoomin" class="anime" title='<?php echo t("Zoom in"); ?>'></li>
                        <li id="tabs-right-zoomout" class="anime" title='<?php echo t("Zoom out"); ?>'></li>
                        <li id="tabs-right-home" class="anime" title='<?php echo t("Return to home"); ?>'></li>
                        <li id="tabs-right-rotate-left" class="anime" title='<?php echo t("Rotate left"); ?>'></li>
                        <li id="tabs-right-rotate-right" class="anime" title='<?php echo t("Rotate right"); ?>'></li>
                        <li id="tabs-right-highlight" class="anime" title='<?php echo t("Toggle highlights"); ?>'></li>
                    </ul>
                </div>
                <div class="modal-footer">
                        <button id="prev-match" class="btn btn-primary"><?php echo t("Previous Match"); ?></button>
                        <button id="next-match" class="btn btn-primary"><?php echo t("Next Match"); ?></button>
                        <button id="prev-page" class="btn btn-primary"><?php echo t("Previous Page"); ?></button>
                        <button id="next-page" class="btn btn-primary"><?php echo t("Next Page"); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="searchin-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search in object</h4>
                </div>
                <div class="modal-body">
                    <div class="menu-right-detail"></div>
                    <hr>
                    <div id="on-screen-keyboard">
                        <button class="ota-keyboard btn btn-default character" value="ا">ا</button>
                        <button class="ota-keyboard btn btn-default character" value="ب">ب</button>
                        <button class="ota-keyboard btn btn-default character" value="پ">پ</button>
                        <button class="ota-keyboard btn btn-default character" value="ت">ت</button>
                        <button class="ota-keyboard btn btn-default character" value="ث">ث</button>
                        <button class="ota-keyboard btn btn-default character" value="ج">ج</button>
                        <button class="ota-keyboard btn btn-default character" value="چ">چ</button>
                        <button class="ota-keyboard btn btn-default character" value="ح">ح</button>
                        <button class="ota-keyboard btn btn-default character" value="خ">خ</button>
                        <button class="ota-keyboard btn btn-default character" value="د">د</button>
                        <button class="ota-keyboard btn btn-default character" value="ذ">ذ</button>
                        <button class="ota-keyboard btn btn-default character" value="ر">ر</button>
                        <button class="ota-keyboard btn btn-default character" value="ل">ل</button>
                        <button class="ota-keyboard btn btn-default character" value="ز">ز</button>
                        <button class="ota-keyboard btn btn-default character" value="ژ">ژ</button>
                        <button class="ota-keyboard btn btn-default character" value="س">س</button>
                        <button class="ota-keyboard btn btn-default character" value="ش">ش</button>
                        <button class="ota-keyboard btn btn-default character" value="ص">ص</button>
                        <button class="ota-keyboard btn btn-default character" value="ض">ض</button>
                        <button class="ota-keyboard btn btn-default character" value="ط">ط</button>
                        <button class="ota-keyboard btn btn-default character" value="ظ">ظ</button>
                        <button class="ota-keyboard btn btn-default character" value="ع">ع</button>
                        <button class="ota-keyboard btn btn-default character" value="غ">غ</button>
                        <button class="ota-keyboard btn btn-default character" value="ك">ك</button>
                        <button class="ota-keyboard btn btn-default character" value="م">م</button>
                        <button class="ota-keyboard btn btn-default character" value="ن">ن</button>
                        <button class="ota-keyboard btn btn-default character" value="و">و</button>
                        <button class="ota-keyboard btn btn-default character" value="ه">ه</button>
                        <button class="ota-keyboard btn btn-default character" value="ﻻ">ﻻ</button>
                        <button class="ota-keyboard btn btn-default character" value="ي">ي</button>
                        <button class="ota-keyboard btn btn-default character" value="ف">ف</button>
                        <button class="ota-keyboard btn btn-default character" value="ق">ق</button>
                        <button class="ota-keyboard btn btn-default character" value="ؤ">ؤ</button>
                        <button class="ota-keyboard btn btn-default character" value="ء">ء</button>
                        <button class="ota-keyboard btn btn-default character" value=" ً"> ً</button>
                        <button class="ota-keyboard btn btn-default character" value="ة">ة</button>
                        <button class="ota-keyboard btn btn-default character" value="ئ">ئ</button>
                        <button class="ota-keyboard btn btn-default character" value="ى">ى</button>
                        <button class="ota-keyboard btn btn-default character" value="ۀ">ۀ</button>
                        <button class="ota-keyboard btn btn-default character" value="گ">گ</button>
                        <button class="ota-keyboard btn btn-default character" value="ڭ">ڭ</button>
                        <button class="ota-keyboard btn btn-default character" value="إ">إ</button>
                        <button class="ota-keyboard btn btn-default character" value="أ">أ</button>
                        <button class="ota-keyboard btn btn-default character" value="آ">آ</button>
                        <button class="ota-keyboard btn btn-default character" value="٠">٠</button>
                        <button class="ota-keyboard btn btn-default character" value="١">١</button>
                        <button class="ota-keyboard btn btn-default character" value="٢">٢</button>
                        <button class="ota-keyboard btn btn-default character" value="٣">٣</button>
                        <button class="ota-keyboard btn btn-default character" value="٤">٤</button>
                        <button class="ota-keyboard btn btn-default character" value="٥">٥</button>
                        <button class="ota-keyboard btn btn-default character" value="٦">٦</button>
                        <button class="ota-keyboard btn btn-default character" value="٧">٧</button>
                        <button class="ota-keyboard btn btn-default character" value="٨">٨</button>
                        <button class="ota-keyboard btn btn-default character" value="٩">٩</button>
                        <button class="ota-keyboard btn btn-default character" value="" id="ota-keyboard-delete" title="Delete last character."><i class="fa fa-eraser" aria-hidden="true"></i></button>
                        <button class="ota-keyboard btn btn-default character" value="" id="ota-keyboard-trash" title="Delete all characters."><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        <button class="ota-keyboard btn btn-default character" value="*">*</button>
                        <button class="ota-keyboard btn btn-default character" value='"'>"</button>
                        <button class="ota-keyboard btn btn-default character" value="~">~</button>
                        <button class="ota-keyboard btn btn-default character" value=" " id="ota-keyboard-space">&bbrk;</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified">
                        <button id="metadata-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#metadata-modal"><?php echo t("Metadata"); ?></button>
                        <button id="mlt-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#mlt-modal"><?php echo t("Similar Items"); ?></button>
                        <button id="search-call" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#searchin-modal"><?php echo t("Search in object"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
</div>
