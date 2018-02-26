<?php

/*
 * Shows a selection dropdown for the profile types on the registration form
 */

$value = elgg_extract('value', $vars);

$types = elgg_get_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
]);

if (empty($types)) {
	return;
}

elgg_require_js('profile_manager/profile_type');

$types_options_values = [];
if (elgg_get_plugin_setting('hide_profile_type_default', 'profile_manager') !== 'yes') {
	$types_options_values[''] = elgg_echo('profile_manager:profile:edit:custom_profile_type:default');
}

// Generate type descriptions for all profile types
$types_description = '';
foreach ($types as $type) {
	$types_options_values[$type->guid] = $type->getDisplayName();
		
	// preparing descriptions of profile types
	$description = $type->getDescription();
		
	if (!empty($description)) {
		$description_class = ['custom_profile_type_description', 'mbl'];
		if ($value !== $type->guid) {
			$description_class[] = 'hidden';
		}
		$types_description .= elgg_format_element('div', ['id' => "custom_profile_type_description_{$type->guid}", 'class' => $description_class], $description);
	}
}

$dropdown = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:profile:edit:custom_profile_type:label'),
	'name' => 'custom_profile_fields_custom_profile_type',
	'id' => 'custom_profile_type',
	'options_values' => $types_options_values,
	'value' => $value,
]);

echo elgg_format_element('div', [], $dropdown . $types_description);
