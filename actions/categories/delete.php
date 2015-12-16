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
	register_error(elgg_echo('profile_manager:action:category:delete:error:guid'));
	forward(REFERER);
}

$entity = get_entity($guid);

if (!($entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory)) {
	register_error(elgg_echo('profile_manager:action:category:delete:error:type'));
	forward(REFERER);
}

// remove reference to this category on related profile fields
$fields = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'metadata_name_value_pairs' => ['name' => 'category_guid', 'value' => $guid],
]);

if ($fields) {
	foreach ($fields as $field) {
		unset($field->category_guid);
	}
}

if ($entity->delete()) {
	system_message(elgg_echo('profile_manager:action:category:delete:succes'));
} else {
	register_error(elgg_echo('profile_manager:action:category:delete:error:delete'));
}

forward(REFERER);
