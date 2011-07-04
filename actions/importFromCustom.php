<?php
	/**
	* Profile Manager
	* 
	* Action to import from 'default' custom profile fields
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	global $CONFIG;

	admin_gatekeeper();
		
	$n = 0;	
	$skipped = 0;
	
	$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				"count" => true,
				"owner_guid" => $CONFIG->site_guid
			);
	
	$max_fields = elgg_get_entities($options) + 1;
			
	while ($translation = get_plugin_setting("admin_defined_profile_$n", 'profile')){
		$metadata_name = "admin_defined_profile_$n";
		$metadata_label = $translation;
		
		$type = get_plugin_setting("admin_defined_profile_type_$n", 'profile');
		if (empty($type)){
			$type = 'text';
		}
		$metadata_type = $type;
		
		$options["metadata_name_value_pairs"] = array("name" => "metadata_name", "value" => $metadata_name);
			
		$count = elgg_get_entities_from_metadata($options);
		
		if($count == 0){
			$field = new ProfileManagerCustomProfileField();
					
			$field->save();
			
			$field->metadata_name = $metadata_name;
			$field->metadata_label = $metadata_label;
			$field->metadata_type = $metadata_type;
			
			$field->show_on_register = "no";
			$field->mandatory = "no";
			$field->user_editable = "yes";
			
			$field->order = $max_fields;
			
			$field->save();
			
			$max_fields++;
		} else {
			$skipped++;
		}	
		$n++;
	}
	
	if(($n - $skipped) == 0){
		register_error(elgg_echo("profile_manager:actions:import:from_custom:no_fields"));
	} else {
		system_message(sprintf(elgg_echo("profile_manager:actions:import:from_custom:new_fields"), $n - $skipped));
	}
	
	forward($_SERVER['HTTP_REFERER']);
?>