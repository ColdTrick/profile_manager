<?php 
	/**
	* Profile Manager
	* 
	* Object view of a custom group field
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
		if(elgg_echo("groups:" . $vars['entity']->metadata_name) == "groups:" . $vars['entity']->metadata_name){
			$info .= elgg_echo("profile_manager:admin:metadata_label_untranslated") . ": <i>" . elgg_echo("groups:" . $vars['entity']->metadata_name) . "</i><br />";
		} else {
			$info .= elgg_echo("profile_manager:admin:metadata_label_translated") . ": " . elgg_echo("groups:" . $vars['entity']->metadata_name) . "<br />";
		}
	}
	
	// options
	if(!empty($vars['entity']->metadata_options)){
		$info .= elgg_echo("profile_manager:admin:metadata_options") . ": " . $vars['entity']->metadata_options . "<br />";
	}
	
	// hint
	if(!empty($vars['entity']->metadata_hint)){
		$info .= elgg_echo("profile_manager:admin:metadata_hint") . ": " . $vars['entity']->metadata_hint . "<br />";
	}
	
	$info .= "</div>";
	$info .= "</div>";

	// set default display values
	if(empty($vars['entity']->user_editable)) $vars['entity']->user_editable = "yes";
	if(empty($vars['entity']->output_as_tags)) $vars['entity']->output_as_tags = "no";
	 
	$info .= "<div class='metadata_config_right'>";
	
	// output_as_tags
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "output_as_tags"));
	
	// admin_only
	$info .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "admin_only"));
	
	$info .= "</div>";	
	$info .= "</div>";
	$info .= "<div class='clearfloat'></div>";
	
	echo "<div id='custom_profile_field_" . $vars['entity']->guid . "' class='custom_field' rel=''>"  . $info . "</div>";