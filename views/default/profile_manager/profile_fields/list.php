<?php
/**
 * Profile Manager
 *
 * Profile Fields list view
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

$list = elgg_list_entities([
	'type' => 'object',
	'subtype' => \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE,
	'limit' => false,
	'sort_by' => [
		'property' => 'order',
		'direction' => 'asc',
		'signed' => true,
	],
	'owner_guid' => elgg_get_site_entity()->guid,
	'pagination' => false,
	'full_view' => false,
	'no_results' => elgg_echo('profile_manager:profile_fields:no_fields'),
]);

$menu = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'icon' => 'plus',
	'href' => 'ajax/view/forms/profile_manager/profile_field',
	'class' => 'elgg-lightbox',
]);
		
$list = elgg_format_element('div', ['id' => 'custom_fields_ordering'], $list);

echo elgg_view_module('info', elgg_echo('profile_manager:profile_fields:list:title'), $list, ['menu' => $menu]);
