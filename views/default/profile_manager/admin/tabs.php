<?php

$tabs = [];

$tabs[] = [
	'name' => 'profile_fields',
	'text' => elgg_echo('admin:appearance:profile_fields'),
	'href' => 'admin/appearance/profile_fields',
	'selected' => elgg_extract('profile_fields_selected', $vars, false),
	'priority' => 100,
];

if (elgg_is_active_plugin('groups')) {
	$tabs[] = [
		'name' => 'group_fields',
		'text' => elgg_echo('admin:appearance:group_fields'),
		'href' => 'admin/appearance/group_fields',
		'selected' => elgg_extract('group_fields_selected', $vars, false),
		'priority' => 200,
	];
}

$tabs[] = [
	'name' => 'settings',
	'text' => elgg_echo('settings'),
	'href' => 'admin/plugin_settings/profile_manager',
	'selected' => elgg_extract('settings_selected', $vars, false),
	'priority' => 800,
];

echo elgg_view_menu('filter:profile_manager:admin', [
	'items' => $tabs,
	'class' => 'elgg-tabs',
	'sort_by' => 'priority',
]);
