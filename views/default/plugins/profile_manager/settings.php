<?php

$plugin = elgg_extract('entity', $vars);

echo elgg_view('profile_manager/admin/tabs', ['settings_selected' => true]);

$registration_fields = [
	[
		'#type' => 'checkbox',
		'#label' => elgg_echo('profile_manager:settings:generate_username_from_email'),
		'name' => 'params[generate_username_from_email]',
		'checked' => $plugin->generate_username_from_email === 'yes',
		'switch' => true,
		'default' => 'no',
		'value' => 'yes',
	],
	[
		'#type' => 'checkbox',
		'#label' => elgg_echo('profile_manager:settings:show_account_hints'),
		'name' => 'params[show_account_hints]',
		'checked' => $plugin->show_account_hints === 'yes',
		'switch' => true,
		'default' => 'no',
		'value' => 'yes',
	],
	[
		'#type' => 'select',
		'#label' => elgg_echo('profile_manager:settings:profile_icon_on_register'),
		'name' => 'params[profile_icon_on_register]',
		'options_values' => [
			'no' => elgg_echo('option:no'),
			'yes' => elgg_echo('option:yes'),
			'optional' => elgg_echo('profile_manager:settings:profile_icon_on_register:option:optional'),
		],
		'value' => $plugin->profile_icon_on_register,
	],
	[
		'#type' => 'text',
		'#label' => elgg_echo('profile_manager:settings:registration:terms'),
		'name' => 'params[registration_terms]',
		'value' => $plugin->registration_terms,
	],
	[
		'#type' => 'longtext',
		'#label' => elgg_echo('profile_manager:settings:registration:free_text'),
		'name' => 'params[registration_free_text]',
		'value' => $plugin->registration_free_text,
	],
];

$profile_type_entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	'owner_guid' => elgg_get_site_entity()->guid,
	'limit' => false,
]);

if (!empty($profile_type_entities)) {
	$profile_types = [
		'' => elgg_echo('profile_manager:profile:edit:custom_profile_type:default'),
	];
	foreach ($profile_type_entities as $type) {
		$profile_types[$type->guid] = $type->getDisplayName();
	}

	$registration_fields[] = [
		'#type' => 'select',
		'#label' => elgg_echo('profile_manager:settings:default_profile_type'),
		'name' => 'params[default_profile_type]',
		'options_values' => $profile_types,
		'value' => $plugin->default_profile_type,
	];
	
	$registration_fields[] = [
		'#type' => 'checkbox',
		'#label' => elgg_echo('profile_manager:settings:hide_profile_type_default'),
		'name' => 'params[hide_profile_type_default]',
		'checked' => $plugin->hide_profile_type_default === 'yes',
		'switch' => true,
		'default' => 'no',
		'value' => 'yes',
	];
}

echo elgg_view_module('info', elgg_echo('profile_manager:settings:registration'), elgg_view('input/fieldset', [
	'fields' => $registration_fields,
]));

echo elgg_view_module('info', elgg_echo('profile_manager:settings:edit_profile'), elgg_view('input/fieldset', [
	'fields' => [
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('profile_manager:settings:simple_access_control'),
			'name' => 'params[simple_access_control]',
			'checked' => $plugin->simple_access_control === 'yes',
			'switch' => true,
			'default' => 'no',
			'value' => 'yes',
		],
		[
			'#type' => 'select',
			'#label' => elgg_echo('profile_manager:settings:edit_profile_mode'),
			'name' => 'params[edit_profile_mode]',
			'options_values' => [
				'list' => elgg_echo('profile_manager:settings:edit_profile_mode:list'),
				'tabbed' => elgg_echo('profile_manager:settings:edit_profile_mode:tabbed'),
			],
			'value' => $plugin->edit_profile_mode,
		],
		[
			'#type' => 'select',
			'#label' => elgg_echo('profile_manager:settings:profile_type_selection'),
			'name' => 'params[profile_type_selection]',
			'options_values' => [
				'user' => elgg_echo('profile_manager:settings:profile_type_selection:option:user'),
				'admin' => elgg_echo('profile_manager:settings:profile_type_selection:option:admin'),
			],
			'value' => $plugin->profile_type_selection,
		],
	],
]));

echo elgg_view_module('info', elgg_echo('profile_manager:settings:view_profile'), elgg_view('input/fieldset', [
	'fields' => [
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('profile_manager:settings:show_profile_type_on_profile'),
			'name' => 'params[show_profile_type_on_profile]',
			'checked' => $plugin->show_profile_type_on_profile === 'yes',
			'switch' => true,
			'default' => 'no',
			'value' => 'yes',
		],
		[
			'#type' => 'select',
			'#label' => elgg_echo('profile_manager:settings:display_categories'),
			'name' => 'params[display_categories]',
			'options_values' => [
				'plain' => elgg_echo('profile_manager:settings:display_categories:option:plain'),
				'tabs' => elgg_echo('profile_manager:settings:display_categories:option:tabs'),
			],
			'value' => $plugin->display_categories,
		],
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('profile_manager:settings:display_system_category'),
			'name' => 'params[display_system_category]',
			'checked' => $plugin->display_system_category === 'yes',
			'switch' => true,
			'default' => 'no',
			'value' => 'yes',
		],
	],
]));

echo elgg_view_module('info', elgg_echo('other'), elgg_view('input/fieldset', [
	'fields' => [
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('profile_manager:settings:enable_profile_completeness_widget'),
			'name' => 'params[enable_profile_completeness_widget]',
			'checked' => $plugin->enable_profile_completeness_widget === 'yes',
			'switch' => true,
			'default' => 'no',
			'value' => 'yes',
		],
		[
			'#type' => 'number',
			'#label' => elgg_echo('profile_manager:settings:profile_completeness:avatar'),
			'#help' => elgg_echo('profile_manager:settings:profile_completeness:avatar:help'),
			'name' => 'params[profile_completeness_avatar]',
			'value' => $plugin->profile_completeness_avatar,
			'min' => 0,
			'max' => 100,
		],
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('profile_manager:settings:enable_site_join_river_event'),
			'name' => 'params[enable_site_join_river_event]',
			'checked' => $plugin->enable_site_join_river_event === 'yes',
			'switch' => true,
			'default' => 'no',
			'value' => 'yes',
		],
	],
]));
