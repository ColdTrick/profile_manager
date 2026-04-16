<?php
/**
 * Profile Manager
 *
 * Restore of profile fields backup
 */

$site_guid = elgg_get_site_entity()->guid;

$json = elgg_get_uploaded_file('restoreFile');
if (empty($json)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:restore:error:nofile'));
}

$data = json_decode(file_get_contents($json), true);
if (empty($data)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:restore:error:json'));
}

$requestedfieldtype = get_input('fieldtype');
$fieldtype = $data['info']['fieldtype'];
$md5 = $data['info']['md5'];
$fields = $data['fields'];

// check if field data is corrupted

if (empty($fieldtype) || empty($md5) || empty($fields) || (md5(print_r($fields, true)) !== $md5)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:restore:error:corrupt'));
}

// check if selected file is same type as requested
if (($requestedfieldtype !== $fieldtype) || !in_array($fieldtype, ['custom_profile_field', 'custom_group_field'])) {
	return elgg_error_response(elgg_echo('profile_manager:actions:restore:error:fieldtype'));
}

// clear cache
elgg_delete_system_cache('profile_manager_user:user_fields');
elgg_delete_system_cache('profile_manager_group:group_fields');

// remove existing fields
$entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => $fieldtype,
	'limit' => false,
	'owner_guid' => $site_guid,
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
	return elgg_error_response(elgg_echo('profile_manager:actions:restore:error:deleting'));
}

// add new fields with configured metadata
foreach ($fields as $index => $field) {
	// create new field
	if ($fieldtype === 'custom_group_field') {
		$object = new \ColdTrick\ProfileManager\CustomGroupField();
	} else {
		$object = new \ColdTrick\ProfileManager\CustomProfileField();
	}
	
	$object->owner_guid = $site_guid;
	$object->container_guid = $site_guid;
	$object->access_id = ACCESS_PUBLIC;
	$object->save();
						
	foreach ($field as $metadata_key => $metadata_value) {
		// add field metadata
		if (!empty($metadata_value)) {
			$object->$metadata_key = $metadata_value;
		}
	}
	
	$object->save();
}

return elgg_ok_response('', elgg_echo('profile_manager:actions:restore:success'));
