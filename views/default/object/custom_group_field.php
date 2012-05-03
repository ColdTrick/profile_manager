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

	$handle = "<div onclick='$(\"#" . $vars['entity']->guid . "\").toggle();' class='custom_field_handle'></div>";

	$title = "<div class='field_config_title'>";
	$title .= "<b>" . $vars['entity']->metadata_name . "</b> [" . $vars['entity']->metadata_type . "]";
	$title .= "<a href='" . $vars["url"] . "profile_manager/forms/group_field/" . $vars['entity']->guid  . "' class='profile-manager-popup'><span class='elgg-icon elgg-icon-settings-alt' title='" . elgg_echo("edit") . "'></span></a>";
	$title .= "<span class='elgg-icon elgg-icon-delete' title='" . elgg_echo("delete") . "' onclick='removeField(" . $vars['entity']->guid . ");'></span>";
	$title .= "</div>";
	
	$extra_info = "<div id='" . $vars['entity']->guid . "' class='field_config_extra'>";
	
	// label information
	if(!empty($vars['entity']->metadata_label)){
		$extra_info .= elgg_echo("profile_manager:admin:metadata_label") . ": " . $vars['entity']->metadata_label . "<br />";
	} else {
		if(elgg_echo("profile:" . $vars['entity']->metadata_name) == "groups:" . $vars['entity']->metadata_name){
			$extra_info .= elgg_echo("profile_manager:admin:metadata_label_untranslated") . ": <i>" . elgg_echo("groups:" . $vars['entity']->metadata_name) . "</i><br />";
		} else {
			$extra_info .= elgg_echo("profile_manager:admin:metadata_label_translated") . ": " . elgg_echo("groups:" . $vars['entity']->metadata_name) . "<br />";
		}
	}
	
	// options
	if(!empty($vars['entity']->metadata_options)){
		$extra_info .= elgg_echo("profile_manager:admin:metadata_options") . ": " . $vars['entity']->metadata_options . "<br />";
	}
	
	// Hint
	if(!empty($vars['entity']->metadata_hint)){
		$extra_info .= elgg_echo("profile_manager:admin:metadata_hint") . ": " . $vars['entity']->metadata_hint . "<br />";
	}
	
	$extra_info .= "</div>";
		
	// set default display values
	if(empty($vars['entity']->user_editable)) $vars['entity']->user_editable = "yes";
	if(empty($vars['entity']->output_as_tags)) $vars['entity']->output_as_tags = "no";
	
	$metadata = "<div class='field_config_metadata'>";
	
	// output_as_tags
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "output_as_tags"));
	
	// admin_only
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "admin_only"));
		
	$metadata .= "</div>";
	
	
	
	$info = $handle . $metadata . $title . $extra_info;
	
	echo "<div id='custom_profile_field_" . $vars['entity']->guid . "' class='custom_field' rel=''>"  . $info . "</div>";
	