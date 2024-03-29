<?php
/**
 * Extra fields for admin user add form
 */

use ColdTrick\ProfileManager\CustomProfileType;

// get profile types
$types = elgg_get_entities([
	'type' => 'object',
	'subtype' => CustomProfileType::SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
]);

$categorized_fields = profile_manager_get_categorized_fields(null, true);
$cats = elgg_extract('categories', $categorized_fields);
$fields = elgg_extract('fields', $categorized_fields);

if (empty($types) && empty($fields)) {
	return;
}

echo elgg_view('output/url', [
	'href' => '#extra_metadata',
	'class' => 'elgg-toggle',
	'text' => elgg_echo('profile_manager:admin:adduser:extra_metadata'),
]);

$result = '';
if (!empty($types)) {
	$options = [
		'' => elgg_echo('profile_manager:profile:edit:custom_profile_type:default'),
	];
	
	foreach ($types as $type) {
		$options[$type->guid] = $type->getDisplayName();
	}
	
	$result .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('profile_manager:profile:edit:custom_profile_type:label'),
		'name' => 'custom_profile_fields[custom_profile_type]',
		'options_values' => $options,
	]);
}

if (!empty($cats)) {
	foreach ($cats as $cat_guid => $cat) {
		// display each field for currect category
		foreach ($fields[$cat_guid] as $field) {
			$result .= elgg_view_field([
				'#type' => $field->metadata_type,
				'#label' => $field->getDisplayName(),
				'name' => "custom_profile_fields[{$field->metadata_name}]",
				'options' => $field->getOptions(true),
			]);
		}
	}
}

echo elgg_format_element('div', [
	'id' => 'extra_metadata',
	'class' => 'hidden',
], $result);
