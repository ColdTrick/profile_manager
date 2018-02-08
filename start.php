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

	// Extend CSS
	elgg_extend_view('css/admin', 'css/profile_manager/global.css');
	elgg_extend_view('css/admin', 'css/profile_manager/admin.css');
	elgg_extend_view('css/admin', 'jquery/multiselect.css');
	elgg_extend_view('css/elgg', 'css/profile_manager/global.css');
	elgg_extend_view('css/elgg', 'css/profile_manager/site.css');
	elgg_extend_view('css/elgg', 'jquery/multiselect.css');
	
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
	
	// site join event handler
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\ProfileManager\Sites::createMember');
	elgg_register_event_handler('delete', 'relationship', '\ColdTrick\ProfileManager\Sites::deleteMember');
	
	// register ajax views
	elgg_register_ajax_view('forms/profile_manager/type');
	elgg_register_ajax_view('forms/profile_manager/category');
	elgg_register_ajax_view('forms/profile_manager/group_field');
	elgg_register_ajax_view('forms/profile_manager/profile_field');
}

// elgg initialization events
elgg_register_event_handler('init', 'system', 'profile_manager_init');
	