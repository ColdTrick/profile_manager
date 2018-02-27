<?php
/**
* Profile Manager
*
* Group Fields list view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$list = elgg_list_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
	'limit' => false,
	'order_by_metadata' => [
		'name' => 'order',
		'direction' => 'asc',
		'as' => 'integer',
	],
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'pagination' => false,
	'full_view' => false,
	'no_results' => elgg_echo('profile_manager:profile_fields:no_fields'),
]);

$menu = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'icon' => 'plus',
	'href' => 'ajax/view/forms/profile_manager/group_field',
	'class' => 'elgg-lightbox',
]);
		
$list = elgg_format_element('div', ['id' => 'custom_fields_ordering'], $list);

echo elgg_view_module('info', elgg_echo('profile_manager:group_fields:list:title'), $list, ['menu' => $menu]);
