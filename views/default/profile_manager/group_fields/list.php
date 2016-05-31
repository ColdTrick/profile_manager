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

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$list = elgg_list_entities_from_metadata([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
	'limit' => false,
	'order_by_metadata' => [['name' => 'order', 'direction' => 'asc', 'as' => 'integer']],
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'pagination' => false,
	'full_view' => false,
	'no_results' => elgg_echo('profile_manager:profile_fields:no_fields'),
]);

$header = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => 'ajax/view/forms/profile_manager/group_field',
	'class' => 'elgg-button elgg-button-action man pvn float-alt elgg-lightbox',
]);
$header .= elgg_format_element('h3', [], elgg_echo('profile_manager:group_fields:list:title'));
		
$list = elgg_format_element('div', ['id' => 'custom_fields_ordering'], $list);

echo elgg_view_module('inline', '', $list, ['header' => $header]);