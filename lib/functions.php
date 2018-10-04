<?php

/**
 * Function to add a custom field type to a register
 *
 * @param string $register_name      Name of the register where the fields are configured
 * @param string $field_type         Type op the field
 * @param string $field_display_name Display name of the field type
 * @param array  $options            Array of options
 *
 * @return void
 */
function profile_manager_add_custom_field_type($register_name, $field_type, $field_display_name, $options = []) {
	global $PROFILE_MANAGER_FIELD_TYPES;
	
	if (!isset($PROFILE_MANAGER_FIELD_TYPES)) {
		$PROFILE_MANAGER_FIELD_TYPES = array();
	}
	if (!isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])) {
		$PROFILE_MANAGER_FIELD_TYPES[$register_name] = array();
	}
	
	$defaults = [
		'show_on_profile' => true,
	];
	
	$field_config = new stdClass();
	$field_config->name = $field_display_name;
	$field_config->type = $field_type;
	$field_config->options = array_merge($defaults, $options);
	
	$PROFILE_MANAGER_FIELD_TYPES[$register_name][$field_type] = $field_config;
}

/**
 * Returns the profile manager field types
 *
 * @param string $register_name Name of the register to retrieve
 *
 * @return false|array
 */
function profile_manager_get_custom_field_types($register_name) {
	global $PROFILE_MANAGER_FIELD_TYPES;
	
	if (isset($PROFILE_MANAGER_FIELD_TYPES) && isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])) {
		return $PROFILE_MANAGER_FIELD_TYPES[$register_name];
	}
	
	return false;
}

/**
 * Returns an array containing the categories and the fields ordered by category and field order
 *
 * @param ElggUser $user               User to check
 * @param boolean  $edit               Are you editing profile fields
 * @param boolean  $register           Are you on the register page
 * @param boolean  $profile_type_limit Should it be limited by the profile type
 * @param int      $profile_type_guid  The guid of the profile type to limit the results to
 *
 * @return unknown
 */
function profile_manager_get_categorized_fields($user = null, $edit = false, $register = false, $profile_type_limit = false, $profile_type_guid = false) {
	
	$result = [];
	$profile_type = null;
	
	if ($register == true) {
		// failsafe for edit
		$edit = true;
	}
	
	if (!empty($user) && ($user instanceof ElggUser)) {
		$profile_type_guid = $user->custom_profile_type;
		
		if (!empty($profile_type_guid)) {
			$profile_type = get_entity($profile_type_guid);
			
			// check if profile type is a REAL profile type
			if (!empty($profile_type) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
				if ($profile_type->getSubtype() != CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE) {
					$profile_type = null;
				}
			}
		}
	} elseif (!empty($profile_type_guid)) {
		$profile_type = get_entity($profile_type_guid);
	}
	
	$result['categories'] = [];
	$result['categories'][0] = [];
	$result['fields'] = [];
	$ordered_cats = [];
			
	// get ordered categories
	$cats = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
	]);
	if ($cats) {
		foreach ($cats as $cat) {
			$ordered_cats[$cat->order] = $cat;
		}
		ksort($ordered_cats);
	}
	
	// get filtered categories
	$filtered_ordered_cats = [];
	// default category at index 0
	$filtered_ordered_cats[0] = [];
	
	if (!empty($ordered_cats)) {
		foreach ($ordered_cats as $key => $cat) {
			
			if (!$edit || $profile_type_limit) {
				
				$rel_count = elgg_get_entities([
					'type' => 'object',
					'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
					'count' => true,
					'owner_guid' => $cat->getOwnerGUID(),
					'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
					'relationship_guid' => $cat->getGUID(),
					'inverse_relationship' => true
				]);
				
				if ($rel_count == 0) {
					$filtered_ordered_cats[$cat->guid] = [];
					$result['categories'][$cat->guid] = $cat;
				} elseif (!empty($profile_type) && check_entity_relationship($profile_type->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $cat->guid)) {
					$filtered_ordered_cats[$cat->guid] = [];
					$result['categories'][$cat->guid] = $cat;
				}
			} else {
				$filtered_ordered_cats[$cat->guid] = [];
				$result['categories'][$cat->guid] = $cat;
			}
		}
	}
			
	// adding fields to categories
	$fields = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
	]);
	
	if ($fields) {
		
		foreach ($fields as $field) {
			
			if (!($cat_guid = $field->category_guid)) {
				$cat_guid = 0; // 0 is default
			}
			
			$admin_only = $field->admin_only;
			if ($register || $admin_only != 'yes' || elgg_is_admin_logged_in()) {
				if ($edit) {
					if (!$register || $field->show_on_register == 'yes') {
						$filtered_ordered_cats[$cat_guid][$field->order] = $field;
					}
				} else {
					// only add if value exists
					$metadata_name = $field->metadata_name;
					$user_value = $user->$metadata_name;
					
					if (!empty($user_value) || $user_value === 0) {
						$filtered_ordered_cats[$cat_guid][$field->order] = $field;
					}
				}
			}
		}
	}
	
	// sorting fields and filtering empty categories
	foreach ($filtered_ordered_cats as $cat_guid => $fields) {
		if (!empty($fields)) {
			ksort($fields);
			$result['fields'][$cat_guid] = $fields;
		} else {
			unset($result['categories'][$cat_guid]);
		}
	}
	
	//  fire hook to see if other plugins have extra fields
	$hook_params = [
		'user' => $user,
		'edit' => $edit,
		'register' => $register,
		'profile_type_limit' => $profile_type_limit,
		'profile_type_guid' => $profile_type_guid
	];
	
	return elgg_trigger_plugin_hook('categorized_profile_fields', 'profile_manager', $hook_params, $result);
}

/**
 * Function just now returns only ordered (name is prepped for future release which should support categories)
 *
 * @param ElggGroup $group Group to check the values of the fields against
 *
 * @return array
 */
function profile_manager_get_categorized_group_fields($group = null) {
	
	$result = ['fields' => []];
	
	// Get all custom group fields
	$fields = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
	]);

	if ($fields) {
		foreach ($fields as $field) {
			$admin_only = $field->admin_only;
			if ($admin_only != 'yes' || elgg_is_admin_logged_in()) {
				$result['fields'][$field->order] = $field;
			}
		}
		ksort($result['fields']);
	}
	
	//  fire hook to see if other plugins have extra fields
	return elgg_trigger_plugin_hook('categorized_group_fields', 'profile_manager', ['entity' => $group], $result);
}

/**
 * Returns an array with percentage completeness and required / missing fields
 *
 * @param ElggUser $user User to count completeness for
 *
 * @return boolean|array
 */
function profile_manager_profile_completeness($user = null) {
	
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (!$user instanceof \ElggUser) {
		return false;
	}
		
	$required_fields = [];
	$missing_fields = [];
	$avatar_missing = false;
	
	$ia = elgg_set_ignore_access(true);
	
	$fields = profile_manager_get_categorized_fields($user, true, false, true);
	$categories = (array) elgg_extract('categories', $fields, []);
	
	foreach ($categories as $cat_guid => $cat) {
		$cat_fields = $fields['fields'][$cat_guid];
		
		foreach ($cat_fields as $field) {
			
			if ($field->count_for_completeness !== 'yes') {
				continue;
			}
			
			$required_fields[] = $field;
			$metaname = $field->metadata_name;
			if (empty($user->$metaname) && ($user->$metaname !== 0)) {
				$missing_fields[] = $field;
			}
		}
	}
	
	$avatar_percentage = (int) elgg_get_plugin_setting('profile_completeness_avatar', 'profile_manager');
	if ($avatar_percentage && empty($user->icontime)) {
		$avatar_missing = true;
	}
	
	$percentage_completeness = 100;
		
	if (count($required_fields)) {
		$percentage_completeness -= (count($missing_fields) / count($required_fields)) * (100 - $avatar_percentage);
	}
	
	if ($avatar_missing) {
		$percentage_completeness -= $avatar_percentage;
	}
	
	$percentage_completeness = round($percentage_completeness);

	elgg_set_ignore_access($ia);
	
	return [
		'required_fields' => $required_fields,
		'missing_fields' => $missing_fields,
		'avatar_missing' => $avatar_missing,
		'percentage_completeness' => $percentage_completeness,
	];
}
