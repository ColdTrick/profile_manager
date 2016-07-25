<?php

/**
* Profile Manager
*
* Profile Type Add action
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$guid = (int) get_input('guid');
$name = get_input('metadata_name');
$label = get_input('metadata_label');
$metadata_label_plural = get_input('metadata_label_plural');
$description = get_input('metadata_description');
$categories = get_input('categories');

if (empty($name) || !preg_match('/^[a-zA-Z0-9_]{1,}$/', $name)) {
	register_error(elgg_echo('profile_manager:action:profile_types:add:error:name'));
	forward(REFERER);
}

$object = get_entity($guid);
if (!($object instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
	$object = null;
}

if (empty($object)) {
	$object = new \ColdTrick\ProfileManager\CustomProfileType();
	$object->save();
}

if (empty($object)) {
	register_error(elgg_echo('profile_manager:action:profile_types:add:error:object'));
	forward(REFERER);
}

$object->metadata_name = $name;

if (!empty($label)) {
	$object->metadata_label = $label;
} else {
	unset($object->metadata_label);
}
if (!empty($metadata_label_plural)) {
	$object->metadata_label_plural = $metadata_label_plural;
} else {
	unset($object->metadata_label_plural);
}

if (!empty($description)) {
	$object->metadata_description = $description;
} else {
	unset($object->metadata_description);
}

// add category relations
remove_entity_relationships($object->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP);
if (!empty($categories) && is_array($categories)) {
	foreach ($categories as $cat_guid) {
		$object->addRelationship($cat_guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP);
	}
}

if ($object->save()) {
	system_message(elgg_echo('profile_manager:action:profile_types:add:succes'));
} else {
	register_error(elgg_echo('profile_manager:action:profile_types:add:error:save'));
}

forward(REFERER);
