<?php 
	/**
	* Profile Manager
	* 
	* Profile Type Add action
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$guid = get_input("guid");
	$name = get_input("metadata_name");
	$label = get_input("metadata_label");
	$description = get_input("metadata_description");
	$categories = get_input("categories");
	
	if(!empty($name) && preg_match("/^[a-zA-Z0-9_]{1,}$/", $name)){
		if(!empty($guid)){
			$object = get_entity($guid);
			if(!empty($object) && !($object instanceof ProfileManagerCustomProfileType)){
				$object = null;
			}
		}
		
		if(empty($object)){
			$object = new ProfileManagerCustomProfileType();
			$object->save();
		}
		
		if(!empty($object)){
			$object->metadata_name = $name;
			
			if(!empty($label)){
				$object->metadata_label = $label;
			} else {
				unset($object->metadata_label);
			}
			
			if(!empty($description)){
				$object->metadata_description = $description;
			} else {
				unset($object->metadata_description);
			}
			
			// add category relations
			remove_entity_relationships($object->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP);
			if(!empty($categories) && is_array($categories)){
				foreach($categories as $cat_guid){
					$object->addRelationship($cat_guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP);
				}
			}
			
			if($object->save()){
				system_message(elgg_echo("profile_manager:action:profile_types:add:succes"));
			} else {
				register_error(elgg_echo("profile_manager:action:profile_types:add:error:save"));
			}
		} else {
			register_error(elgg_echo("profile_manager:action:profile_types:add:error:object"));
		}
	} else {
		register_error(elgg_echo("profile_manager:action:profile_types:add:error:name"));
	}
	
	forward(REFERER);