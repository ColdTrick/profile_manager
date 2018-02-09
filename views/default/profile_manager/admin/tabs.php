<?php

$tabs = [[
	'text' => elgg_echo('admin:configure_utilities:profile_fields'),
	'href' => 'admin/configure_utilities/profile_fields',
	'selected' => elgg_extract('profile_fields_selected', $vars, false),
]];

if (elgg_is_active_plugin('groups')) {
	$tabs[] = [
		'text' => elgg_echo('admin:configure_utilities:group_fields'),
		'href' => 'admin/configure_utilities/group_fields',
		'selected' => elgg_extract('group_fields_selected', $vars, false),
	];
}
		
$tabs[] = [
	'text' => elgg_echo('settings'),
	'href' => 'admin/plugin_settings/profile_manager',
	'selected' => elgg_extract('settings_selected', $vars, false),
];

echo elgg_view('navigation/tabs', ['tabs' => $tabs]);
