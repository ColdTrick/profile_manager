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
	$handle = "<div onclick='$(\"#" . $vars['entity']->guid . "\").toggle();' class='custom_field_handle'></div>";
	
	$title = "<div class='field_config_title'>";
	$title .= "<b>" . $vars['entity']->metadata_name . "</b> [" . $vars['entity']->metadata_type . "]";
	$title .= "<a href='" . $vars["url"] . "profile_manager/forms/profile_field/" . $vars['entity']->guid  . "' class='profile-manager-popup'><span class='elgg-icon elgg-icon-settings-alt' title='" . elgg_echo("edit") . "'></span></a>";
	$title .= "<span class='elgg-icon elgg-icon-delete' title='" . elgg_echo("delete") . "' onclick='removeField(" . $vars['entity']->guid . ");'></span>";
	$title .= "</div>";
	
	$extra_info = "<div id='" . $vars['entity']->guid . "' class='field_config_extra'>";
	
	// label information
	if(!empty($vars['entity']->metadata_label)){
		$extra_info .= elgg_echo("profile_manager:admin:metadata_label") . ": " . $vars['entity']->metadata_label . "<br />";
	} else {
		if(elgg_echo("profile:" . $vars['entity']->metadata_name) == "profile:" . $vars['entity']->metadata_name){
			$extra_info .= elgg_echo("profile_manager:admin:metadata_label_untranslated") . ": <i>" . elgg_echo("profile:" . $vars['entity']->metadata_name) . "</i><br />";
		} else {
			$extra_info .= elgg_echo("profile_manager:admin:metadata_label_translated") . ": " . elgg_echo("profile:" . $vars['entity']->metadata_name) . "<br />";
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
	
	$metadata = "<div class='field_config_metadata'>";
	
	// show_on_register
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "show_on_register"));	
	
	// mandatory
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "mandatory"));
	
	// user_editable
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "user_editable"));
	
	// output_as_tags
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "output_as_tags"));
	
	// admin_only
	$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "admin_only"));
	
	// profile completeness
	if(elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes"){
		$metadata .= "|";
		$metadata .= elgg_view("profile_manager/toggle_metadata", array("entity" => $vars['entity'], "metadata_name" => "count_for_completeness"));
	}
	
	$metadata .= "</div>";
			
	$info = $handle . $metadata . $title . $extra_info; 		
	
	echo "<div id='custom_profile_field_" . $vars['entity']->guid . "' class='custom_field' rel='" . $vars['entity']->category_guid . "'>"  . $info . "</div>";
	