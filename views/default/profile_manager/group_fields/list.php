<?php
/**
 * Group Fields list view
 */

$list = elgg_list_entities([
	'type' => 'object',
	'subtype' => \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE,
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
	'href' => 'ajax/form/profile_manager/fields/group',
	'class' => 'elgg-lightbox',
]);
		
$list = elgg_format_element('div', ['id' => 'custom_fields_ordering'], $list);

echo elgg_view_module('info', elgg_echo('profile_manager:group_fields:list:title'), $list, ['menu' => $menu]);
