<?php
/**
* Profile Manager
*
* Category add action
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$name = get_input('metadata_name');
$label = get_input('metadata_label');
$guid = (int) get_input('guid');
$profile_types = get_input('profile_types');
$add = false;

if (empty($name) || !preg_match('/^[a-zA-Z0-9_]{1,}$/', $name)) {
	register_error(elgg_echo('profile_manager:action:category:add:error:name'));
	forward(REFERER);
}
	
$entity = get_entity($guid);
if (!($entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory)) {
	$entity = null;
}

if (empty($entity)) {
	$entity = new \ColdTrick\ProfileManager\CustomFieldCategory();
	$entity->save();
	$add = true;
}

if (empty($entity)) {
	register_error(elgg_echo('profile_manager:action:category:add:error:object'));
	forward(REFERER);
}

$entity->metadata_name = $name;

if (!empty($label)) {
	$entity->metadata_label = $label;
} else {
	unset($entity->metadata_label);
}

// add relationship
remove_entity_relationships($entity->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, true);
if (!empty($profile_types) && is_array($profile_types)) {
	foreach ($profile_types as $type) {
		add_entity_relationship($type, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $entity->guid);
	}
}

// add correct order
if ($add) {
	$count = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
		'count' => true,
		'owner_guid' => elgg_get_site_entity()->getGUID()
	]);
	
	$entity->order = $count;
}

if ($entity->save()) {
	system_message(elgg_echo('profile_manager:action:category:add:succes'));
} else {
	register_error(elgg_echo('profile_manager:action:category:add:error:save'));
}

forward(REFERER);
