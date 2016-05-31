<?php
/**
* Profile Manager
*
* Category list view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$options = [
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
	'limit' => false,
	'pagination' => false,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'order_by_metadata' => ['name' => 'order', 'as' => 'integer'],
];

$categories = elgg_list_entities_from_metadata($options);

$list = $categories ?: elgg_echo('profile_manager:categories:list:no_categories');

$all_link = elgg_view('output/url', [
	'href' => '#',
	'text' => elgg_echo('all'),
	'class' => 'category-filter',
]);
$all = elgg_format_element('div', ['id' => 'custom_profile_field_category_all', 'class' => 'custom_fields_category'], $all_link);

$default_link = elgg_view('output/url', [
	'href' => '#',
	'text' => elgg_echo('profile_manager:categories:list:default'),
	'class' => 'category-filter',
	'data-guid' => 0,
]);
$default = elgg_format_element('div', ['id' => 'custom_profile_field_category_0', 'class' => 'custom_fields_category'], $default_link);

$body = elgg_format_element('div', ['id' => 'custom_fields_category_list_custom'], $all . $default . $list);

$head = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => 'ajax/view/forms/profile_manager/category',
	'class' => 'elgg-button elgg-button-action man pvn float-alt elgg-lightbox',
]);

$title = elgg_echo('profile_manager:categories:list:title');
$title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_category_list',
	'text' => elgg_echo('profile_manager:tooltips:category_list'),
]);

$head .= elgg_format_element('h3', [], $title);

echo elgg_view_module('inline', '', $body, ['header' => $head]);
