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

$categories = elgg_list_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
	'limit' => false,
	'pagination' => false,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'order_by_metadata' => ['name' => 'order', 'as' => 'integer'],
]);

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

$menu = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'icon' => 'plus',
	'href' => 'ajax/view/forms/profile_manager/category',
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
]);

$title = elgg_echo('profile_manager:categories:list:title');
$title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_category_list',
	'text' => elgg_echo('profile_manager:tooltips:category_list'),
]);

echo elgg_view_module('info', $title, $body, ['menu' => $menu]);
