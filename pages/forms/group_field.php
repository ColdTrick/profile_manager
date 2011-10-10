<?php
	$vars = array();
	
	if($guid = get_input("guid")){
		if($entity = get_entity($guid)){
			if($entity instanceof ProfileManagerCustomGroupField){
				$vars["entity"] = $entity;
			}
		}
	}
	
	echo elgg_view("forms/profile_manager/group_field", $vars);