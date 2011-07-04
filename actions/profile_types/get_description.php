<?php
	/**
	* Profile Manager
	* 
	* jQuery Profile Type description retrieval
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	admin_gatekeeper();
	
	$guid = get_input("guid");
	
	if(!empty($guid)){
		$entity = get_entity($guid);
		echo $entity->metadata_description;
	} 
	
	exit();
?>