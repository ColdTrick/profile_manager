<?php
	/**
	* Profile Manager
	* 
	* Action to reset profile fields
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	global $CONFIG; 

	admin_gatekeeper();
	
	$type = get_input("type", "profile");

	if($type == "profile" || $type == "group"){
		
		$options = array(
				"type" => "object",
				"subtype" => "custom_" . $type . "_field",
				"limit" => false,
				"owner_guid" => $CONFIG->site_guid
			);
		
		if($entities = elgg_get_entities($options)){
			foreach($entities as $entity){
				if(!$entity->delete()){
					$error = true;
				}
			}
		}
		
		if(!$error){
			system_message(elgg_echo("profile_manager:actions:reset:success"));
		} else {
			register_error(elgg_echo("profile_manager:actions:reset:error:unknown"));
		}
	} else {
		register_error(elgg_echo("profile_manager:actions:reset:error:wrong_type"));
	}
	
	forward($_SERVER['HTTP_REFERER']);