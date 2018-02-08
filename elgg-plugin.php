<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'custom_profile_field',
			'class' => '\ColdTrick\ProfileManager\CustomProfileField',
		],
		[
			'type' => 'object',
			'subtype' => 'custom_group_field',
			'class' => '\ColdTrick\ProfileManager\CustomGroupField',
		],
		[
			'type' => 'object',
			'subtype' => 'custom_profile_type',
			'class' => '\ColdTrick\ProfileManager\CustomProfileType',
		],
		[
			'type' => 'object',
			'subtype' => 'custom_profile_field_category',
			'class' => '\ColdTrick\ProfileManager\CustomFieldCategory',
		],
	],
	'views' => [
		'default' => [
			'jquery/multiselect.js' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/src/jquery.multiselect.js',
			'jquery/multiselect.css' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/jquery.multiselect.css',
		],
	],
	'actions' => [
		'profile_manager/change_category' => ['access' => 'admin'],
		'profile_manager/delete' => ['access' => 'admin'],
		'profile_manager/export' => ['access' => 'admin'],
		'profile_manager/import_from_custom' => ['access' => 'admin'],
		'profile_manager/import_from_default' => ['access' => 'admin'],
		'profile_manager/new' => ['access' => 'admin'],
		'profile_manager/reorder' => ['access' => 'admin'],
		'profile_manager/reset' => ['access' => 'admin'],
		'profile_manager/toggle_option' => ['access' => 'admin'],
		
		'profile_manager/configuration/backup' => ['access' => 'admin'],
		'profile_manager/configuration/restore' => ['access' => 'admin'],
		
		'profile_manager/categories/add' => ['access' => 'admin'],
		'profile_manager/categories/reorder' => ['access' => 'admin'],
		'profile_manager/categories/delete' => ['access' => 'admin'],

		'profile_manager/profile_types/add' => ['access' => 'admin'],
		'profile_manager/profile_types/delete' => ['access' => 'admin'],

		'profile_manager/users/export_inactive' => ['access' => 'admin'],

		'profile_manager/register/validate' => ['access' => 'public'],
		
		// admin user add, registered here to overrule default action
		'useradd' => [
			'access' => 'admin',
			'filename' => __DIR__ . 'actions/useradd.php',
		],
		
	],
];
