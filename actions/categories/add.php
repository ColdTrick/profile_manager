<?php 
	/**
	* Profile Manager
	* 
	* Category add action
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	admin_gatekeeper();
	
	global $CONFIG;
	
	$name = get_input("metadata_name");
	$label = get_input("metadata_label");
	$guid = get_input("guid");
	$profile_types = get_input("profile_types");
	
	if(!empty($name) && preg_match("/^[a-zA-Z0-9_]{1,}$/", $name)){
		if(!empty($guid)){
			$object = get_entity($guid);
			if(!empty($object) && !($object instanceof ProfileManagerCustomFieldCategory)){
				$object = null;
			}
		}
		
		if(empty($object)){
			$object = new ProfileManagerCustomFieldCategory();
			$object->save();
			$add = true;
		}
		
		if(!empty($object)){
			$object->metadata_name = $name;
			
			if(!empty($label)){
				$object->metadata_label = $label;
			} else {
				unset($object->metadata_label);
			}
			
			// add relationship
			remove_entity_relationships($object->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, true);
			if(!empty($profile_types) && is_array($profile_types)){
				foreach($profile_types as $type){
					add_entity_relationship($type, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $object->guid);
				}
			}
			
			// add correct order
			$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
				"count" => true,
				"owner_guid" => $CONFIG->site_guid
			);
			
			$count = elgg_get_entities($options);
			
			if($add){
				$object->order = $count;
			}
			
			if($object->save()){
				system_message(elgg_echo("profile_manager:action:category:add:succes"));
			} else {
				register_error(elgg_echo("profile_manager:action:category:add:error:save"));
			}
		} else {
			register_error(elgg_echo("profile_manager:action:category:add:error:object"));
		}
	} else {
		register_error(elgg_echo("profile_manager:action:category:add:error:name"));
	}
	
	forward($_SERVER["HTTP_REFERER"]);
?>