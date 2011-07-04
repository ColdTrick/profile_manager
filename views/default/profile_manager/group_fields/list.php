<?php 
	/**
	* Profile Manager
	* 
	* Group Fields list view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	global $CONFIG;
	
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid
		);
		
	$count = elgg_get_entities($options);
    
	$ordered = array();
	if($count > 0){	
		$options["count"] = false;
		$options["limit"] = $count;
			
		$fields = elgg_get_entities($options);
		
		foreach($fields as $field){
			$ordered[$field->order] = $field;
		}
		
		ksort($ordered);
	}
	
	$list = elgg_view_entity_list($ordered, $count, 0, $count, false, false, false);
	
?>
<div id="custom_fields_ordering" class="custom_fields_ordering_group">
	<?php echo $list; ?>
</div>