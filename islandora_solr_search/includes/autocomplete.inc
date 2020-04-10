<?php

function islandora_autocomplete_callback($term) {
    
    $query_fields = ["mods_titleInfo_title_all_mt", "mods_name_personal_namePart_mt", "mods_name_aut_namePart_mt"];
    $query = "";
    $metachars = ['"', '*', '~'];
    if (stripos(json_encode($metachars), $term) !== true) {
        $term = str_replace($metachars, "", $term);
    }

    foreach ($query_fields as $qf) {
        $query .= $qf . ":*" . $term . "*\n";        
    }

    $islandora_solr_query = new IslandoraSolrQueryProcessor();
    $islandora_solr_query->buildQuery($query);
    $islandora_solr_query->solrParams['fl'] = ["mods_titleInfo_title_all_mt", "mods_name_personal_namePart_mt", "mods_name_aut_namePart_mt", "PID"];
    $islandora_solr_query->solrParams['fq'] = "-RELS_EXT_isPageOf_uri_ms:[* TO *]";
    $islandora_solr_query->solrParams['hl.fl'] = $query_fields;
    $islandora_solr_query->solrParams['defType'] = "edismax";
    $islandora_solr_query->solrParams['facet'] = "false";
    $islandora_solr_query->solrParams['hl.simple.pre'] = "<strong>";
    $islandora_solr_query->solrParams['hl.simple.post'] = "</strong>";
    $islandora_solr_query->solrParams['omitHeader'] = "true";
    $islandora_solr_query->solrParams['hl.preserveMulti'] = "true";
    $islandora_solr_query->solrLimit = 5;
    $islandora_solr_query->solrStart = 0;
    $islandora_solr_query->executeQuery(FALSE);

    $response = $islandora_solr_query->islandoraSolrResult;
    //drupal_json_output($response);
    $numOfResults = $response['response']['numFound'];
    $raw_results = $response['response']['objects'];
    $highlights = $response['highlighting'];

    $results = [];
    $result = [
        "link" => "",
        "value" => "",
        "fields" => ["rendered_entity" => ""],
    ];
   
    // No result. 
    if ($numOfResults == "0") {

	    $result["link"] = "<a href='/islandora/search/" . $term . "?type=edismax'></a>";
        $result["value"] = "No results found for $term. Click to perform full search.";
        $result["fields"]["rendered_entity"] = "<a href='/islandora/search/*" . $term . "*?type=edismax'>" . $result["value"] . "</a>";
        array_push($results, $result);

    } else {

	    foreach($raw_results as $raw_result) {

	        $pid = $raw_result['solr_doc']['PID'];

    	    if (array_key_exists($pid, $highlights)) {
                $titles = implode(", ", $highlights[$pid]['mods_titleInfo_title_all_mt']);

                $hnames1 = $highlights[$pid]['mods_name_personal_namePart_mt'];
                $hnames2 = $highlights[$pid]['mods_name_aut_namePart_mt'];

                if (sizeof($hnames1) > sizeof($hnames2)) {
                    $names = implode(", ", $hnames1);
                } else {
                    $names = implode(", ", $hnames2);
                }

          	} else {
                $titles = implode(", ", $raw_result['solr_doc']['mods_titleInfo_title_all_mt']);

                $names1 = $raw_result['solr_doc']['mods_name_personal_namePart_mt'];
                $names2 = $raw_result['solr_doc']['mods_name_aut_namePart_mt'];

                if (sizeof($names1) > sizeof($names2)) {
                    $names = implode(", ", $names1);
                } else {
                    $names = implode(", ", $names2);
                }

            }

            $result["link"] = $raw_result['object_url'];
            $result["value"] = $titles . " | <em>" . $names . "</em>";
            $result["fields"]["rendered_entity"] = '<a href="/' . $raw_result['object_url'] . '">' . $result["value"] . '</a>';
            array_push($results, $result);
        }
	// # of results is more than rows.
	if ($numOfResults > $params['rows']) {
	    $result["link"] = "view-all";
	    $result["value"] = "View all results for $term.";
	    $result["fields"]["rendered_entity"] = "<a href='/islandora/search/*" . $term . "*?type=edismax'>" . $result["value"] . "</a>";
	    array_push($results, $result);
        }
    }
    drupal_json_output($results);
    return;
}

?>
