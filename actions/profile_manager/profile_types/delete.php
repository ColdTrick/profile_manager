<?php
/**
* Profile Manager
*
* Profile Type Delete action
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$guid = (int) get_input('guid');

if (empty($guid)) {
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:delete:error:guid'));
}

$entity = get_entity($guid);

if (!elgg_instanceof($entity, 'object', CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE)) {
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:delete:error:type'));
}

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:delete:error:delete'));
}

// remove corresponding profile type metadata from userobjects
$entities = elgg_get_entities([
	'type' => 'user',
	'limit' => false,
	'batch' => true,
	'batch_inc_offset' => false,
	'metadata_name_value_pairs' => [
		'name' => 'custom_profile_type',
		'value' => $guid,
	],
]);

foreach ($entities as $entity) {
	// unset currently deleted profile type for user
	unset($entity->custom_profile_type);
}

return elgg_ok_response('', elgg_echo('profile_manager:action:profile_types:delete:succes'));
