$flags = array();
// Exported flag: "islandora bookmark".
$flags['islandora_bookmark'] = array (
  'entity_type' => 'islandora_entity_bridge',
  'title' => 'islandora bookmark',
  'global' => '0',
  'types' => 
  array (
    0 => 'islandora:bookCModel',
    1 => 'islandora:newspaperIssueCModel',
  ),
  'flag_short' => 'Add this object to my bookmarks.',
  'flag_long' => 'Add this object to my bookmarks.',
  'flag_message' => 'Added.',
  'unflag_short' => 'Remove this object from my bookmarks.',
  'unflag_long' => 'Remove this object from my bookmarks.',
  'unflag_message' => 'Removed.',
  'unflag_denied_text' => '',
  'link_type' => 'toggle',
  'weight' => 0,
  'show_in_links' => 
  array (
    'full' => 'full',
    'teaser' => 0,
    'preview' => 0,
    'token' => 0,
  ),
  'show_as_field' => 0,
  'show_on_form' => 0,
  'access_author' => '',
  'show_contextual_link' => 0,
  'api_version' => 3,
);
return $flags;

