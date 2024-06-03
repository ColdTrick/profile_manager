<?php
/**
 * Show a single profile field for a user
 *
 * @uses $vars['entity']       the user
 * @uses $vars['field']        profile field
 * @uses $vars['microformats'] Mapping of fieldnames to microformats
 */

use ColdTrick\ProfileManager\CustomProfileField;

$field = elgg_extract('field', $vars);
$entity = elgg_extract('entity', $vars);
if (!$field instanceof CustomProfileField || !$entity instanceof \ElggUser) {
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

$value = $entity->getProfileData($shortname);
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
		$value = elgg_string_to_array((string) $value);
	}
}

echo elgg_view('object/elements/field', [
	'label' => $field->getDisplayName(),
	'value' => elgg_format_element('span', [
		'class' => elgg_extract($shortname, $microformats),
	], elgg_view("output/{$valtype}", [
		'value' => $value,
	])),
	'name' => $shortname,
]);
