<?php 
	/**
	* Profile Manager
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/run_once.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/events.php");

	define("CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE", "custom_profile_field_category");
	define("CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE", "custom_profile_type");
	define("CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE", "custom_profile_field");
	define("CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE", "custom_group_field");
	
	define("CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP", "custom_profile_type_category_relationship");

	/**
	 * initialization of plugin
	 * 
	 * @return unknown_type
	 */
	function profile_manager_init(){
		// register libraries
		elgg_register_js("jquery.ui.multiselect", elgg_get_site_url() . "mod/profile_manager/vendors/jquery_ui_multiselect/jquery.multiselect.js");
		
		// Extend CSS
		elgg_extend_view("css/admin", "profile_manager/css/global");
		elgg_extend_view("css/admin", "profile_manager/css/admin");
		elgg_extend_view("css/admin", "profile_manager/css/multiselect");
		elgg_extend_view("css/elgg", "profile_manager/css/multiselect");
		elgg_extend_view("css/elgg", "profile_manager/css/global");
		elgg_extend_view("css/elgg", "profile_manager/css/site");
		
		elgg_extend_view("js/elgg", "profile_manager/js/site");
		elgg_extend_view("js/admin", "profile_manager/js/admin");
		
		// Register Page handler
		elgg_register_page_handler("profile_manager", "profile_manager_page_handler");
		
		// admin user add, registered here to overrule default action
		elgg_register_action("useradd", dirname(__FILE__) . "/actions/useradd.php", "admin");
		
		// Register all custom field types
		register_custom_field_types();
		
		// add profile_completeness widget 
		if(elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes"){
			elgg_register_widget_type("profile_completeness", elgg_echo("widgets:profile_completeness:title"), elgg_echo("widgets:profile_completeness:description"), "profile,dashboard");
		}
		
		elgg_register_widget_type("register", elgg_echo("widgets:register:title"), elgg_echo("widgets:register:description"), "index");
		
		// free_text on register form
		elgg_extend_view("register/extend_side", "profile_manager/register/free_text");
		
		// where to put extra profile fields
		if(elgg_get_plugin_setting("registration_extra_fields", "profile_manager") == "beside"){
			// besides the default registration page
			elgg_extend_view("register/extend_side", "profile_manager/register/fields");
		} else {
			// just below the default registration page
			elgg_extend_view("register/extend", "profile_manager/register/fields");
		}
		
		// login history
		elgg_extend_view('core/settings/statistics', 'profile_manager/account/login_history');
		
		// hook for extending menus
		elgg_register_plugin_hook_handler('register', 'menu:entity', 'profile_manager_register_entity_menu', 600);
		
		elgg_register_plugin_hook_handler('permissions_check:annotate', 'site', 'profile_manager_permissions_check_annotate');
		
		// enable username change
		elgg_extend_view("forms/account/settings", "profile_manager/account/username", 50); // positioned at the beginning of the options

		// register hook for saving the new username
		elgg_register_plugin_hook_handler('usersettings:save', 'user', 'profile_manager_username_change_hook');
		
		// site join event handler
		elgg_register_event_handler("create", "member_of_site", "profile_manager_create_member_of_site");
		
		// always cleanup
		elgg_register_event_handler("delete", "member_of_site", "profile_manager_delete_member_of_site");
		
		// Run once function to configure this plugin
		run_function_once('profile_manager_run_once', 1287964800); // 2010-10-25
		run_function_once('pm_fix_access_default'); 		
	}
	
	/**
	 * function to handle the nice urls for Custom Profile Fields
	 * 
	 * @param $page
	 * @return unknown_type
	 */
	function profile_manager_page_handler($page){
		switch($page[0]){
			case "forms":
				$form = $page[1];
				if(!empty($form) && elgg_is_admin_logged_in()){
					set_input("guid", $page[2]);	
					include(dirname(__FILE__) . "/pages/forms/" . $form . ".php");
					return true;	
				}
				break;
			case "validate_username":
				if(elgg_is_logged_in()){
					$new_username = get_input("username");
					$valid = false;
					if(!empty($new_username)){
						$valid = profile_manager_validate_username($new_username);
					}
					$result = array("valid" => $valid);
					echo json_encode($result);
					
					return true;
				}
				break;
			case "user_summary_control":
				include(dirname(__FILE__) . "/pages/user_summary_control/preview.php");
				return true;
		}
	}
	
	/**
	 * Function to add menu items to the pages
	 * 
	 * @return unknown_type
	 */
	function profile_manager_pagesetup(){
		if(elgg_in_context("admin") && elgg_is_admin_logged_in()){
			elgg_load_js('lightbox');
			elgg_load_css('lightbox');
			
			elgg_register_admin_menu_item('administer', 'export', 'users');
			elgg_register_admin_menu_item('administer', 'inactive', 'users');
			
			if(elgg_is_active_plugin("groups")){
				elgg_register_admin_menu_item('configure', 'group_fields', 'appearance');
			}
			
			if(elgg_get_plugin_setting("user_summary_control", "profile_manager") == "yes"){
				elgg_register_admin_menu_item('configure', 'user_summary_control', 'appearance');
			}
		}
	}
	
	// Initialization functions
	elgg_register_event_handler('init', 'system', 'profile_manager_init');
	elgg_register_event_handler('pagesetup', 'system', 'profile_manager_pagesetup');
	
	elgg_register_event_handler('create', 'user', 'profile_manager_create_user_event');
	elgg_register_event_handler('profileupdate','user', 'profile_manager_profileupdate_user_event');
	
	elgg_register_plugin_hook_handler('profile:fields', 'profile', 'profile_manager_profile_override');
	elgg_register_plugin_hook_handler('profile:fields', 'group', 'profile_manager_group_override');
	
	elgg_register_plugin_hook_handler('action', 'register', 'profile_manager_action_register_hook');
	
	elgg_register_plugin_hook_handler('categorized_profile_fields', 'profile_manager', 'profile_manager_categorized_profile_fields_hook', 1000);
	
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

	elgg_register_action("profile_manager/user_summary_control/save", dirname(__FILE__) . "/actions/user_summary_control/save.php", "admin");

	elgg_register_action("profile_manager/users/export_inactive", dirname(__FILE__) . "/actions/users/export_inactive.php", "admin");

	elgg_register_action("profile_manager/register/validate", dirname(__FILE__) . "/actions/register/validate.php", "public");
	