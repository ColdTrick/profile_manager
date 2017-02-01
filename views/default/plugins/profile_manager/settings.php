<?php
/**
* Profile Manager
*
* Admin settings
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$plugin = elgg_extract('entity', $vars);

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no')
];

$noyes_options = array_reverse($yesno_options);

$profile_icon_options = $noyes_options;
$profile_icon_options['optional'] = elgg_echo('profile_manager:settings:profile_icon_on_register:option:optional');

$extra_fields_options = [
	'extend' => elgg_echo('profile_manager:settings:registration:extra_fields:extend'),
	'beside' => elgg_echo('profile_manager:settings:registration:extra_fields:beside'),
];

$enable_username_change_options = [
	'no' => elgg_echo('option:no'),
	'admin' => elgg_echo('profile_manager:settings:enable_username_change:option:admin'),
	'yes' => elgg_echo('option:yes'),
];

$profile_types = [];

$profile_type_entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
	'limit' => false,
]);

if (!empty($profile_type_entities)) {
	$profile_types[''] = elgg_echo('profile_manager:profile:edit:custom_profile_type:default');
	foreach ($profile_type_entities as $type) {
		$profile_types[$type->guid] = $type->getTitle();
	}
}

echo elgg_view('profile_manager/admin/tabs', ['settings_selected' => true]);

$group_limit_options = [
	'' => elgg_echo('profile_manager:settings:group:limit:unlimited'),
	0 => elgg_echo('never'),
	1 => 1,
	2 => 2,
	3 => 3,
	4 => 4,
	5 => 5,
	6 => 6,
	7 => 7,
	8 => 8,
	9 => 9,
	10 => 10,
];

$registration_settings = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:generate_username_from_email'),
	'name' => 'params[generate_username_from_email]',
	'options_values' => $noyes_options,
	'value' => $plugin->generate_username_from_email,
]);

$registration_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:profile_icon_on_register'),
	'name' => 'params[profile_icon_on_register]',
	'options_values' => $profile_icon_options,
	'value' => $plugin->profile_icon_on_register,
]);

$registration_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:show_account_hints'),
	'name' => 'params[show_account_hints]',
	'options_values' => $noyes_options,
	'value' => $plugin->show_account_hints,
]);

$registration_settings .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:settings:registration:terms'),
	'name' => 'params[registration_terms]',
	'value' => $plugin->registration_terms,
]);

$registration_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:registration:extra_fields'),
	'name' => 'params[registration_extra_fields]',
	'options_values' => $extra_fields_options,
	'value' => $plugin->registration_extra_fields,
]);

if (!empty($profile_types)) {

	$registration_settings .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('profile_manager:settings:default_profile_type'),
		'name' => 'params[default_profile_type]',
		'options_values' => $profile_types,
		'value' => $plugin->default_profile_type,
	]);
	
	$registration_settings .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('profile_manager:settings:hide_profile_type_default'),
		'name' => 'params[hide_profile_type_default]',
		'options_values' => $noyes_options,
		'value' => $plugin->hide_profile_type_default,
	]);
}

$registration_settings .= elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('profile_manager:settings:registration:free_text'),
	'name' => 'params[registration_free_text]',
	'value' => $plugin->registration_free_text,
]);

echo elgg_view_module('inline', elgg_echo('profile_manager:settings:registration'), $registration_settings);


$edit_profile = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:simple_access_control'),
	'name' => 'params[simple_access_control]',
	'options_values' => $noyes_options,
	'value' => $plugin->simple_access_control,
]);

$edit_profile .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:edit_profile_mode'),
	'name' => 'params[edit_profile_mode]',
	'options_values' => [
		'list' => elgg_echo('profile_manager:settings:edit_profile_mode:list'),
		'tabbed' => elgg_echo('profile_manager:settings:edit_profile_mode:tabbed'),
	],
	'value' => $plugin->edit_profile_mode,
]);

$edit_profile .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:profile_type_selection'),
	'name' => 'params[profile_type_selection]',
	'options_values' => [
		'user' => elgg_echo('profile_manager:settings:profile_type_selection:option:user'),
		'admin' => elgg_echo('profile_manager:settings:profile_type_selection:option:admin'),
	],
	'value' => $plugin->profile_type_selection,
]);

echo elgg_view_module('inline', elgg_echo('profile_manager:settings:edit_profile'), $edit_profile);


$view_profile = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:show_profile_type_on_profile'),
	'name' => 'params[show_profile_type_on_profile]',
	'options_values' => $yesno_options,
	'value' => $plugin->show_profile_type_on_profile,
]);

$view_profile .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:display_categories'),
	'name' => 'params[display_categories]',
	'options_values' => [
		'plain' => elgg_echo('profile_manager:settings:display_categories:option:plain'),
		'accordion' => elgg_echo('profile_manager:settings:display_categories:option:accordion'),
	],
	'value' => $plugin->display_categories,
]);
	
$view_profile .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:display_system_category'),
	'name' => 'params[display_system_category]',
	'options_values' => $noyes_options,
	'value' => $plugin->display_system_category,
]);
	
echo elgg_view_module('inline', elgg_echo('profile_manager:settings:view_profile'), $view_profile);


$group_profile = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:group:group_limit_name'),
	'name' => 'params[group_limit_name]',
	'options_values' => $group_limit_options,
	'value' => $plugin->group_limit_name,
]);

$group_profile .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:group:group_limit_description'),
	'#help' => elgg_echo('profile_manager:settings:group:limit:info'),
	'name' => 'params[group_limit_description]',
	'options_values' => $group_limit_options,
	'value' => $plugin->group_limit_description,
]);

echo elgg_view_module('inline', elgg_echo('profile_manager:settings:group'), $group_profile);


$other = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:enable_profile_completeness_widget'),
	'name' => 'params[enable_profile_completeness_widget]',
	'options_values' => $noyes_options,
	'value' => $plugin->enable_profile_completeness_widget,
]);
	
$other .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('profile_manager:settings:profile_completeness:avatar'),
	'#help' => elgg_echo('profile_manager:settings:profile_completeness:avatar:help'),
	'name' => 'params[profile_completeness_avatar]',
	'value' => $plugin->profile_completeness_avatar,
	'min' => 0,
	'max' => 100,
]);
	
$other .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:enable_username_change'),
	'name' => 'params[enable_username_change]',
	'options_values' => $enable_username_change_options,
	'value' => $plugin->enable_username_change,
]);

$other .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:settings:enable_site_join_river_event'),
	'name' => 'params[enable_site_join_river_event]',
	'options_values' => $yesno_options,
	'value' => $plugin->enable_site_join_river_event,
]);

echo elgg_view_module('inline', elgg_echo('other'), $other);
