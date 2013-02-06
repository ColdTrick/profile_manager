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
		
		// Get all the custom profile fields
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				"limit" => false,
				"owner_guid" => elgg_get_config("site_guid")
			);

		if($entities = elgg_get_entities($options)){
			$result = array();
			$translations = array();
			$context = elgg_get_context();
		    // Make new result
		    foreach($entities as $entity){
		    	if($entity->admin_only != "yes" || elgg_is_admin_logged_in()){

		    		$result[$entity->metadata_name] = $entity->metadata_type;
		    		
		    		// should it be handled as tags? TODO: is this still needed? Yes it is, it handles presentation of these fields in listing mode
		    		if($context == "search" && ($entity->output_as_tags == "yes" || $entity->metadata_type == "multiselect")){
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
		$result = $return_value;
		
		// Get all custom group fields
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
				"limit" => false,
				"owner_guid" => elgg_get_config("site_guid")
			);
		
		$group_fields = elgg_get_entities($options);
		
		if($group_fields){
			$result = array();
			$ordered = array();
			
			// Order the group fields and filter some types out
			foreach($group_fields as $group_field){
				if($group_field->admin_only != "yes" || elgg_is_admin_logged_in()){
					$ordered[$group_field->order] = $group_field;
				}				
			}
			ksort($ordered);
				
			// build the correct list
			$result["name"] = "text";
			foreach($ordered as $group_field){
				$result[$group_field->metadata_name] = $group_field->metadata_type;

				// should it be handled as tags? Q: is this still needed? A: Yes it is, it handles presentation of these fields in listing mode
	    		if(elgg_get_context() == "search" && ($group_field->output_as_tags == "yes" || $group_field->metadata_type == "multiselect")){
	    			$result[$group_field->metadata_name] = "tags";
	    		}	
			}
		}
		
		return $result;
	}
	
	function profile_manager_categorized_profile_fields_hook($hook_name, $entity_type, $return_value, $params){
		$result = $return_value;
		
		// optionally add the system fields for admins
		if(elgg_is_admin_logged_in() && (elgg_get_plugin_setting("display_system_category", "profile_manager") == "yes")){
			$edit = $params["edit"];
			$register = $params["register"];
			
			if(!$edit && !$register){
				$result["categories"][-1] = "";
				$result["fields"][-1] = array();
				
				$system_fields = array(
						"guid" => "text",
						"owner_guid" => "text",
						"container_guid" => "text",
						"site_guid" => "text",
						
						"time_created" => "pm_datepicker",
						"time_updated" => "pm_datepicker",
						"last_action" => "pm_datepicker",
						"prev_last_login" => "pm_datepicker",
				 		"last_login" => "pm_datepicker",

						"admin_created" => "text",
				 		"created_by_guid" => "text",
						"validated" => "text",
						"validated_method" => "text",
						
						"username" => "text",
						"email" => "text",
						"language" => "text",						
						"icontime" => "text",
						"code" => "text"			
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
		
		elgg_make_sticky_form('register');
		elgg_make_sticky_form('profile_manager_register');
		
		// validate mandatory profile fields
		$profile_icon = elgg_get_plugin_setting("profile_icon_on_register", "profile_manager");
		
		// general terms
		$terms = elgg_get_plugin_setting("registration_terms", "profile_manager");
		
		// new
		$profile_type_guid = get_input("custom_profile_fields_custom_profile_type", false);
		$fields = profile_manager_get_categorized_fields($user, true, true, true, $profile_type_guid);
		$required_fields = array();
			
		if(!empty($fields["categories"])){
			foreach($fields["categories"] as $cat_guid => $cat){
				$cat_fields = $fields["fields"][$cat_guid]; 
				foreach($cat_fields as $field){
					if($field->show_on_register == "yes" && $field->mandatory == "yes"){
						$required_fields[] = $field;
					}
				}
			}
		}
		
		if($terms || $required_fields || $profile_icon == "yes"){
		    
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
					register_error(elgg_echo("profile_manager:register_pre_check:missing", array($entity->getTitle())));
					forward(REFERER);					
				}
		    }
		    
		    if($profile_icon == "yes"){
		    	$profile_icon = $_FILES["profile_icon"];
		    	
		    	$error = false;
		    	if(empty($profile_icon["name"])){
			    	register_error(elgg_echo("profile_manager:register_pre_check:missing", array("profile_icon")));
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
		    
		    if($terms){
		    	$terms_accepted = get_input("accept_terms");
		    	if($terms_accepted !== "yes"){
		    		register_error(elgg_echo("profile_manager:register_pre_check:terms"));
		    		forward(REFERER);
		    	}
		    }
		}
	}

	/**
	 * 
	 * If possible change the username of a user
	 * @param unknown_type $hook_name
	 * @param unknown_type $entity_type
	 * @param unknown_type $return_value
	 * @param unknown_type $parameters
	 */
	function profile_manager_username_change_hook($hook_name, $entity_type, $return_value, $parameters){
		$user_guid = (int) get_input('guid');
		$new_username = get_input('username');
		
		$enable_username_change = elgg_get_plugin_setting("enable_username_change", "profile_manager");
		if($enable_username_change == "yes" || ($enable_username_change == "admin" && elgg_is_admin_logged_in())){
		
			if(!empty($user_guid) && !empty($new_username)){
				if(profile_manager_validate_username($new_username)){
					if($user = get_user($user_guid)){
						if($user->canEdit()){
							if($user->username !== $new_username){
								$user->username = $new_username;
								if($user->save()){
									elgg_register_plugin_hook_handler("forward", "system", "profile_manager_username_change_forward_hook");
									
									system_message(elgg_echo('profile_manager:action:username:change:succes'));
								}
							}
						}
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * Directs user to correct settings links after changing a username
	 * @param unknown_type $hook_name
	 * @param unknown_type $entity_type
	 * @param unknown_type $return_value
	 * @param unknown_type $parameters
	 * @return string
	 */
	function profile_manager_username_change_forward_hook($hook_name, $entity_type, $return_value, $parameters){
		$username = get_input("username");
		if(!empty($username)){
			return elgg_get_site_url() . "settings/user/" . $username;
		}
	}
	
	/**
	 * 
	 * Used to extend the entity menu when user_summary_control is enabled 
	 * @param unknown_type $hook_name
	 * @param unknown_type $entity_type
	 * @param unknown_type $return_value
	 * @param unknown_type $parameters
	 */
	function profile_manager_register_entity_menu($hook_name, $entity_type, $return_value, $params){
		
		// cleanup existing menu items (location is added in core/lib/users.php)
		if(!empty($return_value)){
			foreach($return_value as $key => $menu_item){
				if($menu_item->getName() == "location"){
					// add the new and improved version that supports 'old' location as tags field
					if ($location = $params["entity"]->location) {
						if(is_array($location)){
							$location = implode(",", $location);
						}
						$options = array(
									'name' => 'location',
									'text' => "<span>$location</span>",
									'href' => false,
									'priority' => 150,
						);
						$location_menu = ElggMenuItem::factory($options);
						$return_value[$key] = $location_menu;
					}
				}
			}
		}
		
		if(!elgg_in_context("widgets") && elgg_instanceof($params['entity'], 'user')){
			if(elgg_get_plugin_setting("user_summary_control", "profile_manager") == "yes"){
				// add optional custom profile field data
				$current_config = elgg_get_plugin_setting("user_summary_config", "profile_manager");
				if(!empty($current_config)){
					$current_config = json_decode($current_config, true);
					
					$profile_fields = elgg_get_config("profile_fields");
					
					if(!empty($current_config) && is_array($current_config) && !empty($profile_fields)){
						if(array_key_exists("entity_menu", $current_config)){
							$fields = $current_config["entity_menu"];
							$spacer_allowed = true;
							$spacer_result = "";
							$menu_content = "";
							
							foreach($fields as $field){
								$field_result = "";
									
								switch($field){
									case "spacer_dash":
										if($spacer_allowed){
											$spacer_result = " - ";
										}
										$spacer_allowed = false;
										break;
									case "spacer_space":
										if($spacer_allowed){
											$spacer_result = " ";
										}
										$spacer_allowed = false;
										break;
									case "spacer_new_line":
										$spacer_allowed = true;
										$field_result = "<br />";
										break;
									default:
										$spacer_allowed = true;
									$field_result = elgg_view("output/" . $profile_fields[$field], array("value" => $params["entity"]->$field));
									break;
								}
									
								if(!empty($field_result)){
									$menu_content .= $spacer_result . $field_result;
								}
							}
							if(!empty($menu_content)){
								$options = array(
												'name' => 'profile_manager_user_summary_control_entity_menu',
												'text' => "<span>$menu_content</span>",
												'href' => false,
												'priority' => 150,
								);
								$return_value[] = ElggMenuItem::factory($options);
							}
						}
					}
				}
			}
		}
		
		return $return_value;
	}
	
	/**
	*
	* Used to prevent likes on site objects
	* @param unknown_type $hook_name
	* @param unknown_type $entity_type
	* @param unknown_type $return_value
	* @param unknown_type $parameters
	*/
	function profile_manager_permissions_check_annotate($hook_name, $entity_type, $return_value, $params){
		$return = $return_value;
		if(is_array($params) && (elgg_extract("annotation_name", $params) == "likes")){
			$return = false;
		}
		return $return;
	}