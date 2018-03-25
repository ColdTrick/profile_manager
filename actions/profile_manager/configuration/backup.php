<?php
/**
* Backup of profile fields config
*/

elgg_set_http_header('Content-Type: application/json');
elgg_set_http_header('Content-Disposition: attachment; filename="custom_profile_fields.backup.json"');

$fieldtype = get_input('fieldtype' , CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE);

$entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => $fieldtype,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
]);

$info = [];

$fields = [];
foreach ($entities as $entity) {
	$fields[] = [
		'metadata_name' => $entity->metadata_name,
		'metadata_label' => $entity->metadata_label,
		'metadata_input_label' => $entity->metadata_input_label,
		'metadata_hint' => $entity->metadata_hint,
		'metadata_type' => $entity->metadata_type,
		'metadata_options' => $entity->metadata_options,
		'metadata_placeholder' => $entity->metadata_placeholder,
		'show_on_register' => $entity->show_on_register,
		'mandatory' => $entity->mandatory,
		'user_editable' => $entity->user_editable,
		'output_as_tags' => $entity->output_as_tags,
		'admin_only' => $entity->admin_only,
		'blank_available' => $entity->blank_available,
		'order' => $entity->order,
		'count_for_completeness' => $entity->count_for_completeness,
	];
}

echo json_encode(
	[
		'info' => [
			'fieldtype' => $fieldtype,
			'md5' => md5(print_r($fields, true)),
		],
		'fields' => $fields,
	],
	JSON_PRETTY_PRINT
);

exit();
