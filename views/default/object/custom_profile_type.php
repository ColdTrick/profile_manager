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
	'href' => 'ajax/view/forms/profile_manager/type?guid=' .  $entity->guid,
	'class' => 'elgg-lightbox',
	'title' => elgg_echo('edit'),
	'text' => elgg_view_icon('settings-alt'),
]);

// delete link
$content .= elgg_view('output/url', [
	'href' => 'action/profile_manager/profile_types/delete?guid=' . $entity->guid,
	'title' => elgg_echo('delete'),
	'text' => elgg_view_icon('delete'),
	'confirm' => true,
]);

echo elgg_format_element('div', [
	'class' => 'custom_profile_type',
	'id' => 'custom_profile_type_' . $entity->guid
], $content);
