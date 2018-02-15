<?php
/**
* Toggle metadata view
*/

$entity = elgg_extract('entity', $vars);
$metadata_name = elgg_extract('metadata_name', $vars);

$metadata_type = $entity->metadata_type;

$types = [];
$type_options = [];

if ($entity->getSubType() == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) {
	$types = profile_manager_get_custom_field_types('custom_profile_field_types');
} elseif ($entity->getSubType() == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE) {
	$types = profile_manager_get_custom_field_types('custom_group_field_types');
}
	
if (!empty($metadata_type) && !empty($types) && array_key_exists($metadata_type, $types)) {
	$type_options = $types[$metadata_type]->options;
}

$options = [
	'title' => elgg_echo('profile_manager:admin:option_unavailable'),
	'class' => ['field_config_metadata_option'],
];

$icon_name = 'circle-o';

// if no option is available in the register, this metadata field can't be toggled
if (!empty($type_options) && array_key_exists($metadata_name, $type_options) && $type_options[$metadata_name]) {
	if ($entity->$metadata_name !== "yes") {
		$options['class'][] = 'field_config_metadata_option_disabled';
	} else {
		$options['class'][] = 'field_config_metadata_option_enabled';
	}
	$options['title'] = elgg_echo("profile_manager:admin:{$metadata_name}");
	$options['data-guid'] = $entity->guid;
	$options['data-field'] = $metadata_name;
	
	$icon_name = 'circle';
}

echo elgg_view_icon($icon_name, $options);
