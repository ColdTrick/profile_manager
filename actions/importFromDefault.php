<?php
	/**
	* Profile Manager
	* 
	* Action to import from default
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	$site_guid = elgg_get_site_entity()->getGUID();
	
	$type = get_input("type", "profile");
	
	if($type == "profile" || $type == "group"){
		$added = 0;	
		$defaults = array();
		
		$options = array(
				"type" => "object",
				"subtype" => "custom_" . $type . "_field",
				"count" => true,
				"owner_guid" => $site_guid
			);
		
		$max_fields = elgg_get_entities($options) + 1;
	
		if($type == "profile"){
			// Profile defaults
			$defaults = array (
					'description' => 'longtext',
					'briefdescription' => 'text',
					'location' => 'location',
					'interests' => 'tags',
					'skills' => 'tags',
					'contactemail' => 'email',
					'phone' => 'text',
					'mobile' => 'text',
					'website' => 'url',
					'twitter' => 'text'
				);
		} elseif($type == "group"){
			// Group defaults
			$defaults = array(
				'description' => 'longtext',
				'briefdescription' => 'text',
				'interests' => 'tags'
			);
		}
		
		foreach($defaults as $metadata_name => $metadata_type){
			$options["metadata_name_value_pairs"] = array("name" => "metadata_name", "value" => $metadata_name);
			
			$count = elgg_get_entities_from_metadata($options);
			
			if($count == 0){
				$field = new ElggObject(); // not using classes so we can handle both profile and group in one function
						
				$field->owner_guid = $site_guid;
				$field->container_guid = $site_guid;
				$field->access_id = ACCESS_PUBLIC;
				$field->subtype = "custom_" . $type . "_field";
				$field->save();
				
				$field->metadata_name = $metadata_name;
				$field->metadata_type = $metadata_type;
				
				if($type == "profile"){
					$field->show_on_register = "no";
					$field->mandatory = "no";
					$field->user_editable = "yes";
				}
				$field->order = $max_fields;
				
				$field->save();
				
				$max_fields++;
				$added++;
			} 
		}
		
		if($added == 0){
			register_error(elgg_echo("profile_manager:actions:import:from_default:no_fields"));
		} else {
			system_message(elgg_echo("profile_manager:actions:import:from_default:new_fields", array($added)));
		}
	} else {
		register_error(elgg_echo("profile_manager:actions:import:from_default:error:wrong_type"));
	}
	
	forward(REFERER);