<?php
/**
 * Action to toggle profile field metadata
 */

use ColdTrick\ProfileManager\CustomField;

$allowed = [
	'mandatory',
	'show_on_register',
	'user_editable',
	'output_as_tags',
	'admin_only',
];

$guid = get_input('guid');
$field = get_input('field');

if (empty($guid) || !in_array($field, $allowed)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:toggle_option:error:unknown'));
}

$entity = get_entity($guid);
if (!$entity instanceof CustomField) {
	return elgg_error_response(elgg_echo('profile_manager:actions:toggle_option:error:unknown'));
}

if ($entity->$field === 'yes') {
	$entity->$field = 'no';
} else {
	$entity->$field = 'yes';
}

// need to save to trigger a memcache update
$entity->save();
