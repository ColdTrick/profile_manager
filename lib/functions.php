<?php

use ColdTrick\ProfileManager\CustomFieldCategory;
use ColdTrick\ProfileManager\CustomProfileType;

/**
 * Returns the profile manager field types
 *
 * @param string $type subtype of the profile types to get the allowed fields for
 *
 * @return array
 */
function profile_manager_get_custom_field_types(string $type): array {
	static $types;
	
	if (!isset($types[$type])) {
		$items = (array) elgg_trigger_event_results("types:{$type}", 'profile_manager', []);
		foreach ($items as $item) {
			$types[$type][$item->type] = $item;
		}
	}
	
	return $types[$type];
}

/**
 * Returns an array containing the categories and the fields ordered by category and field order
 *
 * @param \ElggUser $user               User to check
 * @param boolean   $edit               Are you editing profile fields
 * @param boolean   $register           Are you on the register page
 * @param boolean   $profile_type_limit Should it be limited by the profile type
 * @param int       $profile_type_guid  The guid of the profile type to limit the results to
 *
 * @return array
 */
function profile_manager_get_categorized_fields(\ElggUser $user = null, bool $edit = false, bool $register = false, bool $profile_type_limit = false, int $profile_type_guid = null): array {
	
	$result = [];
	
	/** @var \ColdTrick\ProfileManager\CustomProfileType $profile_type */
	$profile_type = null;
	
	if ($register == true) {
		// failsafe for edit
		$edit = true;
	}
	
	if ($user instanceof ElggUser) {
		$profile_type_guid = $user->custom_profile_type;
		
		if (!empty($profile_type_guid)) {
			$profile_type = get_entity($profile_type_guid);
			
			// check if profile type is a REAL profile type
			if (!empty($profile_type) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
				if ($profile_type->getSubtype() !== CustomProfileType::SUBTYPE) {
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
		'subtype' => CustomFieldCategory::SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_site_entity()->guid,
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
		foreach ($ordered_cats as $cat) {
			if (!$edit || $profile_type_limit) {
				$rel_count = elgg_count_entities([
					'type' => 'object',
					'subtype' => CustomProfileType::SUBTYPE,
					'owner_guid' => $cat->getOwnerGUID(),
					'relationship' => \ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP,
					'relationship_guid' => $cat->guid,
					'inverse_relationship' => true
				]);
				
				if ($rel_count == 0) {
					$filtered_ordered_cats[$cat->guid] = [];
					$result['categories'][$cat->guid] = $cat;
				} elseif (!empty($profile_type) && $profile_type->hasRelationship($cat->guid, $profile_type::CATEGORY_RELATIONSHIP)) {
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
		'subtype' => \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_site_entity()->guid,
	]);
	
	if ($fields) {
		foreach ($fields as $field) {
			$cat_guid = $field->category_guid ?: 0; // 0 is default
					
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
	
	//  trigger event to see if other plugins have extra fields
	$params = [
		'user' => $user,
		'edit' => $edit,
		'register' => $register,
		'profile_type_limit' => $profile_type_limit,
		'profile_type_guid' => $profile_type_guid,
	];
	
	return (array) elgg_trigger_event_results('categorized_profile_fields', 'profile_manager', $params, $result);
}

/**
 * Function just now returns only ordered (name is prepped for future release which should support categories)
 *
 * @param \ElggGroup $group Group to check the values of the fields against
 *
 * @return array
 */
function profile_manager_get_categorized_group_fields(\ElggGroup $group = null): array {
	
	$result = ['fields' => []];
	
	// Get all custom group fields
	$fields = elgg_get_entities([
		'type' => 'object',
		'subtype' => \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_site_entity()->guid,
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
	
	//  trigger event to see if other plugins have extra fields
	return (array) elgg_trigger_event_results('categorized_group_fields', 'profile_manager', ['entity' => $group], $result);
}

/**
 * Returns an array with percentage completeness and required / missing fields
 *
 * @param ElggUser $user User to count completeness for
 *
 * @return array
 */
function profile_manager_profile_completeness(\ElggUser $user = null): array {
	
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (!$user instanceof \ElggUser) {
		return [];
	}
	
	return elgg_call(ELGG_IGNORE_ACCESS, function() use ($user) {
		$required_fields = [];
		$missing_fields = [];
		$avatar_missing = false;
		
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
		
		return [
			'required_fields' => $required_fields,
			'missing_fields' => $missing_fields,
			'avatar_missing' => $avatar_missing,
			'percentage_completeness' => $percentage_completeness,
		];
	});
}
