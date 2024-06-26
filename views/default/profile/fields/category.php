<?php
/**
 * Show a profile category for an user
 *
 * @uses $vars['category']      the current category
 * @uses $vars['category_guid'] the category guid (can't use $vars['category']->guid because of magic
 * @uses $vars['entity']        the user
 * @uses $vars['fields']        the profile fields for the user
 * @uses $vars['microformats']  Mapping of fieldnames to microformats
 */

$entity = elgg_extract('entity', $vars);
$fields = elgg_extract('fields', $vars);
if (!$entity instanceof ElggUser || empty($fields) || !is_array($fields)) {
	return;
}

$category_guid = (int) elgg_extract('category_guid', $vars);
$output = '';

foreach ($fields as $field) {
	if (!$field->showOnProfile()) {
		continue;
	}
	
	$output .= elgg_view('profile/fields/field', [
		'entity' => $entity,
		'field' => $field,
		'microformats' => elgg_extract('microformats', $vars, []),
	]);
}

if (empty($output)) {
	return;
}

echo elgg_format_element('div', ['class' => 'elgg-profile-fields'], $output);
