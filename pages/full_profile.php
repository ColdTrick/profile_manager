<?php 
	/**
	* Profile Manager
	* 
	* Full Profile view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	global $CONFIG;
	
	$profile_guid = get_input("profile_guid");
	
	if($profile_guid){
		$entity = get_entity($profile_guid);
		
		$title_text = elgg_echo("profile") . ": " . $entity->name;
		$title = elgg_view_title($title_text);	
		$data = elgg_view("profile_manager/profile/full_profile", array("entity" => $entity));
		
		$page_data = $title . $data;
		
		page_draw($title_text, elgg_view_layout("one_column", $page_data));
	} else {
		forward();
	}
?>