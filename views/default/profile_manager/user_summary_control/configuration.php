<?php

$user = elgg_get_logged_in_user_entity();

$current_config = elgg_get_plugin_setting("user_summary_config", "profile_manager");
if (!empty($current_config)) {
	$current_config = json_decode($current_config, true);
}

$title = elgg_echo("profile_manager:user_summary_control:config");

$add_icon = "<span class='elgg-icon elgg-icon-profile-manager-user-summary-config-add' title='" . elgg_echo("add") . "'></span>";

$form_body = "<span class='elgg-subtext'>" . elgg_echo("profile_manager:user_summary_control:info") . "</span>";

$form_body .= elgg_view("input/pm_user_summary_selector", array("id" => "profile-manager-user-summary-config-options"));;

$form_body .= "<table class='profile-manager-user-summary-config'>";
$form_body .= "<tr><td class='profile-manager-user-summary-config-name'>" . $user->name . "</td>";
$form_body .= "<td class='profile-manager-user-summary-config-container' rel='config_title'>";

if (is_array($current_config) && array_key_exists("title", $current_config)) {
	foreach ($current_config["title"] as $field) {
		$form_body .= elgg_view("input/pm_user_summary_selector", array("value" => $field, "name" => "config_title[]"));
	}
}

$form_body .= $add_icon . " <span class='profile-manager-user-summary-config-container-info'>" . elgg_echo("profile_manager:user_summary_control:container:title") . "</span>";

$form_body .= "</td>";
$form_body .= "<td class='profile-manager-user-summary-config-container' rel='config_entity_menu'>";

if (is_array($current_config) && array_key_exists("entity_menu", $current_config)) {
	foreach ($current_config["entity_menu"] as $field) {
		$form_body .= elgg_view("input/pm_user_summary_selector", array("value" => $field, "name" => "config_entity_menu[]"));
	}
}

$form_body .= $add_icon . " <span class='profile-manager-user-summary-config-container-info'>" . elgg_echo("profile_manager:user_summary_control:container:entity_menu") . "</span>";
$form_body .= "</td>";
$form_body .= "</tr>";

$form_body .= "<tr><td class='profile-manager-user-summary-config-container' rel='config_subtitle' colspan='3'>";

if (is_array($current_config) && array_key_exists("subtitle", $current_config)) {
	foreach ($current_config["subtitle"] as $field) {
		$form_body .= elgg_view("input/pm_user_summary_selector", array("value" => $field, "name" => "config_subtitle[]"));
	}
}

$form_body .= $add_icon . " <span class='profile-manager-user-summary-config-container-info'>" . elgg_echo("profile_manager:user_summary_control:container:subtitle") . "</span>";
$form_body .= "</td></tr>";

$form_body .= "<tr><td class='profile-manager-user-summary-config-container' rel='config_content' colspan='3'>";

if (is_array($current_config) && array_key_exists("content", $current_config)) {
	foreach ($current_config["content"] as $field) {
		$form_body .= elgg_view("input/pm_user_summary_selector", array("value" => $field, "name" => "config_content[]"));
	}
}

$form_body .= $add_icon . " <span class='profile-manager-user-summary-config-container-info'>" . elgg_echo("profile_manager:user_summary_control:container:content") . "</span>";
$form_body .= "</td></tr>";

$form_body .= "</table>";

$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));

$body = elgg_view("input/form", array("body" => $form_body, "action" => "action/profile_manager/user_summary_control/save"));

echo elgg_view_module("inline", $title, $body);
