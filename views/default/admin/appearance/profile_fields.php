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
	
	$types = elgg_view("profile_manager/profile_types/list");
	$categories = elgg_view("profile_manager/categories/list");
	$fields = elgg_view("profile_manager/profile_fields/list");
	$actions = elgg_view("profile_manager/profile_fields/actions");
	
	$page_data = $types . $categories . $fields . $actions;
	
	echo elgg_view("profile_manager/admin/tabs", array("profile_fields_selected" => true));
	echo $page_data;