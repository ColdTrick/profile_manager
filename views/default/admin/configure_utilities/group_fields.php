<?php
/**
 * Profile Manager
 *
 * Group Profile Fields Config page
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

elgg_import_esm('profile_manager/admin');

echo elgg_view('profile_manager/admin/tabs', ['group_fields_selected' => true]);
echo elgg_view('profile_manager/group_fields/list');

// actions
$title = elgg_echo('profile_manager:actions:title');
$title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_actions',
	'text' => elgg_echo('profile_manager:tooltips:actions'),
]);

echo elgg_view_module('info', $title, elgg_view_menu('profile_fields', [
	'type' => 'group',
	'fieldtype' => \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE,
	'class' => 'elgg-menu-hz',
]));
