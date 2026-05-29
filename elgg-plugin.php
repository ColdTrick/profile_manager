<?php

use ColdTrick\ProfileManager\Bootstrap;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '23.0',
		'dependencies' => [
			'profile' => ['position' => 'after'],
		],
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'generate_username_from_email' => false,
		'show_account_hints' => false,
		'profile_icon_on_register' => 'no',
		'hide_profile_type_default' => false,
		'simple_access_control' => false,
		'edit_profile_mode' => 'list',
		'profile_type_selection' => 'user',
		'show_profile_type_on_profile' => false,
		'display_categories' => 'plain',
	],
	'upgrades' => [
		\ColdTrick\ProfileManager\Upgrades\MigratePluginSwitchSettings::class,
	],
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
	'actions' => [
		'profile_manager/change_category' => ['access' => 'admin'],
		'profile_manager/categories/add' => ['access' => 'admin'],
		'profile_manager/categories/reorder' => ['access' => 'admin'],
		'profile_manager/configuration/backup' => [
			'access' => 'admin',
			'controller' => \ColdTrick\ProfileManager\BackupController::class,
		],
		'profile_manager/configuration/restore' => ['access' => 'admin'],
		'profile_manager/import_existing' => ['access' => 'admin'],
		'profile_manager/fields/group' => [
			'access' => 'admin',
			'filename' => __DIR__ . '/actions/profile_manager/new.php',
		],
		'profile_manager/fields/profile' => [
			'access' => 'admin',
			'filename' => __DIR__ . '/actions/profile_manager/new.php',
		],
		'profile_manager/profile_types/add' => ['access' => 'admin'],
		'profile_manager/reorder' => ['access' => 'admin'],
		'profile_manager/reset' => ['access' => 'admin'],
		'profile_manager/toggle_option' => ['access' => 'admin'],
	],
	'events' => [
		'create' => [
			'user' => [
				'\ColdTrick\ProfileManager\Users::createUserByAdmin' => [],
				'\ColdTrick\ProfileManager\Users::createUserByRegister' => [],
			],
		],
		'fields' => [
			'user:user' => [
				'\ColdTrick\ProfileManager\ProfileFields::getFields' => [],
			],
			'group:group' => [
				'\ColdTrick\ProfileManager\ProfileFields::getFields' => [],
			],
		],
		'register' => [
			'menu:admin_header' => [
				'\ColdTrick\ProfileManager\Menus\AdminHeader::registerGroupFields' => [],
			],
			'menu:profile_fields' => [
				'\ColdTrick\ProfileManager\Menus\ProfileFields::registerActions' => [],
			],
		],
		'types:custom_group_field' => [
			'profile_manager' => [
				'\ColdTrick\ProfileManager\ProfileFields::registerGroupProfileFieldTypes' => [],
			],
		],
		'types:custom_profile_field' => [
			'profile_manager' => [
				'\ColdTrick\ProfileManager\ProfileFields::registerUserProfileFieldTypes' => [],
			],
		],
	],
	'views' => [
		'default' => [
			'jquery/multiselect.mjs' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/src/jquery.multiselect.js',
			'jquery/multiselect.css' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/css/jquery.multiselect.css',
		],
	],
	'view_extensions' => [
		'admin.css' => [
			'profile_manager/admin.css' => [],
		],
		'elgg.css' => [
			'profile_manager/site.css' => [],
		],
		'forms/register' => [
			'profile_manager/register/free_text' => ['priority' => 400],
		],
		'input/multiselect.css' => [
			'jquery/multiselect.css' => ['priority' => 100],
		],
		'forms/useradd' => [
			'profile_manager/admin/useradd' => [],
		],
		'register/extend' => [
			'profile_manager/register/fields' => [],
		],
	],
	'view_options' => [
		'forms/profile_manager/profile_types/add' => ['ajax' => true],
		'forms/profile_manager/categories/add' => ['ajax' => true],
		'forms/profile_manager/fields/group' => ['ajax' => true],
		'forms/profile_manager/fields/profile' => ['ajax' => true],
		'forms/profile_manager/configuration/restore' => ['ajax' => true],
	],
];
