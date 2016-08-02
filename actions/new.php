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

$site_guid = elgg_get_site_entity()->getGUID();

$metadata_name = trim(get_input('metadata_name'));
$metadata_label = trim(get_input('metadata_label'));
$metadata_input_label = trim(get_input('metadata_input_label'));
$metadata_hint = trim(get_input('metadata_hint'));
$metadata_placeholder = trim(get_input('metadata_placeholder'));
$metadata_type = get_input('metadata_type');
$metadata_options = get_input('metadata_options');

$show_on_register = get_input('show_on_register');
$mandatory = get_input('mandatory');
$user_editable = get_input('user_editable');
$output_as_tags = get_input('output_as_tags');
$admin_only = get_input('admin_only');
$blank_available = get_input('blank_available');

$type = get_input('type', 'profile');

$guid = (int) get_input('guid');
$current_field = false;

$reserved_metadata_names = [
	'guid', 'title', 'access_id', 'owner_guid', 'container_guid', 'type', 'subtype', 'name', 'username', 'email', 'membership', 'group_acl', 'icon', 'site_guid',
	'time_created', 'time_updated', 'enabled', 'tables_split', 'tables_loaded', 'password', 'salt', 'language', 'code', 'banned', 'admin', 'custom_profile_type',
	'icontime', 'x1', 'x2', 'y1', 'y2'
];

if ($guid) {
	$current_field = get_entity($guid);
}
if ($current_field && ($current_field->getSubtype() != CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE && $current_field->getSubtype() != CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE)) {
	// wrong custom field type
	register_error(elgg_echo('profile_manager:action:new:error:type'));
	forward(REFERER);
}

if (!in_array($type, ['profile', 'group'])) {
	// wrong custom field type
	register_error(elgg_echo('profile_manager:action:new:error:type'));
	forward(REFERER);
}

if (empty($metadata_name)) {
	// no name
	register_error(elgg_echo('profile_manager:actions:new:error:metadata_name_missing'));
	forward(REFERER);
}

if (in_array(strtolower($metadata_name), $reserved_metadata_names) || !preg_match('/^[a-zA-Z0-9_]{1,}$/', $metadata_name)) {
	// invalid name
	register_error(elgg_echo('profile_manager:actions:new:error:metadata_name_invalid'));
	forward(REFERER);
}

if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect']) && empty($metadata_options)) {
	register_error(elgg_echo('profile_manager:actions:new:error:metadata_options'));
	forward(REFERER);
}

if (empty($current_field) && array_key_exists($metadata_name, elgg_get_config('profile_fields'))) {
	register_error(elgg_echo('profile_manager:actions:new:error:metadata_name_invalid'));
	forward(REFERER);
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
	register_error(elgg_echo('profile_manager:actions:new:error:metadata_options'));
	forward(REFERER);
}

$subtype = "custom_{$type}_field";
$options = [
	'type' => 'object',
	'subtype' => $subtype,
	'count' => true,
	'owner_guid' => $site_guid,
];

$max_fields = elgg_get_entities($options) + 1;

if ($current_field) {
	$field = $current_field;
} else {
	$field = new ElggObject();
		
	$field->owner_guid = $site_guid;
	$field->container_guid = $site_guid;
	$field->access_id = ACCESS_PUBLIC;
	$field->subtype = $subtype;
	$field->save();
}

$field->metadata_name = $metadata_name;

if (!empty($metadata_label)) {
	$field->metadata_label = $metadata_label;
} elseif ($current_field) {
	unset($field->metadata_label);
}

if (!empty($metadata_input_label)) {
	$field->metadata_input_label = $metadata_input_label;
} elseif ($current_field) {
	unset($field->metadata_input_label);
}

if (!empty($metadata_hint)) {
	$field->metadata_hint = $metadata_hint;
} elseif ($current_field) {
	unset($field->metadata_hint);
}

if (!empty($metadata_placeholder)) {
	$field->metadata_placeholder = $metadata_placeholder;
} elseif ($current_field) {
	unset($field->metadata_placeholder);
}

$field->metadata_type = $metadata_type;
if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect'])) {
	$field->metadata_options = $new_options;
} elseif ($current_field) {
	$field->deleteMetadata('metadata_options');
}

if ($type == 'profile') {
	$field->show_on_register = $show_on_register;
	$field->mandatory = $mandatory;
	$field->user_editable = $user_editable;
}

$field->admin_only = $admin_only;
$field->output_as_tags = $output_as_tags;
$field->blank_available = $blank_available;

if (empty($current_field)) {
	$field->order = $max_fields;
}

if ($field->save()) {
	system_message(elgg_echo('profile_manager:actions:new:success'));
} else {
	register_error(elgg_echo('profile_manager:actions:new:error:unknown'));
}

// update system cache
elgg_get_system_cache()->delete("profile_manager_{$type}_fields_{$site_guid}");

forward(REFERER);
