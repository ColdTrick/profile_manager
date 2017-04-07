<?php

$field = elgg_extract('field', $vars);
$entity = elgg_extract('entity', $vars);

$metadata_name = $field->metadata_name;

$value = $entity->$metadata_name;

if ($field->output_as_tags == 'yes') {
	$output_type = 'tags';
	if (!is_array($value)) {
		$value = string_to_tag_array($value);
	}
} else {
	$output_type = $field->metadata_type;
}

if ($field->metadata_type == 'url') {
	$target = '_blank';
	// validate urls
	if (!preg_match('~^https?\://~i', $value)) {
		$value = "http://$value";
	}
} else {
	$target = null;
}

$label = elgg_format_element('b', [
	'class' => 'profile-manager-field-label',
], $field->getTitle());

$output = elgg_view("output/$output_type", [
	'value' => $value,
	'target' => $target,
	'entity' => $entity,
	'field' => $field,
]);

if (!$output) {
	return;
}

echo elgg_format_element('div', [
	'class' => elgg_extract_class($vars, 'profile-manager-field-output'),
], "$label:&nbsp;$output");
