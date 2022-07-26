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

use ColdTrick\ProfileManager\CustomFieldCategory;

$name = get_input('metadata_name');
$label = get_input('metadata_label');
$guid = (int) get_input('guid');
$profile_types = get_input('profile_types');
$add = false;

if (empty($name) || !preg_match('/^[a-zA-Z0-9_]{1,}$/', $name)) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:add:error:name'));
}
	
$entity = get_entity($guid);
if (!$entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
	$entity = null;
}

if (empty($entity)) {
	$entity = new \ColdTrick\ProfileManager\CustomFieldCategory();
	$entity->save();
	$add = true;
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:add:error:object'));
}

$entity->metadata_name = $name;
$entity->metadata_label = $label;

// add relationship
$entity->removeAllRelationships(\ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP, true);
if (!empty($profile_types) && is_array($profile_types)) {
	foreach ($profile_types as $type) {
		$profile_type_entity = get_entity($type);
		if ($profile_type_entity instanceof \ColdTrick\ProfileManager\CustomProfileType) {
			$profile_type_entity->addRelationship($entity->guid, $profile_type_entity::CATEGORY_RELATIONSHIP);
		}
	}
}

// add correct order
if ($add) {
	$entity->order = elgg_count_entities([
		'type' => 'object',
		'subtype' => CustomFieldCategory::SUBTYPE,
		'owner_guid' => elgg_get_site_entity()->guid,
	]);
}

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('profile_manager:action:category:add:error:save'));
}

return elgg_ok_response('', elgg_echo('profile_manager:action:category:add:succes'));
