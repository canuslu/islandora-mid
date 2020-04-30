<?php

function zoom_islandora_object($islandora_object) {

    module_load_include('inc', 'islandora_openseadragon', 'includes/utilities');

    $library_path = libraries_get_path('openseadragon');

    $variables['pid'] = $islandora_object->id;
    $variables['pidEncoded'] = urlencode($variables['pid']);

    module_load_include('inc', 'islandora', 'includes/authtokens');
    $token = islandora_get_object_token($variables['pid'], "JP2", 2);
    $variables['token'] = $token;

    $variables['tile_sources'] = islandora_openseadragon_tile_source($variables['pid'], "JP2", $variables['token']);

    $variables['id'] = $variables['viewer_id'] = 'islandora-openseadragon';

    $variables['settings'] = array(
        'pid' => $variables['pid'],
        'imageServer' => variable_get('islandora_openseadragon_tilesource', 'djatoka'),
        'djatokaServerBaseURL' => url(variable_get('islandora_openseadragon_djatoka_url', 'adore-djatoka/resolver'), array('absolute' => TRUE)),
        'iiifServerBaseURL' => url(variable_get('islandora_openseadragon_iiif_url', 'iiif')),
        'fitToAspectRatio' => variable_get('islandora_openseadragon_fit_to_aspect_ratio', FALSE),
        'options' => array(
            'id' => $variables['id'],
            'prefixUrl' => file_create_url("{$library_path}/images/"),
            'tileSources' => $variables['tile_sources'],
            'overlays' => islandora_openseadragon_viewer_query_solr_for_overlays($variables['pid']),
        ) + islandora_openseadragon_get_settings(),
    );

    if (isset($variables['token_header']) && isset($variables['token']) && $variables['token_header']) {
        $variables['settings']['options']['loadTilesWithAjax'] = TRUE;
        $variables['settings']['options']['ajaxHeaders'] = array(
            'X-ISLANDORA-TOKEN' => $variables['token'],
        );
    }

    drupal_add_js(array(
        'islandoraOpenSeadragon' => $variables['settings'],
    ), 'setting');

    drupal_add_js("$library_path/openseadragon.js", array('weight' => -4));
    if (islandora_openseadragon_use_djatoka_server()) {
        drupal_add_js("$module_path/js/djtilesource.js", array('weight' => -3));
    }
    drupal_add_js("$module_path/js/islandora_openseadragon.js", array('weight' => -2));

    drupal_json_output($variables);
    return;

}

?>
