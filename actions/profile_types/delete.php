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

$meta_name = 'custom_profile_type';

// remove corresponding profile type metadata from userobjects
$entities = new ElggBatch('elgg_get_entities_from_metadata', [
	'type' => 'user',
	'limit' => false,
	'metadata_name_value_pairs' => ['name' => $meta_name, 'value' => $guid],
]);

foreach ($entities as $entity) {
	// unset currently deleted profile type for user
	unset($entity->$meta_name);
}

return elgg_ok_response('', elgg_echo('profile_manager:action:profile_types:delete:succes'));
