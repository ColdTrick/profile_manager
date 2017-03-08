<?php

$entity = elgg_extract('entity', $vars);
$metadata_type = elgg_extract('metadata_type', $vars);
$field_type = elgg_extract('field_type', $vars);

if (!$metadata_type || !$field_type) {
	return;
}

$config = profile_manager_get_field_types();
$field_type_config = elgg_extract($field_type, $config);

if (empty($field_type_config['options']) || empty($field_type_config['metadata_types'])) {
	return;
}

$field_options = $field_type_config['options'];
$field_metadata_types = $field_type_config['metadata_types'];

$form = '';

if (in_array($metadata_type, ['dropdown', 'radio', 'multiselect'])) {
	echo elgg_view_field([
		'#type' => 'text',
		'#label' => elgg_echo('profile_manager:admin:metadata_options'),
		'name' => 'metadata_options',
		'value' => $entity ? $entity->metadata_options : '',
		'required' => true,
	]);
}

if (empty($field_metadata_types[$metadata_type])) {
	return;
}

foreach ($field_options as $option) {
	if (empty($field_metadata_types[$metadata_type]->options[$option])) {
		continue;
	}

	$form .= elgg_view_field([
		'#type' => 'checkbox',
		'label' => elgg_echo("profile_manager:admin:{$option}"),
		'#help' => elgg_echo("profile_manager:admin:{$option}:description"),
		'default' => 'no',
		'value' => 'yes',
		'name' => $option,
		'checked' => $entity->$option == 'yes',
	]);
}

$title = elgg_echo('profile_manager:admin:additional_options');
if ($field_type == 'profile') {
	$title .= elgg_view('output/pm_hint', [
		'id' => 'more_info_profile_field_additional',
		'text' => elgg_echo('profile_manager:tooltips:profile_field_additional'),
	]);
}

echo elgg_view_module('inline', $title, $form);
