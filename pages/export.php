<?php 
	/**
	* Profile Manager
	* 
	* Export of profile fields
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	global $CONFIG;
	
	admin_gatekeeper();
	
	// make nice left sidebar
	set_context('admin');
	set_page_owner(get_loggedin_userid());
	
	$fieldtype = get_input("fieldtype");
	if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
		
		$title_text = elgg_echo("profile_manager:export:title");
		$title = elgg_view_title($title_text);
		
		$export = elgg_view("profile_manager/export", array("fieldtype" => $fieldtype));
		
		$page_data = $title . $export;
		
		page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
	} else {
		forward();
	}
?>