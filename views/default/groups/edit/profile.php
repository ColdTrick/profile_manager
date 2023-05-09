<?php
/**
 * Profile Manager
 *
 * Overrules group edit form to support options (radio, dropdown, multiselect)
 */

$group = elgg_extract('entity', $vars);

$group_profile_fields = (array) elgg_extract('fields', profile_manager_get_categorized_group_fields($group));

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('groups:name'),
	'required' => true,
	'name' => 'name',
	'value' => elgg_extract('name', $vars),
]);

// show the configured group profile fields
foreach ($group_profile_fields as $field) {
	$shortname = $field->metadata_name;
	
	$options = [
		'#type' => $field->metadata_type,
		'#help' => $field->getHint(),
		'name' => $shortname,
		'value' => elgg_extract($shortname, $vars),
		'options' => $field->getOptions(),
		'placeholder' => $field->getPlaceholder(),
	];
	
	if ($field->metadata_type !== 'hidden') {
		$options['#label'] = $field->getDisplayName();
	}
	
	echo elgg_view_field($options);
}
