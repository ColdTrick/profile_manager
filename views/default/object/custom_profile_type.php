<?php
/**
 * Object view of a custom profile type
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ColdTrick\ProfileManager\CustomProfileType) {
	return;
}

$content = $entity->getDisplayName();

$content .= elgg_view('output/url', [
	'href' => elgg_http_add_url_query_elements('ajax/form/profile_manager/profile_types/add', [
		'guid' => $entity->guid,
	]),
	'class' => ['elgg-lightbox', 'mlm'],
	'title' => elgg_echo('edit'),
	'text' => false,
	'icon' => 'settings-alt',
]);

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
	'class' => 'custom_profile_type',
	'id' => 'custom_profile_type_' . $entity->guid,
], $content);
