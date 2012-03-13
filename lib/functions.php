<?php 
	/**
	 * Registes all custom field types
	 */
	function register_custom_field_types(){
		// registering profile field types
		$profile_options = array(
				"show_on_register" => true,
				"mandatory" => true,
				"user_editable" => true,
				"output_as_tags" => true,
				"admin_only" => true,
				"count_for_completeness" => true
			);		
			
		$location_options = $profile_options;
		unset($location_options["output_as_tags"]);
		
		$pm_datepicker_options = $profile_options;
		unset($pm_datepicker_options["output_as_tags"]);
		
		$pulldown_options = $profile_options;
		$pulldown_options["blank_available"] = true;
		
		$radio_options = $profile_options;
		$radio_options["blank_available"] = true;
		
		$file_options = array(
			"user_editable" => true,
			"admin_only" => true
		);
		
		$pm_rating_options = $profile_options;
		unset($pm_rating_options["output_as_tags"]);
		
		add_custom_field_type("custom_profile_field_types", 'text', elgg_echo('text'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'longtext', elgg_echo('longtext'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'tags', elgg_echo('tags'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'location', elgg_echo('location'), $location_options);
		add_custom_field_type("custom_profile_field_types", 'url', elgg_echo('url'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'email', elgg_echo('email'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'calendar', elgg_echo('calendar'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'pm_datepicker', elgg_echo('profile_manager:admin:options:pm_datepicker'), $pm_datepicker_options);
		add_custom_field_type("custom_profile_field_types", 'dropdown', elgg_echo('profile_manager:admin:options:pulldown'), $pulldown_options);
		add_custom_field_type("custom_profile_field_types", 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
		add_custom_field_type("custom_profile_field_types", 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $profile_options);
		add_custom_field_type("custom_profile_field_types", 'pm_rating', elgg_echo('profile_manager:admin:options:pm_rating'), $pm_rating_options);
		//add_custom_field_type("custom_profile_field_types", 'pm_file', elgg_echo('profile_manager:admin:options:file'), $file_options);
		
		if(elgg_view_exists("output/datepicker") && elgg_view_exists("input/datepicker")){
			$datepicker_options = $profile_options;
			unset($datepicker_options["output_as_tags"]);
			
			add_custom_field_type("custom_profile_field_types", 'datepicker', elgg_echo('profile_manager:admin:options:datepicker'), $datepicker_options);
		} else {
			elgg_register_plugin_hook_handler('display', 'view', 'profile_manager_display_view_hook');
		}
		
		// registering group field types		
		$group_options = array(
				"output_as_tags" => true,
				"admin_only" => true
			);	
		
		$datepicker_options = $group_options;
		unset($datepicker_options["output_as_tags"]);
		
		$pulldown_options = $group_options;
		$pulldown_options["blank_available"] = true;
		
		$radio_options = $group_options;
		$radio_options["blank_available"] = true;
		
		add_custom_field_type("custom_group_field_types", 'text', elgg_echo('text'), $group_options);
		add_custom_field_type("custom_group_field_types", 'longtext', elgg_echo('longtext'), $group_options);
		add_custom_field_type("custom_group_field_types", 'tags', elgg_echo('tags'), $group_options);
		add_custom_field_type("custom_group_field_types", 'url', elgg_echo('url'), $group_options);
		add_custom_field_type("custom_group_field_types", 'email', elgg_echo('email'), $group_options);
		add_custom_field_type("custom_group_field_types", 'calendar', elgg_echo('calendar'), $group_options);
		add_custom_field_type("custom_group_field_types", 'datepicker', elgg_echo('profile_manager:admin:options:datepicker'), $datepicker_options);
		add_custom_field_type("custom_group_field_types", 'dropdown', elgg_echo('profile_manager:admin:options:pulldown'), $pulldown_options);
		add_custom_field_type("custom_group_field_types", 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
		add_custom_field_type("custom_group_field_types", 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $group_options);
	}
	
	/**
	 * Function to add a custom field type to a register
	 */
	function add_custom_field_type($register_name, $field_type, $field_display_name, $options){
		global $PROFILE_MANAGER_FIELD_TYPES;
		
		if(!isset($PROFILE_MANAGER_FIELD_TYPES)){
			$PROFILE_MANAGER_FIELD_TYPES = array();
		}
		if(!isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])){
			$PROFILE_MANAGER_FIELD_TYPES[$register_name] = array();
		}
		
		$field_config = new stdClass();
		$field_config->name = $field_display_name;
		$field_config->type = $field_type;
		$field_config->options = $options;
		
		$PROFILE_MANAGER_FIELD_TYPES[$register_name][$field_type] = $field_config;
	}
	
	function get_custom_field_types($register_name){
		global $PROFILE_MANAGER_FIELD_TYPES;
		
		$result = false;
		
		if(isset($PROFILE_MANAGER_FIELD_TYPES) && isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])){
			$result = $PROFILE_MANAGER_FIELD_TYPES[$register_name];
		}
		
		return $result;
	}
	
	/**
	 * function to upload a profile icon on register of a user
	 * 
	 * @param $user
	 * @return unknown_type
	 */
	function add_profile_icon($user){
		$topbar = get_resized_image_from_uploaded_file('profile_icon',16,16, true);
		$tiny = get_resized_image_from_uploaded_file('profile_icon',25,25, true);
		$small = get_resized_image_from_uploaded_file('profile_icon',40,40, true);
		$medium = get_resized_image_from_uploaded_file('profile_icon',100,100, true);
		$large = get_resized_image_from_uploaded_file('profile_icon',200,200);
		$master = get_resized_image_from_uploaded_file('profile_icon',550,550);
		
		
		$prefix = $user->guid;
		$cur_version = get_version();
		if($cur_version < 2010071002){
			$prefix = $user->name;
		}
		
		if ($small !== false
			&& $medium !== false
			&& $large !== false
			&& $tiny !== false) {
		
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $user->getGUID();
			$filehandler->setFilename("profile/" . $prefix . "large.jpg");
			$filehandler->open("write");
			$filehandler->write($large);
			$filehandler->close();
			$filehandler->setFilename("profile/" . $prefix . "medium.jpg");
			$filehandler->open("write");
			$filehandler->write($medium);
			$filehandler->close();
			$filehandler->setFilename("profile/" . $prefix . "small.jpg");
			$filehandler->open("write");
			$filehandler->write($small);
			$filehandler->close();
			$filehandler->setFilename("profile/" . $prefix . "tiny.jpg");
			$filehandler->open("write");
			$filehandler->write($tiny);
			$filehandler->close();
			$filehandler->setFilename("profile/" . $prefix . "topbar.jpg");
			$filehandler->open("write");
			$filehandler->write($topbar);
			$filehandler->close();
			$filehandler->setFilename("profile/" . $prefix . "master.jpg");
			$filehandler->open("write");
            $filehandler->write($master);
			$filehandler->close();
			
			$user->icontime = time();
		}
	}
	
	/**
	 * returns an array containing the categories and the fields ordered by category and field order
	 */ 
	function profile_manager_get_categorized_fields($user = null, $edit = false, $register = false, $profile_type_limit = false, $profile_type_guid = false){
		
		$result = array();
		$profile_type = null;
		
		if($register == true){
			// failsafe for edit
			$edit = true;
		}
		
		if(!empty($user) && ($user instanceof ElggUser)){
			$user_metadata = profile_manager_get_user_profile_data($user);
			
			$profile_type_guid = profile_manager_get_user_profile_data_value($user_metadata, "custom_profile_type");
			
			if(!empty($profile_type_guid)){
				$profile_type = get_entity($profile_type_guid);
				
				// check if profile type is a REAL profile type
				if(!empty($profile_type) && ($profile_type instanceof ProfileManagerCustomProfileType)){
					if($profile_type->getSubtype() != CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE){
						$profile_type = null;
					}
				}
			}
		} elseif(!empty($profile_type_guid)) {
			$profile_type = get_entity($profile_type_guid);
		}
		
		$result["categories"] = array();
		$result["categories"][0] = array();
		$result["fields"] = array();
		$ordered_cats = array();
		
		$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
			"limit" => false,
			"owner_guid" => elgg_get_site_entity()->getGUID(),
			"site_guid" => elgg_get_site_entity()->getGUID()
		); 
			
		// get ordered categories
		if($cats = elgg_get_entities($options)){
			foreach($cats as $cat){
				$ordered_cats[$cat->order] = $cat;
			}
			ksort($ordered_cats);
		}
		
		// get filtered categories			
		$filtered_ordered_cats = array();
		// default category at index 0
		$filtered_ordered_cats[0] = array();
		
		if(!empty($ordered_cats)){
			foreach($ordered_cats as $key => $cat){
				
				if(!$edit || $profile_type_limit){
					$options = array(
							"type" => "object",
							"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
							"count" => true,
							"owner_guid" => $cat->getOwnerGUID(),
							"site_guid" => $cat->site_guid,
							"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
							"relationship_guid" => $cat->getGUID(),
							"inverse_relationship" => true
						); 
					
					$rel_count = elgg_get_entities_from_relationship($options);
					
					if($rel_count == 0){
						$filtered_ordered_cats[$cat->guid] = array();
						$result["categories"][$cat->guid] = $cat;
					} elseif(!empty($profile_type) && check_entity_relationship($profile_type->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $cat->guid)){
						$filtered_ordered_cats[$cat->guid] = array();
						$result["categories"][$cat->guid] = $cat;
					}
				} else {
					$filtered_ordered_cats[$cat->guid] = array();
					$result["categories"][$cat->guid] = $cat;
				}
			}
		}
		
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				"limit" => false,
				"owner_guid" => elgg_get_site_entity()->getGUID(),
				"site_guid" => elgg_get_site_entity()->getGUID()
			); 
			
		// adding fields to categories
		if($fields = elgg_get_entities($options)){
			
			foreach($fields as $field){
				
				if(!($cat_guid = $field->category_guid)){
					$cat_guid = 0; // 0 is default
				}
				
				$admin_only = $field->admin_only;
				if($admin_only != "yes" || elgg_is_admin_logged_in()){
					if($edit){
						if(!$register || $field->show_on_register == "yes"){
							$filtered_ordered_cats[$cat_guid][$field->order] = $field;
						}
					} else {
						// only add if value exists
						$metadata_name = $field->metadata_name;
						$user_value = profile_manager_get_user_profile_data_value($user_metadata, $metadata_name);
						
						if(!empty($user_value) || $user_value === 0){
							$filtered_ordered_cats[$cat_guid][$field->order] = $field;
						}
					}
				}
			}
		}
		
		// sorting fields and filtering empty categories
		foreach($filtered_ordered_cats as $cat_guid => $fields){
			if(!empty($fields)){
				ksort($fields);
				$result["fields"][$cat_guid] = $fields;
			} else {
				unset($result["categories"][$cat_guid]);
			} 
		}
		
		//  fire hook to see if other plugins have extra fields
		$hook_params = array(
			"user" => $user,
			"edit" => $edit,
			"register" => $register,
			"profile_type_limit" => $profile_type_limit,
			"profile_type_guid" => $profile_type_guid
		);
		
		$result = elgg_trigger_plugin_hook("categorized_profile_fields", "profile_manager", $hook_params, $result);
		
		return $result;
	}
	
	/**
	 * Function just now returns only ordered (name is prepped for future release which should support categories)
	 */
	function profile_manager_get_categorized_group_fields($group = null){
		
		$result = array();
		$result["fields"] = array();
		
		// Get all custom group fields
		$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
				"limit" => false,
				"owner_guid" => elgg_get_site_entity()->getGUID(),
				"site_guid" => elgg_get_site_entity()->getGUID()
			);
			
		$fields = elgg_get_entities($options);

		if($fields){
			foreach($fields as $field){
				$admin_only = $field->admin_only;
				if($admin_only != "yes" || elgg_is_admin_logged_in()){
					$result["fields"][$field->order] = $field;
				}
			}
			ksort($result["fields"]);
		}
		
		//  fire hook to see if other plugins have extra fields
		$hook_params = array(
			"group" => $group
		);
			
		$result = elgg_trigger_plugin_hook("categorized_group_fields", "profile_manager", $hook_params, $result);
		
		return $result;
	}
	/*
	 * returns the max order from a specific profile field type
	 */
	function profile_manager_get_max_order($field_type){
		$max = 0;
		$result = false;
		
		if($field_type == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $field_type == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
			$options = array(
				"type" => "object",
				"subtype" => $field_type,
				"limit" => 1,
				"order_by_metadata" => array(array('name' => 'order', 'direction' => "desc", 'as' => "integer")),
				"owner_guid" => elgg_get_site_entity()->getGUID(),
				"site_guid" => elgg_get_site_entity()->getGUID()
			); 
			
			if($entities = elgg_get_entities_from_metadata($options)){
				$entity = $entities[0];
				$max = (int) $entity->order;
			}
			
			$result = $max;
		} 
		
		return $result;
	}
	
	/**
	 * returns an array with percentage completeness and required / missing fields 
	 * 
	 * @param optional ElggUser $user
	 */
	function profile_manager_profile_completeness($user = null){
		
		$result = false;
		
		if(empty($user)){
			$user = elgg_get_logged_in_user_entity();
		}
		
		if(!empty($user) && ($user instanceof ElggUser)){
			
			$required_fields = array();
			$missing_fields = array();
			$percentage_completeness = 100;
			
			$fields = profile_manager_get_categorized_fields($user, true, false, true);
			
			if(!empty($fields["categories"])){
				
				foreach($fields["categories"] as $cat_guid => $cat){
					$cat_fields = $fields["fields"][$cat_guid]; 
					
					foreach($cat_fields as $field){
						
						if($field->count_for_completeness == "yes"){
							$required_fields[] = $field;
							$metaname = $field->metadata_name;
							if(empty($user->$metaname) && ($user->$metaname !== 0)){
								$missing_fields[] = $field;
							}
						}
					}
				}
			}
			
			
			if(count($required_fields) > 0){
				$percentage_completeness = 100 - round(((count($missing_fields) / count($required_fields)) * 100));
			}

			$result = array(
				"required_fields" => $required_fields,
				"missing_fields" => $missing_fields,
				"percentage_completeness" => $percentage_completeness
				);
		}
		
		return $result;
	}
	
	function profile_manager_get_user_profile_data(ElggUser $user){
		global $CONFIG;
		
		$profile_fields = elgg_get_config('profile_fields');
		$result = false;
		if(!empty($user) && !empty($profile_fields)){
			
			$fields = "'" . implode("','", array_keys($profile_fields)) . "'";
			$query = "SELECT m.*, n.string as name, v.string as value from {$CONFIG->dbprefix}metadata m JOIN {$CONFIG->dbprefix}metastrings v on m.value_id = v.id JOIN {$CONFIG->dbprefix}metastrings n on m.name_id = n.id where";
			$query .= " n.string in ('custom_profile_type'," . $fields . ") AND"; 	
			$query .= " m.entity_guid = " . $user->getGUID() . " AND"; 	
			$query .= " " . get_access_sql_suffix("m"); // Add access controls
			
			$rows = get_data($query, "row_to_elggmetadata");
			if($rows){
				$result = array();
				foreach($rows as $row){
					
					if(!array_key_exists($row->name, $result)){
						// create object						
						$object = new stdClass();
						$object->name = $row->name;
						$object->value = $row->value;
						$object->access_id = $row->access_id;
						$result[$row->name] = $object;
					} else {
						$result[$row->name]->value = $row->value . ", " . $result[$row->name]->value;
					}					 
				}
			}	
		} 
		
		return $result;
	}
	
	function profile_manager_get_user_profile_data_value($data, $name){
		$result = NULL;
		if(!empty($data) && is_array($data) && array_key_exists($name, $data)){
			$result = $data[$name]->value;
		}
		return $result;
	}
	
	function profile_manager_authenticate($username, $password){
		$result = false;
		
		if (pam_authenticate(array("username" => $username, "password" => $password))) {
			if(($users = get_user_by_email($username)) && (count($users) == 1)){
				$result = $users[0];
			} elseif($user = get_user_by_username($username)){
				$result = $user;
			}
		}
	
		return $result;
	}
	
	function profile_manager_generate_username_from_email($email){
		$result = false;
		
		if(!empty($email) && is_email_address($email)){
			list($username) = explode("@", $email);
			
			// show hidden entities (unvalidated users)
			$hidden = access_get_show_hidden_status();
			access_show_hidden_entities(true);
			
			// check if username is unique
			if(get_user_by_username($username)){
				$i = 1;
				
				while(get_user_by_username($username . $i)){
					$i++;
				}
				
				$username = $username . $i;
			}
			
			// restore hidden entities
			access_show_hidden_entities($hidden);
			
			$result = $username;
		}
		
		return $result;
	}
	
	function profile_manager_validate_username($username){
		$result = false;
		if(!empty($username)){
			// make sure we can check every user (even unvalidated)
			$access_status = access_get_show_hidden_status();
			access_show_hidden_entities(true);
			
			// check if username exists
			try {
				if(validate_username($username)){
					
					if(!get_user_by_username($username))	{
						$result = true;
					} 
				}
			} catch (Exception $e){
			}
			
			// restore access settings
			access_show_hidden_entities($access_status);
		}
		
		return $result;
	}