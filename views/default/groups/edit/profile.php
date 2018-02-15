<?php
/**
* Profile Manager
*
* Overrules group edit form to support options (radio, dropdown, multiselect)
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$group = elgg_extract('entity', $vars);
	
echo '<div>';
echo elgg_format_element('label', [], elgg_echo('groups:icon')) . '<br />';
echo elgg_view('input/file', ['name' => 'icon']);
echo '</div>';

echo '<div>';
echo elgg_format_element('label', [], elgg_echo('groups:name')) . '<br />';

echo elgg_view('input/text', [
	'name' => 'name',
	'value' => elgg_extract('name', $vars),
]);

echo '</div>';

// retrieve group fields
$group_fields = profile_manager_get_categorized_group_fields();
$group_fields = elgg_extract('fields', $group_fields);
if (empty($group_fields)) {
	return;
}

foreach ($group_fields as $field) {
	$metadata_name = $field->metadata_name;
	
	// get options
	$options = $field->getOptions();
	$placeholder = $field->getPlaceholder();
	
	// get type of field
	$valtype = $field->metadata_type;
	
	// get value
	$value = elgg_extract($metadata_name, $vars);
	
	echo '<div>';
	echo elgg_format_element('label', [], $field->getDisplayName());
	
	$hint = $field->getHint();
	if ($hint) {
		echo elgg_view('output/pm_hint', [
			'id' => "more_info_{$metadata_name}",
			'text' => $hint,
		]);
	}
	
	if ($valtype !== 'longtext') {
		echo '<br />';
	}
	
	$field_output_options = [
		'name' => $metadata_name,
		'value' => $value,
	];

	if ($options) {
		$field_output_options['options'] = $options;
	}

	if ($placeholder) {
		$field_output_options['placeholder'] = $placeholder;
	}

	if ($metadata_name == 'description') {
		echo elgg_view("input/{$valtype}", $field_output_options);
	} else {
		if ($valtype == 'dropdown') {
			// add div around dropdown to let it act as a block level element
			echo '<div>';
		}
		
		echo elgg_view("input/{$valtype}", $field_output_options);
		
		if ($valtype == 'dropdown') {
			echo '</div>';
		}
	}
	
	echo '</div>';
}
