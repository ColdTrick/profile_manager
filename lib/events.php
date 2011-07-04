<?php 
	function profile_manager_all_object_event($event, $object_type, $object){
		
		if($object instanceof ElggObject && $object->getSubtype() == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE){
			$count = elgg_get_entities_from_metadata(array(
					"type" => "object",
					"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
					"count" => true,
					"metadata_name_value_pairs" => array("name" => "metadata_name", "value" => "description", "operand" => "=", "case_sensitive" => TRUE)
				)); 
			if(!empty($count)){
			   	// used for showing description in profile box (profile/userdetails)
				set_plugin_setting('user_defined_fields', false, 'profile');
			} else {
				set_plugin_setting('user_defined_fields', true, 'profile');
			}
		}
	}
	
	function profile_manager_profileupdate_user_event($event, $object_type, $user){
		
		if(!empty($user) && ($user instanceof ElggUser)){
			// upload a file to your profile
			$accesslevel = get_input('accesslevel');
			if (!is_array($accesslevel)) {
				$accesslevel = array();
			}
			
			$options = array(
					"type" => "object",
					"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
					"limit" => false,
					"metadata_name_value_pairs" => array("name" => "metadata_type", "value" =>  "pm_file")
				);
			
			if($configured_fields = elgg_get_entities_from_metadata($options)){
				foreach($configured_fields as $field){
					// check for uploaded files
					$metadata_name = $field->metadata_name;
					$current_file_guid = $user->$metadata_name;
					
					if (isset($accesslevel[$metadata_name])) {
						$access_id = (int) $accesslevel[$metadata_name];
					} else {
						// this should never be executed since the access level should always be set
						$access_id = ACCESS_PRIVATE;
					}
					
					if (isset($_FILES[$metadata_name]) && $_FILES[$metadata_name]['error'] == 0) {
						// uploaded file exists so, save it to an ElggFile object
						// use current_file_guid to overwrite previously uploaded files
						$filehandler = new ElggFile($current_file_guid);
						$filehandler->owner_guid = $user->getGUID();
						$filehandler->container_guid = $user->getGUID();
						$filehandler->subtype = "file";
						$filehandler->access_id = $access_id;
						$filehandler->title = $field->getTitle();
						
						$filehandler->setFilename("profile_manager/" .  $_FILES[$metadata_name]["name"]);
						$filehandler->setMimeType($_FILES[$metadata_name]["type"]);
						
						$filehandler->open("write");
						$filehandler->write(get_uploaded_file($metadata_name));
						$filehandler->close();
						
						if($filehandler->save()){
							$filehandler->profile_manager_metadata_name = $metadata_name; // used to retrieve user file when deleting
							$filehandler->originalfilename = $_FILES[$metadata_name]["name"];
						
							create_metadata($user->guid, $metadata_name, $filehandler->getGUID(), 'text', $user->guid, $access_id);
						}
					} else {
						// if file not uploaded should it be deleted???
						if(empty($current_file_guid)){
							// find the previously uploaded file and if exists... delete it
							
							$options = array(
								"type" => "object",
								"subtype" => "file",
								"owner_guid" => $user->getGUID(),
								"limit" => 1,
								"metadata_name_value_pairs" => array("name" => "profile_manager_metadata_name", "value" =>  $metadata_name)
							);
							
							if($files = elgg_get_entities_from_metadata($options)){
								$file = $files[0];
								$file->delete();
							}
							
														
						} else {
							if($file = get_entity($current_file_guid)){
								// maybe we need to update the access id
								$file->access_id = $access_id;
								$file->save();								
							}
						}
					}
				}
			}
			
			// update profile completeness
			profile_manager_profile_completeness($user);
			
			// cleaunp river events
			$update_river_view = "river/user/default/profileupdate";
			$update_river_action_type = "update";
			
			$timeout = (time() - (12 * 60 * 60));
			if($items = get_river_items($user->getGUID(), $user->getGUID(), "", "", "", $update_river_action_type, 9999, 0, $timeout)){
				foreach($items as $item){
					if($item->view == $update_river_view){
						remove_from_river_by_id($item->id);
					}
				}
			}
		}
	}
	
	/**
	 * function to add custom profile fields to user on register
	 * 
	 * @param $event
	 * @param $object_type
	 * @param $object
	 * @return unknown_type
	 */
	function profile_manager_create_user_event($event, $object_type, $object){
		global $CONFIG;
		
		$custom_profile_fields = array();
		
		// retrieve all field that were on the register page
		foreach($_POST as $key=>$value){
	    	if(strpos($key, "custom_profile_fields_") === 0){
	    		$key = substr($key,22);
	    		$custom_profile_fields[$key] = $value;
	    	}
	    }
	    
		if(count($custom_profile_fields) > 0 ){
			foreach($custom_profile_fields as $shortname => $value){
				$options = array(
						"type" => "object",
						"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
						"limit" => 0,
						"owner_guid" => $CONFIG->site_guid,
						"metadata_name_value_pairs" => array("name" => "show_on_register", "value" =>  "yes")
					);
				
				$configured_fields = elgg_get_entities_from_metadata($options);
				
				// determine if $value should be an array
				if(!is_array($value) && !empty($configured_fields)){
					// only do something if it not is already an array
					foreach($configured_fields as $configured_field){
						if($configured_field->metadata_name == $shortname){
							if($configured_field->metadata_type == "tags" || $configured_field->output_as_tags == "yes"){
								$value = string_to_tag_array($value);
								// no need to continue this foreach
								break;
							}
						}
					}
				}
				
				// use create_metadata to listen to default access
				if (is_array($value)) {
					$i = 0;
					foreach($value as $interval) {
						$i++;
						if ($i == 1) { $multiple = false; } else { $multiple = true; }
						create_metadata($object->guid, $shortname, $interval, 'text', $object->guid, get_default_access($object), $multiple);
					}
				} else {
					create_metadata($object->guid, $shortname, $value, 'text', $object->guid, get_default_access($object));
				}
			}
		}
		
		if($profile_icon = $_FILES["profile_icon"]){
			add_profile_icon($object);
		}
		
		// cleanup session
		unset($_SESSION["register_post_backup"]);
	}
	
	function profile_manager_profileiconupdate_user_event($event, $object_type, $user){
		
		if(!empty($user) && ($user instanceof ElggUser)){
			$icon_river_view = "river/user/default/profileiconupdate";
			$icon_river_action_type = "update";
			
			if($items = get_river_items($user->getGUID(), $user->getGUID(), "", "", "", $icon_river_action_type, 9999)){
				foreach($items as $item){
					if($item->view == $icon_river_view){
						remove_from_river_by_id($item->id);
					}
				}
			}
		}
	}
?>