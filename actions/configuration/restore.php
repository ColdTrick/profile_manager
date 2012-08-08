<?php
	/**
	* Profile Manager
	* 
	* Restore of profile fields backup
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	if($json = get_uploaded_file("restoreFile")){
		if($data = json_decode($json, true)){
			switch ( pm_restore_from_json($data) ) {
				case 1:
					system_message(elgg_echo("profile_manager:actions:restore:success"));
					break;
				case -1:
					register_error(elgg_echo("profile_manager:actions:restore:error:deleting"));
					break;
				case -2:
					register_error(elgg_echo("profile_manager:actions:restore:error:fieldtype"));
					break;
				case -3:
					register_error(elgg_echo("profile_manager:actions:restore:error:corrupt"));
					break;
			}
		} else {
			register_error(elgg_echo("profile_manager:actions:restore:error:json"));
		}
	} else {
		register_error(elgg_echo("profile_manager:actions:restore:error:nofile"));
	}
	
	forward(REFERER);