<?php 
	global $CONFIG;
	
	$offset = sanitise_int(get_input("offset", 0));
	$limit = sanitise_int(get_input("limit", 10));
	
	$sorting = sanitise_string(get_input("sorting", "newest"));
	$user_data_partial_search_criteria = get_input("user_data_partial_search_criteria", false);
	$meta_data_array_search_criteria = get_input("meta_data_array_search_criteria", false, false); // no filtering because get_input does not support filtering of nested arrays
	$meta_data_partial_search_criteria = get_input("meta_data_partial_search_criteria", false);
	$meta_data_exact_search_criteria = get_input("meta_data_exact_search_criteria", false);
	$meta_data_between_search_criteria = get_input("meta_data_between_search_criteria", false, false);  // no filtering because get_input does not support filtering of nested arrays
	
	$where = array();
	
	$meta_array = array();
	
	// meta_data_array contains all stuff that requires a complete (multi)hit on a metadata value
	if(!empty($meta_data_array_search_criteria)){
		foreach($meta_data_array_search_criteria as $field_name => $field_value){
			if(!empty($field_value)){
				foreach($field_value as $key => $value){
					$field_value[$key] = "'" . sanitise_string($value) . "'";
				}
				$meta_name_id = get_metastring_id($field_name);
				$filter = implode(",", $field_value);
				$meta_array[$meta_name_id] = "IN (" . $filter . ")";
			}
		}	
	}
	
	// user partial hit
	if(!empty($user_data_partial_search_criteria)){
		foreach($user_data_partial_search_criteria as $field_name => $field_value){
			if(!empty($field_value)){
				$where[] = "u." . sanitise_string($field_name) . " like '%" . sanitise_string($field_value) . "%'";
			}
		}
	}
	
	// meta_data_partial_search_criteria
	if(!empty($meta_data_partial_search_criteria)){
		foreach($meta_data_partial_search_criteria as $field_name => $field_value){
			if(!empty($field_value)){
				$meta_name_id = get_metastring_id(sanitise_string($field_name));
				$meta_array[$meta_name_id] = "like '%" . sanitise_string($field_value) . "%'";
			}
		}
	}
	
	// meta_data_exact_search_criteria
	if(!empty($meta_data_exact_search_criteria)){
		foreach($meta_data_exact_search_criteria as $field_name => $field_value){
			if(!empty($field_value)){
				$meta_name_id = get_metastring_id(sanitise_string($field_name));
				$meta_array[$meta_name_id] = "= '" . sanitise_string($field_value) . "'";
			}
		}
	}
	
	// meta_data_between_search_criteria
	if(!empty($meta_data_between_search_criteria)){
		foreach($meta_data_between_search_criteria as $field_name => $field_value){
			if(!empty($field_value) && (!empty($field_value['FROM']) || !empty($field_value['TO']))) {
				$meta_name_id = get_metastring_id(sanitise_string($field_name));
				$from = sanitise_string($field_value['FROM']);
				$to = sanitise_string($field_value['TO']);
				
				if(!empty($from) && !empty($to)){
					$record_filter = "BETWEEN " . $from . " AND " . $to; 
				} elseif(!empty($from)) {
					$record_filter = ">= " . $from;
				} else {
					$record_filter = "<= " . $to;
				}
				
				$meta_array[$meta_name_id] = $record_filter;
			}
		}
	}
	
	$mindex = 1;
	$join = "";
	$metawhere = array();
	if(count($meta_array) > 0){
		foreach($meta_array as $meta_name_id => $meta_value) { 
			$join .= " JOIN (SELECT subm{$mindex}.*, s{$mindex}.string FROM {$CONFIG->dbprefix}metadata subm{$mindex} JOIN {$CONFIG->dbprefix}metastrings s{$mindex} ON subm{$mindex}.value_id = s{$mindex}.id) AS m{$mindex} ON e.guid = m{$mindex}.entity_guid ";
			$metawhere[] = "(m{$mindex}.name_id='$meta_name_id' AND m{$mindex}.string " . $meta_value . ")";
			$mindex++;
		}
		$where[] = "(" . implode(" and ", $metawhere) . ")";
	}
	
	//sorting
	switch ($sorting ) {
	    case "alphabetic":
	    	$order = "u.name";
	        break;
	    case "popular":
	    	$select = "e.*, count(e.guid) as total"; 
	    	$join .= " JOIN {$CONFIG->dbprefix}entity_relationships r ON e.guid = r.guid_two";
			$where[] = "r.relationship='friend'";
	    	$group_by = " group by e.guid ";
			$order = "total desc";
			break;
	    case "online":
			$time = time() - 600;
			$where[] = "u.last_action >= {$time}";
			$order = "u.last_action desc";
			break;
	    default:
	    	$order = "e.time_created desc";
	    	break;
	}
	
	// limit to current site
	$join .= " JOIN {$CONFIG->dbprefix}entity_relationships site_relation ON e.guid = site_relation.guid_one";
	$where[] = "site_relation.relationship='member_of_site'";
	$where[] = "site_relation.guid_two = " . $CONFIG->site_guid;
	
	// build where clauses
	if(count($where) > 0){
		foreach ($where as $w){
	    	$where_clause .= " $w and ";
		}
	} 
	
	// add access
	$access_suffix .= get_access_sql_suffix("e"); // Add access controls

	for($mindex = 1; $mindex <= count($meta_array); $mindex++){
		$access_suffix .= ' and ' . get_access_sql_suffix("m{$mindex}"); // Add access controls
	}
	
	if(empty($select)){
		$select = "distinct e.*";
	}
	
	// extend with hooks
	$join = trigger_plugin_hook("extend_join", "profile_manager_member_search", null, $join);
	$order = trigger_plugin_hook("extend_order", "profile_manager_member_search", null, $order);
	$select = trigger_plugin_hook("extend_select", "profile_manager_member_search", null, $select);
	$where_clause = trigger_plugin_hook("extend_where", "profile_manager_member_search", null, $where_clause);
	
	// build query
	$query = "from {$CONFIG->dbprefix}entities e join {$CONFIG->dbprefix}users_entity u on e.guid = u.guid {$join} where " . $where_clause . $access_suffix;
	
	// execute query and retrieve entities
	$count = get_data_row("SELECT count(distinct e.guid) as total " . $query);
	$count = $count->total;
	
	if(!empty($order)){
		$order = " order by " . $order;
	}
	
	
	$query = "SELECT " . $select . " " . $query . " " . $group_by . $order . " limit {$offset},{$limit}";
	
	$entities = get_data($query, "entity_row_to_elggstar");

	// present it
	echo "<div class='contentWrapper'>";
	echo "<h3 class='settings'>" . elgg_echo("profile_manager:members:searchresults:title") . "</h3>";
	
	if($count > 0){		
		$nav = elgg_view('profile_manager/members/pagination',array(
				'function_name' => "navigate_members_search",
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit
						));
						
		$list = elgg_view_entity_list($entities, $count, $offset, $limit, false, false, false);
		echo "</div>";
		
		echo $nav;
		echo $list;
		echo $nav;
	} else {
		
		echo elgg_echo("profile_manager:members:searchresults:noresults");
		echo "</div>";
	}
	
	if(isadminloggedin()){
		echo "<div class='contentWrapper' id='members_search_result_query'><h3 class='settings'>" . elgg_echo("profile_manager:members:searchresults:query") . "</h3>";
		echo $query;
		echo "</div>";
	}
	
	echo "<script type='text/javascript'>setup_avatar_menu();</script>";
?>