<?php

/**
 * Profile Manager
 *
 * Profile Field add form
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

$entity = elgg_extract('entity', $vars);
$field_type = elgg_extract('field_type', $vars);
if (!$field_type && $entity) {
	$config = profile_manager_get_field_types();
	foreach ($config as $config_type => $opts) {
		if ($opts['subtype'] == $entity->getSubtype()) {
			$field_type = $config_type;
			break;
		}
	}
}

if (!$field_type) {
	return;
}

echo elgg_view_field([
	'#type' => 'profile_manager/metadata_type',
	'#label' => elgg_echo('profile_manager:admin:field_type'),
	'name' => 'metadata_type',
	'value' => $entity ? $entity->metadata_type : '',
	'entity' => $entity,
	'required' => true,
	'field_type' => $field_type,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_name'),
	'name' => 'metadata_name',
	'value' => $entity ? $entity->metadata_name : '',
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_label'),
	'name' => 'metadata_label',
	'value' => $entity ? $entity->metadata_label : '',
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_input_label'),
	'#help' => elgg_echo('profile_manager:admin:metadata_input_label:help'),
	'name' => 'metadata_input_label',
	'value' => $entity ? $entity->metadata_input_label : '',
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_hint'),
	'name' => 'metadata_hint',
	'value' => $entity ? $entity->metadata_hint : '',
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_placeholder'),
	'name' => 'metadata_placeholder',
	'value' => $entity ? $entity->metadata_placeholder : '',
]);

$options = elgg_view('forms/profile_manager/field_options', [
	'entity' => $entity,
	'metadata_type' => $entity ? $entity->metadata_type : '',
	'field_type' => $field_type,
		]);

echo elgg_format_element('div', [
	'class' => 'profile-manager-field-options',
		], $options);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'field_type',
	'value' => $field_type,
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity ? $entity->guid : '',
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
		]);

elgg_set_form_footer($footer);

