<?php

$fieldtype = $vars["fieldtype"];

$fields = false;

if ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) {
	$fields = elgg_get_config("profile_fields");
} elseif ($fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE) {
	$fields = elgg_get_config("group");
}

if ($fields) {

	echo elgg_view("input/hidden", array(
		"name" => "fieldtype",
		"value" => $fieldtype
	));
	
	echo "<table class='mbl'>";
	if ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) {

		$default_fields = array(
			"guid" => 0,
			"username" => 0,
			"name" => 0,
			"email" => 0,
			"time_created" => 0,
			"time_updated" => 0,
			"last_login" => 0,
			"last_action" => 0,
			"validated" => 0,
			"validated_method" => 0
		);
		$fields = $default_fields + $fields;
	}

	if ($fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE) {

		$default_fields = array(
			"guid" => 0,
			"name" => 0
		);
		$fields = $default_fields + $fields;
	}

	foreach ($fields as $metadata_name => $type) {
		echo "<tr>";
		echo "<td>" . $metadata_name . "</td>";
		echo "<td class='plm'>";
		echo elgg_view("input/checkbox", array(
			"name" => "export[" . $metadata_name . "]",
			"value" => $metadata_name,
			"default" => false
		));
		echo "</tr>";
	}
	
	echo "</table>";
	
	if (elgg_is_active_plugin("groups") && ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE)) {
		echo "<div class='mbl'>";
		echo elgg_view("input/checkbox", array("name" => "include_group_membership"));
		echo " " . elgg_echo("profile_manager:export:list:include_group_membership");
		echo "</div>";
	}
	
	// buttons
	echo elgg_view("input/submit", array("value" => elgg_echo("export")));
} else {
	echo elgg_echo("profile_manager:export:nofields");
}