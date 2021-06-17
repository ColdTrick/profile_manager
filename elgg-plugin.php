<?php

use Elgg\Project\Paths;
use ColdTrick\ProfileManager\Bootstrap;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '15.0.2',
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
	'routes' => [
		'action:register' => [
			'path' => '/action/register',
			'file' => Paths::elgg() . 'actions/register.php',
			'walled' => false,
			'middleware' => [
				'\Elgg\Router\Middleware\ActionMiddleware',
				'\ColdTrick\ProfileManager\Users::validateRegisterAction',
			]
		],
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
		'register' => [
			'menu:page' => [
				'\ColdTrick\ProfileManager\Menus::registerAdmin' => [],
			],
			'menu:profile_fields' => [
				'\ColdTrick\ProfileManager\Menus::registerProfileFieldsActions' => [],
			],
		],
	],
	'events' => [
		'create' => [
			'user' => [
				'\ColdTrick\ProfileManager\Users::createUserByRegister' => [],
				'\ColdTrick\ProfileManager\Users::createUserRiverItem' => [],
			],
		],
	],
];
