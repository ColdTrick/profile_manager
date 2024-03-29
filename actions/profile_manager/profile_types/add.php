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
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:add:error:name'));
}

$object = get_entity($guid);
if (!$object instanceof \ColdTrick\ProfileManager\CustomProfileType) {
	$object = null;
}

if (empty($object)) {
	$object = new \ColdTrick\ProfileManager\CustomProfileType();
	$object->save();
}

if (empty($object)) {
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:add:error:object'));
}

$object->metadata_name = $name;
$object->metadata_label = $label;
$object->metadata_label_plural = $metadata_label_plural;
$object->metadata_description = $description;

// add category relations
$object->removeAllRelationships(\ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP);
if (!empty($categories) && is_array($categories)) {
	foreach ($categories as $cat_guid) {
		$object->addRelationship($cat_guid, \ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP);
	}
}

if (!$object->save()) {
	return elgg_error_response(elgg_echo('profile_manager:action:profile_types:add:error:save'));
}

return elgg_ok_response('', elgg_echo('profile_manager:action:profile_types:add:succes'));
