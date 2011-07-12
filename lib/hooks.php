<?php 
	/**
	 * Hook to replace the profile fields
	 * 
	 * @param $hook_name
	 * @param $entity_type
	 * @param $return_value
	 * @param $parameters
	 * @return unknown_type
	 */
	function profile_manager_profile_override($hook_name, $entity_type, $return_value, $parameters){
		global $CONFIG;

		// Get all the custom profile fields
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				"limit" => false,
				"owner_guid" => $CONFIG->site_guid
			);

		if($entities = elgg_get_entities($options)){
			$result = array();
			$translations = array();
			
		    // Make new result
		    foreach($entities as $entity){
		    	if($entity->admin_only != "yes" || isadminloggedin()){

		    		$result[$entity->metadata_name] = $entity->metadata_type;
		    		
		    		// should it be handled as tags? TODO: is this still needed? Yes it is, it handles presentation of these fields in listing mode
		    		if(get_context() == "search" && ($entity->output_as_tags == "yes" || $entity->metadata_type == "multiselect")){
		    			$result[$entity->metadata_name] = "tags";
		    		}	    		
		    	}
	    		
		    	$translations["profile:" . $entity->metadata_name] = $entity->getTitle();
		    }
			
		    add_translation(get_current_language(), $translations);
		    
			if(count($result)>0){
				$result["custom_profile_type"] = "non_editable";
			}
		}
		
		return $result;
	}
	
	/**
	 * function to replace group profile fields
	 * 
	 * @param $hook_name
	 * @param $entity_type
	 * @param $return_value
	 * @param $parameters
	 * @return unknown_type
	 */
	function profile_manager_group_override($hook_name, $entity_type, $return_value, $parameters){
		global $CONFIG;
		$result = $return_value;
		
		// Get all custom group fields
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
				"limit" => false,
				"owner_guid" => $CONFIG->site_guid
			);
		
		$group_fields = elgg_get_entities($options);
		
		if($group_fields){
			$result = array();
			$ordered = array();
			
			// Order the group fields and filter some types out
			foreach($group_fields as $group_field){
				if($group_field->admin_only != "yes" || isadminloggedin()){
					$ordered[$group_field->order] = $group_field;
					
					
				}				
			}
			ksort($ordered);
			
			// build the correct list
			$result["name"] = "text";
			foreach($ordered as $group_field){
				$result[$group_field->metadata_name] = $group_field->metadata_type;

				// should it be handled as tags? TODO: is this still needed? Yes it is, it handles presentation of these fields in listing mode
	    		if(get_context() == "search" && ($group_field->output_as_tags == "yes" || $group_field->metadata_type == "multiselect")){
	    			$result[$group_field->metadata_name] = "tags";
	    		}	
			}
		}
		
		return $result;
	}
	
	
	function profile_manager_categorized_profile_fields_hook($hook_name, $entity_type, $return_value, $params){
		$result = $return_value;
		
		// optionally add the system fields for admins
		if(isadminloggedin() && (get_plugin_setting("display_system_category", "profile_manager") == "yes")){
			$edit = $params["edit"];
			$register = $params["register"];
			
			if(!$edit && !$register){
				$result["categories"][-1] = "";
				$result["fields"][-1] = array();
				
				$system_fields = array(
						"guid" => "text",
						"owner_guid" => "text",
						"container_guid" => "text",
						
						"time_created" => "pm_datepicker",
						"time_updated" => "pm_datepicker",
						"last_action" => "pm_datepicker",
						"prev_last_login" => "pm_datepicker",
				 		"last_login" => "pm_datepicker",
						
						"username" => "text",
						"email" => "text",
						"language" => "text"
					);
				
				foreach($system_fields as $metadata_name => $metadata_type){
					$system_field = new ProfileManagerCustomProfileField();
					
					$system_field->metadata_name = $metadata_name;
					$system_field->metadata_type = $metadata_type;
					
					$result["fields"][-1][] = $system_field;
				}
			}
		}
		
		return $result;
	}
	
	function profile_manager_display_view_hook($hook_name, $entity_type, $return_value, $parameters){
		$view = $parameters["view"];
		
		if(($view == "output/datepicker" || $view == "input/datepicker") && !elgg_view_exists($view)){
			
			if($view == "output/datepicker"){
				$new_view = "output/pm_datepicker";
			} else {
				$new_view = "input/pm_datepicker";
			}
			 
			return elgg_view($new_view, $parameters["vars"]);
		}
	}
	
	/**
	 * function to check if custom fields on register have been filled (if required)
	 * 
	 * @param $hook_name
	 * @param $entity_type
	 * @param $return_value
	 * @param $parameters
	 * @return unknown_type
	 */
	function profile_manager_action_register_hook($hook_name, $entity_type, $return_value, $parameters){
		// check if login by email is enabled, if so generate username
		if(get_plugin_setting("login_by_email", "profile_manager") == "yes"){
			if($email = get_input("email")){
				if($username = profile_manager_generate_username_from_email($email)){
					set_input("username", $username);
				}
			}
		}
		
		// backup POST data
		$_SESSION["register_post_backup"] = $_POST;
		
		// validate mandatory profile fields
		
		$profile_icon = get_plugin_setting("profile_icon_on_register");
		// new
		$profile_type_guid = get_input("custom_profile_fields_custom_profile_type", false);
		$fields = profile_manager_get_categorized_fields($user, true, true, true, $profile_type_guid);
		$required_fields = array();
			
		if(!empty($fields["categories"])){
			foreach($fields["categories"] as $cat_guid => $cat){
				$cat_fields = $fields["fields"][$cat_guid]; 
				foreach($cat_fields as $field){
					if($field->show_on_register == "yes" && $field->admin_only != "yes" && $field->mandatory == "yes"){
						$required_fields[] = $field;
					}
				}
			}
		}
		
		if($required_fields || $profile_icon == "yes"){
		    
		    $custom_profile_fields = array();
		    
		    foreach($_POST as $key => $value){
		    	if(strpos($key, "custom_profile_fields_") == 0){
		    		$key = substr($key, 22);
		    		$custom_profile_fields[$key] = $value;
		    	}
		    }
		    
		    foreach($required_fields as $entity){
		    	
		    	$passed_value = $custom_profile_fields[$entity->metadata_name];
		    	
				if(empty($passed_value)){
					register_error(sprintf(elgg_echo("profile_manager:register_pre_check:missing"), $entity->getTitle()));
					forward(REFERER);					
				}
		    }
		    
		    if($profile_icon == "yes"){
		    	$profile_icon = $_FILES["profile_icon"];
		    	
		    	$error = false;
		    	if(empty($profile_icon["name"])){
			    	register_error(sprintf(elgg_echo("profile_manager:register_pre_check:missing"), "profile_icon"));
			    	$error = true;
		    	} elseif($profile_icon["error"] != 0){
		    		register_error(elgg_echo("profile_manager:register_pre_check:profile_icon:error"));
		    		$error = true;
		    	} elseif(!in_array(strtolower(substr($profile_icon["name"], -3)), array("jpg","png","gif"))){
		    		register_error(elgg_echo("profile_manager:register_pre_check:profile_icon:nosupportedimage"));
		    		$error = true;
		    	}	
		    		   
		    	if($error){
		    		forward(REFERER);
		    	}
		    }
		}
	}
?>