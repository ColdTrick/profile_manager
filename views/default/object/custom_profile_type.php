<?php
/**
* Object view of a custom profile type
*/

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ColdTrick\ProfileManager\CustomProfileType) {
	return;
}

// get title
$content = $entity->getDisplayName();

// edit link
$content .= elgg_view('output/url', [
	'href' => elgg_http_add_url_query_elements('ajax/view/forms/profile_manager/type', [
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
	'class' => 'custom_profile_type',
	'id' => 'custom_profile_type_' . $entity->guid
], $content);
