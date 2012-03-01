<?php

	$settings_selected = elgg_extract("settings_selected", $vars, false);
	$profile_fields_selected = elgg_extract("profile_fields_selected", $vars, false);
	$group_fields_selected = elgg_extract("group_fields_selected", $vars, false);

	$tabs = array (array("text" => elgg_echo("admin:appearance:profile_fields"), "href" => "admin/appearance/profile_fields", "selected" => $profile_fields_selected));
	
	if(elgg_is_active_plugin("groups")){
		$tabs[] = array("text" => elgg_echo("admin:appearance:group_fields"), "href" => "admin/appearance/group_fields", "selected" => $group_fields_selected); 
	}
			
	$tabs[] = array("text" => elgg_echo("settings"), "href" => "admin/plugin_settings/profile_manager", "selected" => $settings_selected);

	echo elgg_view("navigation/tabs", array("tabs" => $tabs));