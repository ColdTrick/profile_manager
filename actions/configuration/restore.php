<?php
/**
* Profile Manager
*
* Restore of profile fields backup
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$site_guid = elgg_get_site_entity()->getGUID();

$json = get_uploaded_file('restoreFile');
if (empty($json)) {
	register_error(elgg_echo('profile_manager:actions:restore:error:nofile'));
	forward(REFERER);
}

$data = json_decode($json, true);
if (empty($data)) {
	register_error(elgg_echo('profile_manager:actions:restore:error:json'));
	forward(REFERER);
}

$requestedfieldtype = get_input('fieldtype');
$fieldtype = $data['info']['fieldtype'];
$md5 = $data['info']['md5'];
$fields = $data['fields'];

// check if field data is corrupted

if (empty($fieldtype) || empty($md5) || empty($fields) || (md5(print_r($fields, true)) !== $md5)) {
	register_error(elgg_echo('profile_manager:actions:restore:error:corrupt'));
	forward(REFERER);
}

// check if selected file is same type as requested
if ($requestedfieldtype !== $fieldtype) {
	register_error(elgg_echo('profile_manager:actions:restore:error:fieldtype'));
	forward(REFERER);
}

// clear cache
elgg_get_system_cache()->delete("profile_manager_profile_fields_{$site_guid}");
elgg_get_system_cache()->delete("profile_manager_group_fields_{$site_guid}");

// remove existing fields
$entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => $fieldtype,
	'limit' => false,
	'owner_guid' => $site_guid
]);

$error = false;

if (!empty($entities)) {
	foreach ($entities as $entity) {
		if (!$entity->delete()) {
			$error = true;
		}
	}
}

if ($error) {
	register_error(elgg_echo('profile_manager:actions:restore:error:deleting'));
	forward(REFERER);
}

// add new fields with configured metadata
foreach ($fields as $index => $field) {
	// create new field
	$object = new ElggObject();
	$object->owner_guid = $site_guid;
	$object->container_guid = $site_guid;
	$object->access_id = ACCESS_PUBLIC;
	$object->subtype = $fieldtype;
	$object->save();
						
	foreach ($field as $metadata_key => $metadata_value) {
		// add field metadata
		if (!empty($metadata_value)) {
			$object->$metadata_key = $metadata_value;
		}
	}
	$object->save();
}

// report backup to user
system_message(elgg_echo('profile_manager:actions:restore:success'));

forward(REFERER);
