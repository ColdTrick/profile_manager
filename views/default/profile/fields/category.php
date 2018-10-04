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

foreach ($fields as $field) {
	if (!$field->showOnProfile()) {
		continue;
	}
	
	echo elgg_view('profile/fields/field', [
		'entity' => $entity,
		'field' => $field,
		'is_attribute' => $category_guid === -1,
		'microformats' => elgg_extract('microformats', $vars, []),
	]);
}
