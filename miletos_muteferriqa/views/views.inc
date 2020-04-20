$view = new view();
$view->name = 'islandora_bookmarks';
$view->description = 'Bookmarks in profile page.';
$view->tag = 'default';
$view->base_table = 'islandora_entity_bridge_mapping';
$view->human_name = 'Islandora Bookmarks';
$view->core = 7;
$view->api_version = '3.0';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

/* Display: Master */
$handler = $view->new_display('default', 'Master', 'default');
$handler->display->display_options['title'] = '<none>';
$handler->display->display_options['use_more_always'] = FALSE;
$handler->display->display_options['access']['type'] = 'role';
$handler->display->display_options['access']['role'] = array(
  2 => '2',
);
$handler->display->display_options['cache']['type'] = 'none';
$handler->display->display_options['query']['type'] = 'views_query';
$handler->display->display_options['exposed_form']['type'] = 'basic';
$handler->display->display_options['pager']['type'] = 'full';
$handler->display->display_options['pager']['options']['items_per_page'] = '10';
$handler->display->display_options['style_plugin'] = 'table';
$handler->display->display_options['style_options']['columns'] = array(
  'iebid' => 'iebid',
  'datastream_image' => 'datastream_image',
  'rendered_entity' => 'rendered_entity',
  'timestamp' => 'timestamp',
  'ops' => 'ops',
);
$handler->display->display_options['style_options']['class'] = '';
$handler->display->display_options['style_options']['default'] = '-1';
$handler->display->display_options['style_options']['info'] = array(
  'iebid' => array(
    'sortable' => 0,
    'default_sort_order' => 'asc',
    'align' => '',
    'separator' => '',
    'empty_column' => 0,
  ),
  'datastream_image' => array(
    'align' => '',
    'separator' => '',
    'empty_column' => 0,
  ),
  'rendered_entity' => array(
    'align' => '',
    'separator' => '',
    'empty_column' => 0,
  ),
  'timestamp' => array(
    'sortable' => 0,
    'default_sort_order' => 'asc',
    'align' => '',
    'separator' => '',
    'empty_column' => 0,
  ),
  'ops' => array(
    'align' => '',
    'separator' => '',
    'empty_column' => 0,
  ),
);
$handler->display->display_options['style_options']['sticky'] = TRUE;
/* No results behavior: Global: Text area */
$handler->display->display_options['empty']['area']['id'] = 'area';
$handler->display->display_options['empty']['area']['table'] = 'views';
$handler->display->display_options['empty']['area']['field'] = 'area';
$handler->display->display_options['empty']['area']['label'] = 'No bookmarks found.';
$handler->display->display_options['empty']['area']['empty'] = TRUE;
$handler->display->display_options['empty']['area']['content'] = 'You didn\'t add any object to your bookmarks yet.';
$handler->display->display_options['empty']['area']['format'] = 'plain_text';
/* Relationship: Flags: islandora_bookmark */
$handler->display->display_options['relationships']['flag_content_rel']['id'] = 'flag_content_rel';
$handler->display->display_options['relationships']['flag_content_rel']['table'] = 'islandora_entity_bridge_mapping';
$handler->display->display_options['relationships']['flag_content_rel']['field'] = 'flag_content_rel';
$handler->display->display_options['relationships']['flag_content_rel']['required'] = 0;
$handler->display->display_options['relationships']['flag_content_rel']['flag'] = 'islandora_bookmark';
/* Field: Islandora Entity Bridge Object: Islandora Entity Bridge ID */
$handler->display->display_options['fields']['iebid']['id'] = 'iebid';
$handler->display->display_options['fields']['iebid']['table'] = 'islandora_entity_bridge_mapping';
$handler->display->display_options['fields']['iebid']['field'] = 'iebid';
$handler->display->display_options['fields']['iebid']['exclude'] = TRUE;
/* Field: Islandora Entity Bridge Object: Datastream - Image */
$handler->display->display_options['fields']['datastream_image']['id'] = 'datastream_image';
$handler->display->display_options['fields']['datastream_image']['table'] = 'views_entity_islandora_entity_bridge';
$handler->display->display_options['fields']['datastream_image']['field'] = 'datastream_image';
$handler->display->display_options['fields']['datastream_image']['label'] = '';
$handler->display->display_options['fields']['datastream_image']['element_label_colon'] = FALSE;
/* Field: Islandora Entity Bridge Object: Rendered Islandora Entity Bridge Object */
$handler->display->display_options['fields']['rendered_entity']['id'] = 'rendered_entity';
$handler->display->display_options['fields']['rendered_entity']['table'] = 'views_entity_islandora_entity_bridge';
$handler->display->display_options['fields']['rendered_entity']['field'] = 'rendered_entity';
$handler->display->display_options['fields']['rendered_entity']['label'] = 'Object';
$handler->display->display_options['fields']['rendered_entity']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['rendered_entity']['link_to_entity'] = 1;
$handler->display->display_options['fields']['rendered_entity']['view_mode'] = 'full';
$handler->display->display_options['fields']['rendered_entity']['bypass_access'] = 0;
/* Field: Flags: Flagged time */
$handler->display->display_options['fields']['timestamp']['id'] = 'timestamp';
$handler->display->display_options['fields']['timestamp']['table'] = 'flagging';
$handler->display->display_options['fields']['timestamp']['field'] = 'timestamp';
$handler->display->display_options['fields']['timestamp']['relationship'] = 'flag_content_rel';
$handler->display->display_options['fields']['timestamp']['label'] = 'Bookmark Time';
$handler->display->display_options['fields']['timestamp']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['timestamp']['date_format'] = 'long';
$handler->display->display_options['fields']['timestamp']['second_date_format'] = 'long';
/* Field: Flags: Flag link */
$handler->display->display_options['fields']['ops']['id'] = 'ops';
$handler->display->display_options['fields']['ops']['table'] = 'flagging';
$handler->display->display_options['fields']['ops']['field'] = 'ops';
$handler->display->display_options['fields']['ops']['relationship'] = 'flag_content_rel';
$handler->display->display_options['fields']['ops']['label'] = '';
$handler->display->display_options['fields']['ops']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['ops']['link_type'] = 'toggle';
/* Sort criterion: Flags: Flagged time */
$handler->display->display_options['sorts']['timestamp']['id'] = 'timestamp';
$handler->display->display_options['sorts']['timestamp']['table'] = 'flagging';
$handler->display->display_options['sorts']['timestamp']['field'] = 'timestamp';
$handler->display->display_options['sorts']['timestamp']['relationship'] = 'flag_content_rel';
$handler->display->display_options['sorts']['timestamp']['order'] = 'DESC';
/* Contextual filter: Flags: User uid */
$handler->display->display_options['arguments']['uid']['id'] = 'uid';
$handler->display->display_options['arguments']['uid']['table'] = 'flagging';
$handler->display->display_options['arguments']['uid']['field'] = 'uid';
$handler->display->display_options['arguments']['uid']['relationship'] = 'flag_content_rel';
$handler->display->display_options['arguments']['uid']['default_action'] = 'default';
$handler->display->display_options['arguments']['uid']['default_argument_type'] = 'current_user';
$handler->display->display_options['arguments']['uid']['summary']['number_of_records'] = '0';
$handler->display->display_options['arguments']['uid']['summary']['format'] = 'default_summary';
$handler->display->display_options['arguments']['uid']['summary_options']['items_per_page'] = '25';
/* Filter criterion: Flags: Flagged */
$handler->display->display_options['filters']['flagged']['id'] = 'flagged';
$handler->display->display_options['filters']['flagged']['table'] = 'flagging';
$handler->display->display_options['filters']['flagged']['field'] = 'flagged';
$handler->display->display_options['filters']['flagged']['relationship'] = 'flag_content_rel';
$handler->display->display_options['filters']['flagged']['value'] = '1';

/* Display: Page */
$handler = $view->new_display('page', 'Page', 'page');
$handler->display->display_options['path'] = 'user/%/bookmarks';
$handler->display->display_options['menu']['type'] = 'tab';
$handler->display->display_options['menu']['title'] = 'Bookmarks';
$handler->display->display_options['menu']['weight'] = '0';
$handler->display->display_options['menu']['context'] = 0;
$handler->display->display_options['menu']['context_only_inline'] = 0;
$handler->display->display_options['tab_options']['title'] = 'Bookmarks';
$handler->display->display_options['tab_options']['weight'] = '0';

