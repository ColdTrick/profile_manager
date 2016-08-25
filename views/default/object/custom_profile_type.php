<?php
/**
* Profile Manager
*
* Object view of a custom profile field type
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$entity = $vars['entity'];

// get title
$content = $entity->getTitle();

// edit link
$content .= elgg_view('output/url', [
	'href' => 'ajax/view/forms/profile_manager/type?guid=' .  $entity->guid,
	'class' => 'elgg-lightbox',
	'title' => elgg_echo('edit'),
	'text' => elgg_view_icon('settings-alt'),
	'data-colorbox-opts' => json_encode([
		'trapFocus' => false,
	]),
]);

// delete link
$content .= elgg_view('output/url', [
	'href' => 'action/profile_manager/profile_types/delete?guid=' . $entity->guid,
	'title' => elgg_echo('delete'),
	'text' => elgg_view_icon('delete'),
	'confirm' => elgg_echo('profile_manager:profile_types:delete:confirm'),
]);

echo elgg_format_element('div', [
	'class' => 'custom_profile_type',
	'id' => 'custom_profile_type_' . $entity->guid
], $content);