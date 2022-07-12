<?php

use ColdTrick\ProfileManager\Bootstrap;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '18.0.1',
		'dependencies' => [
			'profile' => ['position' => 'after'],
		],
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'generate_username_from_email' => 'no',
		'show_account_hints' => 'no',
		'profile_icon_on_register' => 'no',
		'hide_profile_type_default' => 'no',
		'simple_access_control' => 'no',
		'edit_profile_mode' => 'list',
		'profile_type_selection' => 'user',
		'show_profile_type_on_profile' => 'no',
		'display_categories' => 'plain',
		'enable_profile_completeness_widget' => 'no',
		'enable_site_join_river_event' => 'yes',
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'custom_profile_field',
			'class' => '\ColdTrick\ProfileManager\CustomProfileField',
			'capabilities' => [
				'commentable' => false,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'custom_group_field',
			'class' => '\ColdTrick\ProfileManager\CustomGroupField',
			'capabilities' => [
				'commentable' => false,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'custom_profile_type',
			'class' => '\ColdTrick\ProfileManager\CustomProfileType',
			'capabilities' => [
				'commentable' => false,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'custom_profile_field_category',
			'class' => '\ColdTrick\ProfileManager\CustomFieldCategory',
			'capabilities' => [
				'commentable' => false,
			],
		],
	],
	'views' => [
		'default' => [
			'jquery/multiselect.js' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/src/jquery.multiselect.js',
			'jquery/multiselect.css' => $composer_path . 'vendor/bower-asset/jquery-ui-multiselect-widget/css/jquery.multiselect.css',
		],
	],
	'view_extensions' => [
		'css/admin' => [
			'css/profile_manager/admin.css' => [],
		],
		'css/elgg' => [
			'css/profile_manager/site.css' => [],
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
		'forms/profile_manager/type' => ['ajax' => true],
		'forms/profile_manager/category' => ['ajax' => true],
		'forms/profile_manager/group_field' => ['ajax' => true],
		'forms/profile_manager/profile_field' => ['ajax' => true],
		'forms/profile_manager/restore_fields' => ['ajax' => true],
	],
	'actions' => [
		'profile_manager/change_category' => ['access' => 'admin'],
		'profile_manager/import_existing' => ['access' => 'admin'],
		'profile_manager/new' => ['access' => 'admin'],
		'profile_manager/reorder' => ['access' => 'admin'],
		'profile_manager/reset' => ['access' => 'admin'],
		'profile_manager/toggle_option' => ['access' => 'admin'],
		
		'profile_manager/configuration/backup' => ['access' => 'admin'],
		'profile_manager/configuration/restore' => ['access' => 'admin'],
		
		'profile_manager/categories/add' => ['access' => 'admin'],
		'profile_manager/categories/reorder' => ['access' => 'admin'],

		'profile_manager/profile_types/add' => ['access' => 'admin'],
	],
	'hooks' => [
		'fields' => [
			'user:user' => [
				'\ColdTrick\ProfileManager\ProfileFields::getFields' => [],
			],
			'group:group' => [
				'\ColdTrick\ProfileManager\ProfileFields::getFields' => [],
			],
		],
		'handlers' => [
			'widgets' => [
				'\ColdTrick\ProfileManager\Widgets::registerProfileCompleteness' => [],
			],
		],
		'register' => [
			'menu:page' => [
				'\ColdTrick\ProfileManager\Menus::registerAdmin' => [],
			],
			'menu:profile_fields' => [
				'\ColdTrick\ProfileManager\Menus::registerProfileFieldsActions' => [],
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
	'events' => [
		'create' => [
			'user' => [
				'\ColdTrick\ProfileManager\Users::createUserByAdmin' => [],
				'\ColdTrick\ProfileManager\Users::createUserByRegister' => [],
			],
		],
		'validate:after' => [
			'user' => [
				'\ColdTrick\ProfileManager\Users::createUserRiverItem' => [],
			],
		],
	],
];
