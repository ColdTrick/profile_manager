<?php 
	/**
	* Profile Manager
	* 
	* Group Profile Fields Config page
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	global $CONFIG;
	
	admin_gatekeeper();
	
	set_context("admin");
	
	set_page_owner($_SESSION['guid']);
	
	$title_text = elgg_echo("profile_manager:group_fields:title");
	$title = elgg_view_title($title_text);
	
	$js = elgg_view("profile_manager/js");
	$add = elgg_view("profile_manager/group_fields/add");
	$list = elgg_view("profile_manager/group_fields/list");
	$actions = elgg_view("profile_manager/group_fields/actions");
	
	$page_data = $title . $js . $add . $list . $actions;
	
	page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
?>