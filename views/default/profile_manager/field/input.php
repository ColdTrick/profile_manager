<?php

$field = elgg_extract('field', $vars);
$entity = elgg_extract('entity', $vars);

if ($field->user_editable == 'no') {
	// non editable fields should not be on the form
	return;
}

$metadata_name = $field->metadata_name;

$metadata = elgg_get_metadata([
	'guid' => $entity->guid,
	'metadata_name' => $metadata_name,
	'limit' => false,
		]);

if ($metadata) {
	$metadata = $metadata[0];
	$value = $entity->$metadata_name;
	$access_id = $metadata->access_id;
} else {
	$value = '';
	$access_id = get_default_access($entity);
}

$metadata_field = array_filter([
	'#type' => $field->metadata_type,
	'#label' => $field->getTitle(true),
	'#help' => $field->getHint(),
	'#class' => 'profile-manager-metadata-field',
	'name' => $metadata_name,
	'value' => $value,
	'options' => $field->getOptions(),
	'placeholder' => $field->getPlaceholder(),
	'required' => $field->mandatory == 'yes',
		]);

$access = elgg_extract('access', $vars, false);
if ($access == 'hidden' || $access == 'access') {
	$access_field = [
		'#type' => $access,
		'#class' => 'profile-manager-access-field',
		'name' => "accesslevel[$metadata_name]",
		'value' => $access_id,
	];
}

if ($access == 'access') {
	echo elgg_view_field([
		'#type' => 'fieldset',
		'#class' => 'profile-manager-profile-fieldset',
		'fields' => [
			$metadata_field,
			$access_field,
		],
	]);
} else {
	echo elgg_view_field($metadata_field);
	echo elgg_view_field($access_field);
}
