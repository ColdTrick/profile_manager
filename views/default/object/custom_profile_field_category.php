<?php
/**
* Profile Manager
*
* Object view of a custom profile field category
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$entity = elgg_extract('entity', $vars);

$content = elgg_view_icon('drag-arrow');

// filter link
$content .= elgg_view('output/url', [
	'href' => '#',
	'text' => $entity->getTitle(),
	'class' => 'category-filter',
	'data-guid' => $entity->guid,
]);

// edit link
$content .= elgg_view('output/url', [
	'href' => 'ajax/view/forms/profile_manager/category?guid=' . $entity->guid,
	'class' => 'elgg-lightbox',
	'title' => elgg_echo('edit'),
	'text' => elgg_view_icon('settings-alt'),
]);

// delete link
$content .= elgg_view('output/url', [
	'href' => 'action/profile_manager/categories/delete?guid=' . $entity->guid,
	'title' => elgg_echo('delete'),
	'text' => elgg_view_icon('delete'),
	'confirm' => elgg_echo('profile_manager:categories:delete:confirm'),
]);

echo elgg_format_element('div', [
	'class' => 'custom_fields_category',
	'id' => 'custom_profile_field_category_' . $entity->guid
], $content);