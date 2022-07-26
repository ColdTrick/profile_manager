<?php
/**
 * Group profile fields
 */

$group = elgg_extract('entity', $vars);
if (!$group instanceof \ElggGroup) {
	return;
}

$profile_fields = elgg_extract('fields', profile_manager_get_categorized_group_fields($group));
if (empty($profile_fields) || !is_array($profile_fields)) {
	return;
}

$output = '';
foreach ($profile_fields as $field) {
	
	if (!$field->showOnProfile()) {
		continue;
	}
	
	$field_name = $field->metadata_name;
	
	// do not show the name
	if ($field_name == 'name') {
		continue;
	}

	$value = $group->$field_name;
	if (elgg_is_empty($value)) {
		continue;
	}
	
	$field_type = $field->metadata_type;
	if ($field->output_as_tags == 'yes') {
		$field_type = 'tags';
		$value = is_string($value) ? elgg_string_to_array($value) : $value;
	}
	
	$options = ['value' => $value];
	if ($field_type == 'tags') {
		$options['tag_names'] = $field_name;
	}

	$field_title = $field->getDisplayName();
	$field_value = elgg_view("output/{$field_type}", $options);
	$field_value = elgg_format_element('span', [], $field_value);

	$output .= elgg_view('object/elements/field', [
		'label' => $field_title,
		'value' => $field_value,
		'class' => 'group-profile-field',
		'name' => $field_name,
	]);
}

if (empty($output)) {
	return;
}

echo elgg_format_element('div', ['class' => 'elgg-profile-fields'], $output);