<?php
/**
 * Profile Manager
 *
 * Action to create/edit profile field
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

use ColdTrick\ProfileManager\CustomField;
use ColdTrick\ProfileManager\CustomGroupField;
use ColdTrick\ProfileManager\CustomProfileField;

$site_guid = elgg_get_site_entity()->guid;

$metadata_name = trim(get_input('metadata_name', ''));
$metadata_label = trim(get_input('metadata_label', ''));
$metadata_input_label = trim(get_input('metadata_input_label', ''));
$metadata_hint = trim(get_input('metadata_hint', ''));
$metadata_placeholder = trim(get_input('metadata_placeholder', ''));
$metadata_type = get_input('metadata_type');
$metadata_options = get_input('metadata_options');

$show_on_register = get_input('show_on_register');
$mandatory = get_input('mandatory');
$user_editable = get_input('user_editable');
$show_on_profile = get_input('show_on_profile');
$output_as_tags = get_input('output_as_tags');
$admin_only = get_input('admin_only');
$blank_available = get_input('blank_available');

$type = get_input('type', 'profile');

$guid = (int) get_input('guid');
$current_field = false;

$reserved_metadata_names = array_merge(\ElggEntity::PRIMARY_ATTR_NAMES, [
	'title', 'name', 'username', 'email', 'membership', 'group_acl',
	'password', 'salt', 'language', 'code', 'banned', 'admin', 'custom_profile_type',
	'icon_coords', 'header_coords'
]);

if (!empty($guid)) {
	$current_field = get_entity($guid);
	if (!$current_field instanceof CustomField) {
		// wrong custom field type
		return elgg_error_response(elgg_echo('profile_manager:action:new:error:type'));
	}
}

if (!in_array($type, ['profile', 'group'])) {
	// wrong custom field type
	return elgg_error_response(elgg_echo('profile_manager:action:new:error:type'));
}

if (empty($metadata_name)) {
	// no name
	return elgg_error_response(elgg_echo('profile_manager:actions:new:error:metadata_name_missing'));
}

if (in_array(strtolower($metadata_name), $reserved_metadata_names) || !preg_match('/^[a-zA-Z0-9_]+$/', $metadata_name)) {
	// invalid name
	return elgg_error_response(elgg_echo('profile_manager:actions:new:error:metadata_name_invalid'));
}

if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect']) && empty($metadata_options)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:new:error:metadata_options'));
}

if (empty($current_field)) {
	foreach (elgg()->fields->get('user', 'user') as $existing_field) {
		if ($metadata_name === $existing_field['name']) {
			return elgg_error_response(elgg_echo('profile_manager:actions:new:error:metadata_name_invalid'));
		}
	}
}

$new_options = [];
$options_error = false;
if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect'])) {
	$temp_options = explode(',', $metadata_options);
	foreach ($temp_options as $key => $option) {
		$trimmed_option = trim($option);
		if (!empty($trimmed_option)) {
			$new_options[$key] = $trimmed_option;
		}
	}
	
	if (count($new_options) > 0) {
		$new_options = implode(',', $new_options);
	} else {
		$options_error = true;
	}
}

if ($options_error) {
	return elgg_error_response(elgg_echo('profile_manager:actions:new:error:metadata_options'));
}

if ($current_field) {
	$field = $current_field;
} else {
	if ($type === 'group') {
		$field = new CustomGroupField();
	} else {
		$field = new CustomProfileField();
	}
		
	$field->save();
}

$field->metadata_name = $metadata_name;
$field->metadata_label = $metadata_label;
$field->metadata_input_label = $metadata_input_label;
$field->metadata_hint = $metadata_hint;
$field->metadata_placeholder = $metadata_placeholder;

$field->metadata_type = $metadata_type;
if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect'])) {
	$field->metadata_options = $new_options;
} else {
	unset($field->metadata_options);
}

if ($type === 'profile') {
	$field->show_on_register = $show_on_register;
	$field->mandatory = $mandatory;
	$field->user_editable = $user_editable;
}

$field->admin_only = $admin_only;
$field->show_on_profile = $show_on_profile;
$field->output_as_tags = $output_as_tags;
$field->blank_available = $blank_available;

if (empty($current_field)) {
	$max_fields = elgg_count_entities([
		'type' => 'object',
		'subtype' => $field->getSubtype(),
		'owner_guid' => $site_guid,
	]) + 1;
	$field->order = $max_fields;
}

elgg_delete_system_cache('profile_manager_user:user_fields');
elgg_delete_system_cache('profile_manager_group:group_fields');

if (!$field->save()) {
	return elgg_error_response(elgg_echo('profile_manager:actions:new:error:unknown'));
}

return elgg_ok_response('', elgg_echo('profile_manager:actions:new:success'));
