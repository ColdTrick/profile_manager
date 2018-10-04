<?php
/**
 * Show a single profile field for a user
 *
 * @uses $vars['entity']       the user
 * @uses $vars['field']        profile field
 * @uses $vars['is_attribute'] fetch data from atribute (default: false)
 * @uses $vars['microformats'] Mapping of fieldnames to microformats
 */

use ColdTrick\ProfileManager\CustomProfileField;

$field = elgg_extract('field', $vars);
$entity = elgg_extract('entity', $vars);
if (!$field instanceof CustomProfileField || !$entity instanceof ElggUser) {
	return;
}

$microformats = [
	'mobile' => 'tel p-tel',
	'phone' => 'tel p-tel',
	'website' => 'url u-url',
	'contactemail' => 'email u-email',
];
$microformats = array_merge($microformats, (array) elgg_extract('microformats', $vars, []));

$shortname = $field->metadata_name;
$valtype = $field->metadata_type;
if ((bool) elgg_extract('is_attribute', $vars, false)) {
	// system data is not annotations
	$value = $user->$shortname;
} else {
	$annotations = $entity->getAnnotations([
		'annotation_names' => "profile:{$shortname}",
		'limit' => false,
	]);
	$values = array_map(function (ElggAnnotation $a) {
		return $a->value;
	}, $annotations);

	if (!$values) {
		return;
	}
	// emulate metadata API
	$value = (count($values) === 1) ? $values[0] : $values;
}

if (elgg_is_empty($value)) {
	return;
}

// validate urls
if ($valtype == 'url' && !preg_match('~^https?\://~i', $value)) {
	$value = "http://$value";
}

// adjust output type
if ($field->output_as_tags == 'yes') {
	$valtype = 'tags';
	if (!is_array($value)) {
		$value = string_to_tag_array($value);
	}
}

$class = elgg_extract($shortname, $microformats, '');

echo elgg_view('object/elements/field', [
	'label' => $field->getDisplayName(),
	'value' => elgg_format_element('span', [
		'class' => $class,
	], elgg_view("output/{$valtype}", [
		'value' => $value,
	])),
	'name' => $shortname,
]);
