<?php

	$vars = array();

	if($guid = get_input("guid")){
		if($entity = get_entity($guid)){
			if($entity instanceof ProfileManagerCustomFieldCategory){
				$vars["entity"] = $entity;
			}
		}
	}
	
	echo elgg_view("forms/profile_manager/category", $vars);