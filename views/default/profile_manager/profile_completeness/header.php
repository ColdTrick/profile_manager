<?php

$entity = elgg_get_logged_in_user_entity();
if ($entity) {
	$profile_completeness_setting = elgg_get_plugin_setting("enable_profile_completeness", "profile_manager");
	
	if (elgg_in_context("profile")) {
		echo elgg_view("profile_manager/profile_completeness/content", array("entity" => elgg_get_page_owner_entity(), "hide_when_complete" => true));
	} elseif ($profile_completeness_setting == "header_all") {
		echo elgg_view("profile_manager/profile_completeness/content", array("entity" => $entity, "hide_when_complete" => true));
	}
}
