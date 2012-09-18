<?php 
	/**
	* Profile Manager
	* 
	* jQuery Profile Field change category
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$guid = get_input("guid");
	$category_guid = get_input("category_guid");

	if(!empty($guid)){
		$entity = get_entity($guid);
		if($entity->getSubtype() == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $entity->getSubtype() == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
			if(!empty($category_guid)){
				$entity->category_guid = $category_guid;
			} else {
				unset($entity->category_guid);
			}
			echo "true";	
			
			// trigger memcache update
			$entity->save();	
		}
	}

	exit();