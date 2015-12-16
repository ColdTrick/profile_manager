<?php
/**
* Profile Manager
*
* Action to toggle profile field metadata
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$allowed = [
	'mandatory',
	'show_on_register',
	'user_editable',
	'output_as_tags',
	'admin_only',
	'count_for_completeness',
];

$guid = get_input('guid');
$field = get_input('field');

if (empty($guid) || !in_array($field, $allowed)) {
	register_error(elgg_echo('profile_manager:actions:toggle_option:error:unknown'));
	return;
}

$entity = get_entity($guid);
if (!elgg_instanceof($entity, 'object', CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) && !elgg_instanceof($entity, 'object', CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE)) {
	register_error(elgg_echo('profile_manager:actions:toggle_option:error:unknown'));
	return;
}

if ($entity->$field == 'yes') {
	$entity->$field = 'no';
} else {
	$entity->$field = 'yes';
}
// need to save to trigger a memcache update
$entity->save();
