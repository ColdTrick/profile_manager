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
		/* Profile NoIndex*/
		//if(elgg_get_plugin_setting("allow_profile_noindex", "profile_manager") == 'yes'){
		//	elgg_extend_view("profile/edit", "profile_manager/profile/edit_profile", 400);		
		//}
		
		// Extend CSS
		elgg_extend_view("css/admin", "profile_manager/css/global");
		elgg_extend_view("css/admin", "profile_manager/css/admin");
		elgg_extend_view("css/elgg", "profile_manager/css/global");
		elgg_extend_view("css/elgg", "profile_manager/css/site");
		
		elgg_extend_view("js/elgg", "profile_manager/js/site");
		elgg_extend_view("js/admin", "profile_manager/js/admin");
		
		// Register Page handler
		elgg_register_page_handler("profile_manager", "profile_manager_page_handler");
		
		/*
		 * TODO: get it working for 1.8
		// Register Page handler for Members listing
		if(elgg_get_plugin_setting("show_members_search") == "yes"){
			elgg_register_page_handler("members", "profile_manager_members_page_handler");
			add_menu(elgg_echo("profile_manager:members:menu"), $CONFIG->wwwroot . "pg/members");
		}
		*/
		
		// admin user add, registered here to overrule default action
		elgg_register_action("useradd", dirname(__FILE__) . "/actions/useradd.php", "admin");
		
		// Register all custom field types
		register_custom_field_types();
		
		// add profile_completeness widget 
		if(elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes"){
			elgg_register_widget_type("profile_completeness", elgg_echo("widgets:profile_completeness:title"), elgg_echo("widgets:profile_completeness:description"), "profile,dashboard");
		}
		
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
				if(!empty($form)){
					set_input("guid", $page[2]);	
					include(dirname(__FILE__) . "/pages/forms/" . $form . ".php");
					return true;	
				}
				break;
		}
	}
	
	/*
	 * TODO: get it working for 1.8
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
	*/
	
	/**
	 * Function to add menu items to the pages
	 * 
	 * @return unknown_type
	 */
	function profile_manager_pagesetup(){
		$context = elgg_get_context();
		
		/*if(elgg_get_plugin_setting("allow_profile_noindex", "profile_manager") == 'yes'){
			$page_owner = elgg_get_page_owner_entity();
			
			//Profile NoIndex
			if(in_array($context, array("profile", "friends", "friendsof")) && ($page_owner instanceof ElggUser)){
				if(elgg_get_plugin_user_setting("hide_from_search_engine", $page_owner->getGUID(), "profile_manager") == "yes"){
					// protect against search engines
					elgg_extend_view("metatags", "profile_manager/profile/noindex");
					
					// remove FoaF link
					// TODO: check if still existing in 1.8
					elgg_unextend_view("metatags", "profile/metatags");
					
					// remove RSS/Atom/ links
					// TODO: check if still existing in 1.8
					elgg_register_plugin_hook_handler("display", "view", "profile_manager_profile_noindex_view_hook");
				}
			}
		}*/
		
		if($context == "admin" && elgg_is_admin_logged_in()){
			elgg_load_js('lightbox');
			elgg_load_css('lightbox');
			
			if(elgg_is_active_plugin("groups")){
				elgg_register_admin_menu_item('configure', 'group_fields', 'appearance');
			}
		}
		/*
		TODO: get it working for 1.8 
		if(elgg_get_plugin_setting("show_members_search") == "yes" && (get_input("handler") == "search" || strpos($_SERVER["REQUEST_URI"], "/search/") === 0)){
			// Site navigation
			$item = new ElggMenuItem("members", elgg_echo('profile_manager:members:submenu'), "members");
			elgg_register_menu_item('site', $item);
		}
		*/
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
	
	// members
	//elgg_register_action("profile_manager/members/search", dirname(__FILE__) . "/actions/members/search.php", "public");
	