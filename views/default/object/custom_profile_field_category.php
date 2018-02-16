<?php
/**
* Object view of a custom profile field category
*/

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
	return;
}

$content = elgg_view_icon('drag-arrow', ['class' => 'mrs']);

// filter link
$content .= elgg_view('output/url', [
	'href' => false,
	'text' => $entity->getDisplayName(),
	'class' => 'category-filter',
	'data-guid' => $entity->guid,
]);

// edit link
$content .= elgg_view('output/url', [
	'href' => elgg_http_add_url_query_elements('ajax/view/forms/profile_manager/category', [
		'guid' => $entity->guid,
	]),
	'class' => ['elgg-lightbox', 'mls'],
	'title' => elgg_echo('edit'),
	'text' => false,
	'icon' => 'settings-alt',
]);

// delete link
$content .= elgg_view('output/url', [
	'href' => elgg_generate_action_url('entity/delete', [
		'guid' => $entity->guid,
	]),
	'title' => elgg_echo('delete'),
	'text' => false,
	'class' => ['mls'],
	'icon' => 'delete-alt',
	'confirm' => true,
]);

echo elgg_format_element('div', [
	'class' => 'custom_fields_category',
	'id' => 'custom_profile_field_category_' . $entity->guid
], $content);
