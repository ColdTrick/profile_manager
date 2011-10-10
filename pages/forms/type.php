<?php
	
	$vars = array();
	
	if($guid = get_input("guid")){
		if($entity = get_entity($guid)){
			if($entity instanceof ProfileManagerCustomProfileType){
				$vars["entity"] = $entity;
			}
		}
	}
	
	echo elgg_view("forms/profile_manager/type", $vars);