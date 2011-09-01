<?php 
	/**
	* Profile Manager
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	require_once(dirname(__FILE__) . "/lib/classes.php");
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
		global $CONFIG;
		
		/* Profile NoIndex*/
			elgg_extend_view("profile/edit", "profile_noindex/edit_profile", 400);		
			// extend CSS
			elgg_extend_view("css", "profile_noindex/css");
		
		
		
		// Extend CSS
		elgg_extend_view("css", "profile_manager/css");
		elgg_extend_view("css", "members/css");
		elgg_extend_view("js/initialise_elgg", "profile_manager/global_js");
		
		// extend the user profile view
		elgg_extend_view("profile/userdetails", "profile_manager/profile/userdetails");
		
		// link to full profile
		if(get_plugin_setting("show_full_profile_link") == "yes"){
			elgg_extend_view("profile/menu/actions", "profile_manager/profile/userlinks");
		}
		
		// Extend the admin statistics
		if(get_plugin_setting("show_admin_stats") == "yes"){
			elgg_extend_view("admin/statistics", "profile_manager/admin_stats");
		}
		
		// Register a page handler, so we can have nice URLs
		register_page_handler('defaultprofile', 'profile_manager_edit_defaults_page_handler');
		
		// Register Page handler for Custom Profile Fields
		register_page_handler("profile_manager", "profile_manager_page_handler");
		
		// Register Page handler for Members listing
		if(get_plugin_setting("show_members_search") == "yes"){
			register_page_handler("members", "profile_manager_members_page_handler");
			add_menu(elgg_echo("profile_manager:members:menu"), $CONFIG->wwwroot . "pg/members");
		}
		
		// admin user add, registered here to overrule default action
		register_action("useradd", false, dirname(__FILE__) . "/actions/admin/useradd.php", true);
		
		// Register all custom field types
		register_custom_field_types();
		
		// add profile_completeness widget 
		if(get_plugin_setting("enable_profile_completeness_widget") == "yes"){
			add_widget_type("profile_completeness", elgg_echo("profile_manager:widget:profile_completeness:title"), elgg_echo("profile_manager:widget:profile_completeness:description"), "profile,dashboard");
		}
		
		// free_text on register form
		elgg_extend_view("register/extend_side", "profile_manager/register/free_text");
		
		// where to put extra profile fields
		if(get_plugin_setting("registration_extra_fields", "profile_manager") == "beside"){
			// besides the default registration page
			elgg_extend_view("register/extend_side", "profile_manager/register/fields");
		} else {
			// just below the default registration page
			elgg_extend_view("register/extend", "profile_manager/register/fields");
		}
		
		// allow login by mail
		if(get_plugin_setting("login_by_email", "profile_manager") == "yes"){
			// overrule action to allow login by mail
			register_action("login", true, dirname(__FILE__) . "/actions/core/login.php");
			
			// request password by email
			register_action("user/requestnewpassword_by_email", true, dirname(__FILE__) . "/actions/user/requestnewpassword_by_email.php");
			
			// register pam handler to authenticate based on email
			register_pam_handler("profile_manager_email_pam_handler");
		}
		
		// Run once function to configure this plugin
		run_function_once('profile_manager_run_once', 1287964800); // 2010-10-25
		run_function_once('pm_fix_access_default'); 		
	}
	
	/**
	 * function to handle the 'old' replace profile fields url
	 * 
	 * @param $page
	 * @return unknown_type
	 */
	function profile_manager_edit_defaults_page_handler($page){
		global $CONFIG;
		
		// Forward to new form url
		if($page[0] == "edit"){
			forward($CONFIG->wwwroot . "pg/profile_manager/profile_fields");
		} 
	}
	
	/**
	 * function to handle the nice urls for Custom Profile Fields
	 * 
	 * @param $page
	 * @return unknown_type
	 */
	function profile_manager_page_handler($page){
		global $CONFIG;
		
		switch($page[0]){
			case "group_fields":
				include(dirname(__FILE__) . "/pages/group_fields.php");
				break;
			case "profile_fields":
				include(dirname(__FILE__) . "/pages/profile_fields.php");
				break;
			case "full_profile":
				set_input("profile_guid", $page[1]);
				include(dirname(__FILE__) . "/pages/full_profile.php");
				break;
			case "export":
				set_input("fieldtype", $page[1]);
				include(dirname(__FILE__) . "/pages/export.php");
				break;
			case "file_download":
				set_input("file_guid", $page[1]);
				include(dirname(__FILE__) . "/pages/file_download.php");
				break;
		}
	}
	
	function profile_manager_members_page_handler($page){
		
		switch($page[0]){
			case "search":
				include(dirname(__FILE__) . "/procedures/members/search.php");
				break;
			default:
				include(dirname(__FILE__) . "/pages/members.php");
				break;
		}
	}
	
	/**
	 * Function to add menu items to the pages
	 * 
	 * @return unknown_type
	 */
	function profile_manager_pagesetup(){
		global $CONFIG;
		
		
		$page_owner = page_owner_entity();
		$context = get_context();
		
		
		/*Profile NoIndex*/
		if(in_array($context, array("profile", "friends", "friendsof")) && ($page_owner instanceof ElggUser)){
			if(get_plugin_usersetting("hide_from_search_engine", $page_owner->getGUID(), "profile_noindex") == "yes"){
				// protect against search engines
				elgg_extend_view("metatags", "profile_noindex/metatags");
				
				// remove FoaF link
				elgg_unextend_view("metatags", "profile/metatags");
				
				// remove RSS/Atom/ links
				register_plugin_hook("display", "view", "profile_noindex_view_hook");
			}
		}
		
		
		
		if($context == "admin" && isadminloggedin()){
			if(is_plugin_enabled("profile")){
				// Remake admin submenu
				$subA = &$CONFIG->submenu["a"];
				
				foreach($subA as $index => $item){
					if($item->name == elgg_echo("profile:edit:default")){
						unset($subA[$index]);
					}
				}
			
				add_submenu_item(elgg_echo("profile:edit:default"), $CONFIG->wwwroot . "pg/profile_manager/profile_fields", "b");
			}
			
			if(is_plugin_enabled("groups")){
				add_submenu_item(elgg_echo("profile_manager:group_fields"), $CONFIG->wwwroot . "pg/profile_manager/group_fields", "b");
			}
		}
		if(get_plugin_setting("show_members_search") == "yes" && (get_input("handler") == "search" || strpos($_SERVER["REQUEST_URI"], "/search/") === 0)){
			add_submenu_item(elgg_echo('profile_manager:members:submenu'), $CONFIG->wwwroot . "pg/members", "b");
		}
	}
	
	// Initialization functions
	register_elgg_event_handler('init', 'system', 'profile_manager_init');
	register_elgg_event_handler('pagesetup', 'system', 'profile_manager_pagesetup');
	
	register_elgg_event_handler('create', 'user', 'profile_manager_create_user_event');
	register_elgg_event_handler('all', 'object', 'profile_manager_all_object_event');
	register_elgg_event_handler('profileupdate','user', 'profile_manager_profileupdate_user_event');
	register_elgg_event_handler('profileiconupdate','user', 'profile_manager_profileiconupdate_user_event');
	
	register_plugin_hook('profile:fields', 'profile', 'profile_manager_profile_override');
	register_plugin_hook('profile:fields', 'group', 'profile_manager_group_override');
	
	register_plugin_hook('action', 'register', 'profile_manager_action_register_hook');
	
	register_plugin_hook('categorized_profile_fields', 'profile_manager', 'profile_manager_categorized_profile_fields_hook', 1000);
	
	// actions
	register_action("profile_manager/new", false, $CONFIG->pluginspath . "profile_manager/actions/new.php", true);
	register_action("profile_manager/get_field_data", false, $CONFIG->pluginspath . "profile_manager/actions/get_field_data.php", true);
	register_action("profile_manager/reset", false, $CONFIG->pluginspath . "profile_manager/actions/reset.php", true);
	register_action("profile_manager/reorder", false, $CONFIG->pluginspath . "profile_manager/actions/reorder.php", true);
	register_action("profile_manager/delete", false, $CONFIG->pluginspath . "profile_manager/actions/delete.php", true);
	register_action("profile_manager/toggleOption", false, $CONFIG->pluginspath . "profile_manager/actions/toggleOption.php", true);
	register_action("profile_manager/changeCategory", false, $CONFIG->pluginspath . "profile_manager/actions/changeCategory.php", true);
	register_action("profile_manager/importFromCustom", false, $CONFIG->pluginspath . "profile_manager/actions/importFromCustom.php", true);
	register_action("profile_manager/importFromDefault", false, $CONFIG->pluginspath . "profile_manager/actions/importFromDefault.php", true);
	register_action("profile_manager/export", false, $CONFIG->pluginspath . "profile_manager/actions/export.php", true);
	register_action("profile_manager/configuration/backup", false, $CONFIG->pluginspath . "profile_manager/actions/configuration/backup.php", true);
	register_action("profile_manager/configuration/restore", false, $CONFIG->pluginspath . "profile_manager/actions/configuration/restore.php", true);
	
	register_action("profile_manager/categories/add", false, $CONFIG->pluginspath . "profile_manager/actions/categories/add.php", true);
	register_action("profile_manager/categories/reorder", false, $CONFIG->pluginspath . "profile_manager/actions/categories/reorder.php", true);
	register_action("profile_manager/categories/delete", false, $CONFIG->pluginspath . "profile_manager/actions/categories/delete.php", true);
	
	register_action("profile_manager/profile_types/add", false, $CONFIG->pluginspath . "profile_manager/actions/profile_types/add.php", true);
	register_action("profile_manager/profile_types/delete", false, $CONFIG->pluginspath . "profile_manager/actions/profile_types/delete.php", true);
	register_action("profile_manager/profile_types/get_description", false, $CONFIG->pluginspath . "profile_manager/actions/profile_types/get_description.php", true);
	
	// members
	register_action("profile_manager/members/search", true, $CONFIG->pluginspath . "profile_manager/actions/members/search.php"); // can be executed publically
		
?>