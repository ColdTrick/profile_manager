<?php
	/**
	* Profile Manager
	* 
	* Toggle metadata view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$entity = $vars['entity'];
	$metadata_type = $entity->metadata_type;
	$metadata_name = $vars['metadata_name'];
	
	$types = array();
	$type_options = array();
	if($entity->getSubType() == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE){
		$types = get_register("custom_profile_field_types");
	} elseif($entity->getSubType() == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE) {
		$types = get_register("custom_group_field_types");
	}
		
	if(!empty($metadata_type) && !empty($types) && array_key_exists($metadata_type, $types)){
		$type_options = $types[$metadata_type]->children;
	}
	
	$id = $metadata_name . "_" . $entity->guid; 
	
	// if no option is available in the register, this metadata field can't be toggled
	if(!empty($type_options) && array_key_exists($metadata_name, $type_options) && $type_options[$metadata_name]){
		if($entity->$metadata_name != "yes"){
			$class = " metadata_config_right_status_disabled";
		} else {
			$class = " metadata_config_right_status_enabled";
		}
		$title = elgg_echo('profile_manager:admin:' . $metadata_name);
		$onclick = "onclick='toggleOption(\"" . $metadata_name . "\", " . $entity->guid . "); return false;'";
	} else {
		$title = elgg_echo('profile_manager:admin:option_unavailable');
	}
	echo "<span title='" . $title . "' class='metadata_config_right_status" . $class . "' id='" . $id . "' " . $onclick . "></span>";
?>