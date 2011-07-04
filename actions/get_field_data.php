<?php 
	/**
	* Profile Manager
	* 
	* jQuery profile field data retrieval
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	admin_gatekeeper();
	
	$guid = get_input("guid");
	if(!empty($guid) && ($field = get_entity($guid))){
		if($field->getSubtype() == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $field->getSubtype() == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
		
			// build array
			$result = array();
			$result['guid'] = $field->guid;
			$result['metadata_type'] = $field->metadata_type;
			$result['metadata_name'] = $field->metadata_name;
			$result['metadata_label'] = $field->metadata_label;
			$result['metadata_hint'] = $field->metadata_hint;
			$result['metadata_options'] = $field->metadata_options;
			$result['show_on_register'] = $field->show_on_register;
			$result['mandatory'] = $field->mandatory;
			$result['user_editable'] = $field->user_editable;
			$result['output_as_tags'] = $field->output_as_tags;
			$result['admin_only'] = $field->admin_only;
			$result['simple_search'] = $field->simple_search;
			$result['advanced_search'] = $field->advanced_search;
			$result['blank_available'] = $field->blank_available;
		
			// export to json
			$result = json_encode($result);

			// Send correct headers
			header("Content-Type: application/json; charset=UTF-8");
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
			
			// echo data
			echo $result;
		}
	}
	exit();
?>