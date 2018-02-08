<?php

/**
* Profile Manager
*
* Category delete action
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$guid = (int) get_input('guid');

if (empty($guid)) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:delete:error:guid'));
}

$entity = get_entity($guid);

if (!($entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory)) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:delete:error:type'));
}

// remove reference to this category on related profile fields
$fields = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
	'metadata_name_value_pairs' => ['name' => 'category_guid', 'value' => $guid],
]);

if ($fields) {
	foreach ($fields as $field) {
		unset($field->category_guid);
	}
}

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:delete:error:delete'));
}

return elgg_ok_response('', elgg_echo('profile_manager:action:category:delete:succes'));
