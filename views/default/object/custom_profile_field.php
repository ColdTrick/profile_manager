<?php 
	/**
	* Profile Manager
	* 
	* Object view of a custom profile field
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	$info .= "<div onclick='$(\"#" . $vars['entity']->guid . "\").toggle();' class='custom_field_handle'></div>";
	$info .= "<div>";
	
	$info .= "<div class='metadata_config_left'><b>" . $vars['entity']->metadata_name . "</b> [" . $vars['entity']->metadata_type . "] <a href='#' onclick='editField(" . $vars['entity']->guid . ");return false;'>" . elgg_echo("edit") . "</a> | <a href='#' onclick='removeField(" . $vars['entity']->guid . ");return false;'>" . elgg_echo("delete") . "</a><br />";
	$info .= "<div id='" . $vars['entity']->guid . "' class='metadata_config_left_extra'>";
	
	// label information
	if(!empty($vars['entity']->metadata_label)){
		$info .= elgg_echo("profile_manager:admin:metadata_label") . ": " . $vars['entity']->metadata_label . "<br />";
	} else {
		if(elgg_echo("profile:" . $vars['entity']->metadata_name) == "profile:" . $vars['entity']->metadata_name){
			$info .= elgg_echo("profile_manager:admin:metadata_label_untranslated") . ": <i>" . elgg_echo("profile:" . $vars['entity']->metadata_name) . "</i><br />";
		} else {
			$info .= elgg_echo("profile_manager:admin:metadata_label_translated") . ": " . elgg_echo("profile:" . $vars['entity']->metadata_name) . "<br />";
		}
	}
	
	// options
	if(!empty($vars['entity']->metadata_options)){
		$info .= elgg_echo("profile_manager:admin:metadata_options") . ": " . $vars['entity']->metadata_options . "<br />";
	}
	
	// Hint
	if(!empty($vars['entity']->metadata_hint)){
		$info .= elgg_echo("profile_manager:admin:metadata_hint") . ": " . $vars['entity']->metadata_hint . "<br />";
	}
	
	$info .= "</div>";
	$info .= "</div>";
	 
	$info .= "<div class='metadata_config_right'>";
	
	// show_on_register
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "show_on_register"));	
	
	// mandatory
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "mandatory"));
	
	// user_editable
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "user_editable"));
	
	// output_as_tags
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "output_as_tags"));
	
	// admin_only
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "admin_only"));
	$info .= "|";
	// simple_search
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "simple_search"));

	// advanced_search
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "advanced_search"));
	
	// profile completeness
	if(elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes"){
		$info .= "|";
		$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "count_for_completeness"));
	}
	
	$info .= "</div>";		
	$info .= "</div>";		
	$info .= "<div class='clearfloat'></div>";
	
	echo "<div id='custom_profile_field_" . $vars['entity']->guid . "' class='custom_field' rel='" . $vars['entity']->category_guid . "'>"  . $info . "</div>";
	