<?php
/**
 * Group profile fields
 */

$group = elgg_extract('entity', $vars);
if (!$group instanceof ElggGroup) {
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
	
	$key = $field->metadata_name;
	
	// do not show the name
	if ($key == 'name') {
		continue;
	}

	$value = $group->$key;
	if (elgg_is_empty($value)) {
		continue;
	}
	
	$valtype = $field->metadata_type;
	if ($field->output_as_tags == 'yes') {
		$valtype = 'tags';
		$value = string_to_tag_array($value);
	}
	
	$options = ['value' => $value];
	if ($valtype == 'tags') {
		$options['tag_names'] = $key;
	}

	$field_title = $field->getDisplayName();
	$field_value = elgg_view("output/$valtype", $options);
	$field_value = elgg_format_element('span', [], $field_value);

	$output .= elgg_view('object/elements/field', [
		'label' => $field_title,
		'value' => $field_value,
		'class' => 'group-profile-field',
		'name' => $key,
	]);
}

if ($output) {
	echo elgg_format_element('div', [
		'class' => 'elgg-profile-fields',
	], $output);
}
