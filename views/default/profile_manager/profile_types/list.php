<?php
/**
* Profile Manager
*
* Profile Types list view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$list = elgg_list_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
	'pagination' => false,
	'full_view' => false,
	'no_results' => elgg_echo('profile_manager:profile_types:list:no_types'),
]);

$menu = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'icon' => 'plus',
	'href' => 'ajax/view/forms/profile_manager/type',
	'class' => 'elgg-lightbox',
]);

$title = elgg_echo('profile_manager:profile_types:list:title');
$title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_type_list',
	'text' => elgg_echo('profile_manager:tooltips:profile_type_list'),
]);
		
$list = elgg_format_element('div', ['id' => 'custom_fields_profile_types_list_custom'], $list);

echo elgg_view_module('info', $title, $list, ['menu' => $menu]);
