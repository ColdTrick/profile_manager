<?php 
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
		$custom_profile_fields = array();
		
		// retrieve all field that were on the register page
		foreach($_POST as $key => $value){
	    	if(strpos($key, "custom_profile_fields_") === 0){
	    		$key = substr($key, 22);
	    		$custom_profile_fields[$key] = get_input("custom_profile_fields_" . $key);
	    	}
	    }
	    
		if(count($custom_profile_fields) > 0 ){
			$categorized_fields = profile_manager_get_categorized_fields(null, true, true);
			$configured_fields = $categorized_fields['fields'];
			
			// set ignore access
			$ia = elgg_get_ignore_access();
			elgg_set_ignore_access(true);
			
			foreach($custom_profile_fields as $shortname => $value){
				
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
			
			// restore ignore access
			elgg_set_ignore_access($ia);
		}
		
		if(isset($_FILES["profile_icon"])){
			add_profile_icon($object);
		}
		
		if($terms = elgg_get_plugin_setting("registration_terms", "profile_manager")){
			$object->setPrivateSetting("general_terms_accepted", time());
		}
	}	
	
	/**
	 * Adds a river event when a user joins the site
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */
	function profile_manager_create_member_of_site($event, $object_type, $object){
		$enable_river_event = elgg_get_plugin_setting("enable_site_join_river_event", "profile_manager");
		if($enable_river_event !== "no"){
			
			$user_guid = $object->guid_one;
			$site_guid = $object->guid_two;
			
			// clear current river events
			elgg_delete_river(array("view" => 'river/relationship/member_of_site/create', "subject_guid" => $user_guid, "object_guid" => $site_guid));
			
			// add new join river event
			add_to_river('river/relationship/member_of_site/create', 'join', $user_guid, $site_guid);
		}
	}

	/**
	 * Remove river join event on site leave
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */
	function profile_manager_delete_member_of_site($event, $object_type, $object){
		// remove previous join events
		$user_guid = $object->guid_one;
		$site_guid = $object->guid_two;
		
		// clear current river events
		elgg_delete_river(array("view" => 'river/relationship/member_of_site/create', "subject_guid" => $user_guid, "object_guid" => $site_guid));
	}
	