<?php

use ColdTrick\ProfileManager\CustomField;
use ColdTrick\ProfileManager\CustomFieldCategory;
use ColdTrick\ProfileManager\CustomGroupField;
use ColdTrick\ProfileManager\CustomProfileField;
use ColdTrick\ProfileManager\CustomProfileType;
use ColdTrick\ProfileManager\DefaultFieldCategory;
use ColdTrick\ProfileManager\DefaultProfileType;

/**
 * Events for Profile Manager
 */

/**
 * Registes all custom field types
 *
 * @return void
 */
function profile_manager_register_custom_field_types() {
	// registering profile field types
	$profile_options = [
		'show_on_register' => true,
		'mandatory' => true,
		'user_editable' => true,
		'output_as_tags' => true,
		'admin_only' => true,
		'count_for_completeness' => true,
	];

	$location_options = $profile_options;
	unset($location_options['output_as_tags']);

	$dropdown_options = $profile_options;
	$dropdown_options['blank_available'] = true;

	$radio_options = $profile_options;
	$radio_options['blank_available'] = true;

	$tel_options = $profile_options;
	$tel_options['output_as_tags'] = false;

	//$file_options = array(
	//	'user_editable' => true,
	//	'admin_only' => true
	//);

	$pm_rating_options = $profile_options;
	unset($pm_rating_options['output_as_tags']);

	$social_options = $profile_options;
	$social_options['output_as_tags'] = false;

	profile_manager_add_custom_field_type('custom_profile_field_types', 'text', elgg_echo('profile:field:text'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'longtext', elgg_echo('profile:field:longtext'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'tags', elgg_echo('profile:field:tags'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'url', elgg_echo('profile:field:url'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'email', elgg_echo('profile:field:email'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'tel', elgg_echo('profile_manager:admin:options:tel'), $tel_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'date', elgg_echo('profile:field:date'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_rating', elgg_echo('profile_manager:admin:options:pm_rating'), $pm_rating_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_twitter', elgg_echo('profile_manager:admin:options:pm_twitter'), $social_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_facebook', elgg_echo('profile_manager:admin:options:pm_facebook'), $social_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_linkedin', elgg_echo('profile_manager:admin:options:pm_linkedin'), $social_options);
	//profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_file', elgg_echo('profile_manager:admin:options:file'), $file_options);
	// registering group field types
	$group_options = [
		'output_as_tags' => true,
		'admin_only' => true,
	];

	$dropdown_options = $group_options;
	$dropdown_options['blank_available'] = true;

	$radio_options = $group_options;
	$radio_options['blank_available'] = true;

	$location_options = $group_options;
	unset($location_options['output_as_tags']);

	$tel_options = $group_options;
	$tel_options['output_as_tags'] = false;

	profile_manager_add_custom_field_type('custom_group_field_types', 'text', elgg_echo('profile:field:text'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'longtext', elgg_echo('profile:field:longtext'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'tags', elgg_echo('profile:field:tags'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'url', elgg_echo('profile:field:url'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'email', elgg_echo('profile:field:email'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'tel', elgg_echo('profile_manager:admin:options:tel'), $tel_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'date', elgg_echo('profile:field:date'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $group_options);
}

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
function profile_manager_add_custom_field_type($register_name, $field_type, $field_display_name, $options) {
	global $PROFILE_MANAGER_FIELD_TYPES;

	if (!isset($PROFILE_MANAGER_FIELD_TYPES)) {
		$PROFILE_MANAGER_FIELD_TYPES = array();
	}
	if (!isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])) {
		$PROFILE_MANAGER_FIELD_TYPES[$register_name] = array();
	}

	$field_config = new stdClass();
	$field_config->name = $field_display_name;
	$field_config->type = $field_type;
	$field_config->options = $options;

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
 * Function to upload a profile icon on register of a user
 *
 * @param ElggUser $user The user to add the profile icons to
 *
 * @return boolean
 */
function profile_manager_add_profile_icon($user) {
	if (!$user->saveIconFromUploadedFile('profile_icon')) {
		register_error(elgg_echo('avatar:resize:fail'));
		return false;
	}

	return true;
}

/**
 * Returns an array containing the categories and the fields ordered by category and field order
 *
 * @param string            $field_type   Field type (profile|group)
 * @param ElggEntity        $entity       Entity that field is applied to
 * @param CustomProfileType $profile_type Custom profile type
 * @param array             $options      Other options
 * @return array
 */
function profile_manager_get_entity_fields($field_type = 'profile', ElggEntity $entity = null, CustomProfileType $profile_type = null, array $options = []) {

	$result = [
		'categories' => [],
		'fields' => [],
	];

	$creating = elgg_extract('creating', $options, false);
	$editing = elgg_extract('editing', $options, false);

	if ($creating == true) {
		// failsafe for edit
		$editing = true;
	}

	$is_valid_field = function($field) use ($entity, $editing, $creating) {
		if ($field->admin_only == 'yes' && !elgg_is_admin_logged_in()) {
			return false;
		}

		if ($editing) {
			return !$creating || $field->show_on_register == 'yes';
		}

		// only add if value exists
		$metadata_name = $field->metadata_name;
		$user_value = $entity->$metadata_name;
		return !empty($user_value) || $user_value === 0;
	};

	// Default category fields
	$default_category = new DefaultFieldCategory();
	$fields = profile_manager_get_category_fields($default_category, $field_type);
	$fields = array_filter($fields, $is_valid_field);
	if (!empty($fields)) {
		$result['categories'][0] = $default_category;
		$result['fields'][0] = array_filter($fields, $is_valid_field);
	}

	if (!$profile_type) {
		$ordered_categories = profile_manager_get_categories();
	} else {
		$ordered_categories = profile_manager_get_categories($profile_type);
	}

	foreach ($ordered_categories as $category) {
		$fields = profile_manager_get_category_fields($category, $field_type);
		$fields = array_filter($fields, $is_valid_field);
		if (!empty($fields)) {
			$result['categories'][$category->guid] = $category;
			$result['fields'][$category->guid] = array_filter($fields, $is_valid_field);
		}
	}

	$result['categories'] = array_filter($result['categories']);

	return $result;
}

/**
 * Returns an array containing the categories and the fields ordered by category and field order
 *
 * @param ElggEntity $entity                   User to check
 * @param boolean    $editing                  Are you editing profile fields
 * @param boolean    $registering              Are you on the register page
 * @param boolean    $restrict_to_profile_type Filter fields and categories by profile type
 * @param int        $profile_type_guid        The guid of the profile type to limit the results to
 * @return array
 */
function profile_manager_get_categorized_fields($entity = null, $editing = false, $registering = false, $restrict_to_profile_type = null, $profile_type_guid = null) {

	$result = [
		'categories' => [],
		'fields' => [],
	];

	$profile_type = null;

	if ($registering == true) {
		// failsafe for edit
		$editing = true;
	}

	if (!isset($restrict_to_profile_type)) {
		$restrict_to_profile_type = !$editing && !$registering;
	}

	if ($restrict_to_profile_type) {
		if (!isset($profile_type_guid) && $entity instanceof ElggEntity) {
			$profile_type_guid = (int) $entity->custom_profile_type;
		}
		if ($profile_type_guid === 0) {
			$profile_type = new DefaultProfileType();
		} else if ($profile_type_guid) {
			$profile_type = get_entity($profile_type_guid);
		}
	}

	$result = profile_manager_get_entity_fields('profile', $entity, $profile_type, [
		'editing' => $editing,
		'creating' => $registering,
	]);

	//  fire hook to see if other plugins have extra fields
	$hook_params = [
		'user' => $entity,
		'edit' => $editing,
		'register' => $registering,
		'profile_type_limit' => $restrict_to_profile_type,
		'profile_type_guid' => $profile_type_guid
	];

	return elgg_trigger_plugin_hook('categorized_profile_fields', 'profile_manager', $hook_params, $result);
}

/**
 * Function just now returns only ordered (name is prepped for future release which should support categories)
 *
 * @param ElggGroup $group    Group to check the values of the fields against
 * @param bool      $editing  Is this group being edited?
 * @param bool      $creating Is this group being created?
 * @return array
 */
function profile_manager_get_categorized_group_fields($group = null, $editing = false, $creating = false) {

	$result = profile_manager_get_entity_fields('group', $group, null, [
		'creating' => $creating,
		'editing' => $editing,
	]);

	// Groups only have a default category
	$result['fields'] = $result['fields'][0];

	//  fire hook to see if other plugins have extra fields
	return elgg_trigger_plugin_hook('categorized_group_fields', 'profile_manager', ['group' => $group], $result);
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

	if (!elgg_instanceof($user, 'user')) {
		return false;
	}

	$required_fields = [];
	$missing_fields = [];
	$percentage_completeness = 100;
	$avatar_missing = false;

	$ia = elgg_set_ignore_access(true);

	$fields = profile_manager_get_categorized_fields($user, true, false, true);

	if (!empty($fields['categories'])) {

		foreach ($fields['categories'] as $cat_guid => $cat) {
			$cat_fields = $fields['fields'][$cat_guid];

			foreach ($cat_fields as $field) {

				if ($field->count_for_completeness == 'yes') {
					$required_fields[] = $field;
					$metaname = $field->metadata_name;
					if (empty($user->$metaname) && ($user->$metaname !== 0)) {
						$missing_fields[] = $field;
					}
				}
			}
		}
	}

	$avatar_percentage = (int) elgg_get_plugin_setting('profile_completeness_avatar', 'profile_manager');
	if ($avatar_percentage) {
		if (!$user->icontime) {
			$avatar_missing = true;
		}
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

/**
 * Returns a config array of field types
 * @return array
 */
function profile_manager_get_field_types() {

	$default = [
		'profile' => [
			'subtype' => CustomProfileField::SUBTYPE,
			'metadata_types' => profile_manager_get_custom_field_types('custom_profile_field_types'),
			'options' => [
				'show_on_register',
				'mandatory',
				'user_editable',
				'output_as_tags',
				'blank_available',
				'admin_only',
			],
			'entity_type' => 'user',
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
		],
		'group' => [
			'subtype' => CustomGroupField::SUBTYPE,
			'metadata_types' => profile_manager_get_custom_field_types('custom_group_field_types'),
			'options' => [
				'output_as_tags',
				'admin_only',
				'blank_available',
			],
			'entity_type' => 'group',
			'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
		],
	];

	return elgg_trigger_plugin_hook('field_types', 'profile_manager', null, $default);
}

/**
 * Returns an array of categories assigned to a particular profile type
 * ordered by their priority
 * 
 * @param CustomProfileType $profile_type Profile type entity
 * @return CustomFieldCategory[]
 */
function profile_manager_get_categories(CustomProfileType $profile_type = null) {

	$site = elgg_get_site_entity();

	$options = [
		'type' => 'object',
		'subtype' => CustomFieldCategory::SUBTYPE,
		'limit' => false,
		'owner_guid' => $site->guid,
		'site_guid' => $site->guid,
		'order_by_metadata' => [
			'name' => 'order',
			'direction' => 'ASC',
			'as' => 'integer',
		],
	];
	
	if ($profile_type instanceof DefaultProfileType) {
		$relationship = CustomFieldCategory::RELATIONSHIP;
		$dbprefix = elgg_get_config('dbprefix');
		$options['wheres'][] = "
			NOT EXISTS (SELECT 1 FROM {$dbprefix}entity_relationships
			WHERE guid_two = e.guid AND relationship = '$relationship')
		";
		$categories = elgg_get_entities_from_metadata($options);
	} else if ($profile_type) {
		$options['relationship'] = CustomFieldCategory::RELATIONSHIP;
		$options['relationship_guid'] = $profile_type->guid;
		$options['inverse_relationship'] = false;
		$categories = elgg_get_entities_from_relationship($options);
	} else {
		$categories = elgg_get_entities_from_metadata($options);
	}

	return $categories ?: [];
}

/**
 * Returns an array of fields assigned to a specific category
 * If not category is provided, returns fields in the Default category
 * 
 * @param CustomFieldCategory $category Category
 * @param string $field_type Type of fields to return ('profile', 'group')
 * @return CustomField[]
 */
function profile_manager_get_category_fields(CustomFieldCategory $category = null, $field_type = 'profile') {

	$config = profile_manager_get_field_types();
	if (empty($config[$field_type]['subtype'])) {
		return [];
	}

	$site = elgg_get_site_entity();

	$options = [
		'type' => 'object',
		'subtype' => $config[$field_type]['subtype'],
		'limit' => false,
		'owner_guid' => $site->guid,
		'site_guid' => $site->guid,
		'order_by_metadata' => [
			'name' => 'order',
			'direction' => 'ASC',
			'as' => 'integer',
		],
	];

	$dbprefix = elgg_get_config('dbprefix');
	$metastrings = elgg_get_metastring_map(['category_guid', '0', '']);
	$options['joins'][] = "
			LEFT JOIN {$dbprefix}metadata md
			ON md.entity_guid = e.guid AND md.name_id = {$metastrings['category_guid']}
		";

	if (!isset($category) || $category instanceof DefaultFieldCategory) {
		$options['wheres'][] = "(md.id IS NULL OR md.value_id IN ({$metastrings['0']}, {$metastrings['']}))";
	} else {
		$category_guid_metastring_id = elgg_get_metastring_id($category->guid);
		$options['wheres'] = "md.value_id = $category_guid_metastring_id";
	}

	// adding fields to categories
	$fields = elgg_get_entities_from_metadata($options);

	return $fields ?: [];
}
