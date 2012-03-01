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

	$fieldtype = get_input("fieldtype");
	if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
		echo elgg_view("profile_manager/admin/tabs");
		echo elgg_view("profile_manager/export", array("fieldtype" => $fieldtype));
	} else {
		forward();
	}