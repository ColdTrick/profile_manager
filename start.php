<?php
/**
* Profile Manager
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

require_once(dirname(__FILE__) . '/lib/functions.php');

define('CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE', 'custom_profile_field_category');
define('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE', 'custom_profile_type');
define('CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE', 'custom_profile_field');
define('CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE', 'custom_group_field');

define('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP', 'custom_profile_type_category_relationship');

/**
 * Initialization of plugin
 *
 * @return void
 */
function profile_manager_init() {
	// register libraries
	elgg_define_js('jquery.multiselect', [
		'src' => 'mod/profile_manager/vendors/jquery_ui_multiselect/jquery.multiselect.js',
		'deps' => ['elgg','jquery'],
	]);
	// Extend CSS
	elgg_extend_view('css/admin', 'css/profile_manager/global.css');
	elgg_extend_view('css/admin', 'css/profile_manager/admin.css');
	elgg_extend_view('css/admin', 'css/profile_manager/multiselect.css');
	elgg_extend_view('css/elgg', 'css/profile_manager/multiselect.css');
	elgg_extend_view('css/elgg', 'css/profile_manager/global.css');
	elgg_extend_view('css/elgg', 'css/profile_manager/site.css');
	
	// admin user add, registered here to overrule default action
	elgg_register_action('useradd', dirname(__FILE__) . '/actions/useradd.php', 'admin');
	
	// Register all custom field types
	profile_manager_register_custom_field_types();
	
	// add profile_completeness widget
	if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') == 'yes') {
		elgg_register_widget_type('profile_completeness', elgg_echo('widgets:profile_completeness:title'), elgg_echo('widgets:profile_completeness:description'), ['profile', 'dashboard']);
	}
	
	elgg_register_widget_type('register', elgg_echo('widgets:register:title'), elgg_echo('widgets:register:description'), ['index']);
	
	// free_text on register form
	elgg_extend_view('register/extend_side', 'profile_manager/register/free_text');
	
	// where to put extra profile fields
	elgg_extend_view('register/extend_side', 'profile_manager/register/fields');
	elgg_extend_view('register/extend', 'profile_manager/register/fields');
	
	// login history
	elgg_extend_view('core/settings/statistics', 'profile_manager/account/login_history');
		
	// extend public pages
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', '\ColdTrick\ProfileManager\Sites::publicPages');
	
	// enable username change
	elgg_extend_view('forms/account/settings', 'profile_manager/account/username', 50); // positioned at the beginning of the options

	// register hook for saving the new username
	elgg_register_plugin_hook_handler('usersettings:save', 'user', '\ColdTrick\ProfileManager\Users::usernameChange');
	
	elgg_register_plugin_hook_handler('view_vars', 'input/form', '\ColdTrick\ProfileManager\Users::registerViewVars');
	
	// menu hooks
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\ProfileManager\Menus::registerAdmin');
	
	// site join event handler
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\ProfileManager\Sites::createMember');
	elgg_register_event_handler('delete', 'relationship', '\ColdTrick\ProfileManager\Sites::deleteMember');
	
	// register ajax views
	elgg_register_ajax_view('forms/profile_manager/type');
	elgg_register_ajax_view('forms/profile_manager/category');
	elgg_register_ajax_view('forms/profile_manager/group_field');
	elgg_register_ajax_view('forms/profile_manager/profile_field');
}

/**
 * Performs class upgrade before init as classes are needed during init
 *
 * @return void
 */
function profile_manager_plugins_boot() {
	$classes = [
		'\ColdTrick\ProfileManager\CustomProfileField',
		'\ColdTrick\ProfileManager\CustomGroupField',
		'\ColdTrick\ProfileManager\CustomProfileType',
		'\ColdTrick\ProfileManager\CustomFieldCategory',
	];
	
	foreach ($classes as $class) {
		$current_class = get_subtype_class('object', $class::SUBTYPE);
		if ($current_class !== $class) {
			update_subtype('object', $class::SUBTYPE, $class);
		}
	}
}

// elgg initialization events
elgg_register_event_handler('plugins_boot', 'system', 'profile_manager_plugins_boot');
elgg_register_event_handler('init', 'system', 'profile_manager_init');

// users
elgg_register_event_handler('create', 'user', '\ColdTrick\ProfileManager\Users::create');
elgg_register_event_handler('profileupdate','user', '\ColdTrick\ProfileManager\Users::updateProfile');
elgg_register_plugin_hook_handler('action', 'register', '\ColdTrick\ProfileManager\Users::actionRegister');

// groups
elgg_register_plugin_hook_handler('action', 'groups/edit', '\ColdTrick\ProfileManager\Groups::groupsEdit');

// profile fields
elgg_register_plugin_hook_handler('profile:fields', 'profile', '\ColdTrick\ProfileManager\ProfileFields::getUserFields');
elgg_register_plugin_hook_handler('profile:fields', 'group', '\ColdTrick\ProfileManager\ProfileFields::getGroupFields');
elgg_register_plugin_hook_handler('categorized_profile_fields', 'profile_manager', '\ColdTrick\ProfileManager\ProfileFields::addAdminFields', 1000);

// actions
elgg_register_action("profile_manager/new", dirname(__FILE__) . "/actions/new.php", "admin");
elgg_register_action("profile_manager/reset", dirname(__FILE__) . "/actions/reset.php", "admin");
elgg_register_action("profile_manager/reorder", dirname(__FILE__) . "/actions/reorder.php", "admin");
elgg_register_action("profile_manager/delete", dirname(__FILE__) . "/actions/delete.php", "admin");
elgg_register_action("profile_manager/toggleOption", dirname(__FILE__) . "/actions/toggleOption.php", "admin");
elgg_register_action("profile_manager/changeCategory", dirname(__FILE__) . "/actions/changeCategory.php", "admin");
elgg_register_action("profile_manager/importFromCustom", dirname(__FILE__) . "/actions/importFromCustom.php", "admin");
elgg_register_action("profile_manager/importFromDefault", dirname(__FILE__) . "/actions/importFromDefault.php", "admin");
elgg_register_action("profile_manager/export", dirname(__FILE__) . "/actions/export.php", "admin");
elgg_register_action("profile_manager/configuration/backup", dirname(__FILE__) . "/actions/configuration/backup.php", "admin");
elgg_register_action("profile_manager/configuration/restore", dirname(__FILE__) . "/actions/configuration/restore.php", "admin");

elgg_register_action("profile_manager/categories/add", dirname(__FILE__) . "/actions/categories/add.php", "admin");
elgg_register_action("profile_manager/categories/reorder", dirname(__FILE__) . "/actions/categories/reorder.php", "admin");
elgg_register_action("profile_manager/categories/delete", dirname(__FILE__) . "/actions/categories/delete.php", "admin");

elgg_register_action("profile_manager/profile_types/add", dirname(__FILE__) . "/actions/profile_types/add.php", "admin");
elgg_register_action("profile_manager/profile_types/delete", dirname(__FILE__) . "/actions/profile_types/delete.php", "admin");

elgg_register_action("profile_manager/users/export_inactive", dirname(__FILE__) . "/actions/users/export_inactive.php", "admin");

elgg_register_action("profile_manager/register/validate", dirname(__FILE__) . "/actions/register/validate.php", "public");
	