<?php 
	/**
	* Profile Manager
	* 
	* User Profile Fields Config page
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	admin_gatekeeper();
	
	global $CONFIG;
	
	set_context('admin');
	
	set_page_owner($_SESSION['guid']);
	
	$title = elgg_view_title(elgg_echo("profile:edit:default"));
	$js = elgg_view("profile_manager/js");
	$header = elgg_view("profile_manager/profile_fields/header");
	$field_add = elgg_view("profile_manager/profile_fields/add");
	$cat_add = elgg_view("profile_manager/categories/add");
	$type_add = elgg_view("profile_manager/profile_types/add");
	$list = elgg_view("profile_manager/profile_fields/list");
	$actions = elgg_view("profile_manager/profile_fields/actions");
	$more_info = elgg_view("profile_manager/profile_fields/more_info");
	
	$page_data = $title . $js . $header . $field_add . $cat_add . $type_add . $list . $actions . $more_info;
	
	page_draw(elgg_echo("profile:edit:default"), elgg_view_layout("two_column_left_sidebar", "", $page_data));
?>