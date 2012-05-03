<?php

$value = elgg_extract("value", $vars);
unset($vars["value"]);

$spacers = array("new_line", "space", "dash");

$field_selector = "<select " . elgg_format_attributes($vars) . " class='elgg-input-dropdown profile-manager-user-summary-config-options'>";

$field_selector .= "<option></option>";

if($profile_fields = elgg_get_config("profile_fields")){
	$field_options = array();

	foreach($profile_fields as $metadata_name => $type){
		$label = $metadata_name;

		$translation_key = "profile:" . $metadata_name;
		$translated_label = elgg_echo($translation_key);

		if($translated_label !== $translation_key){
			$label = $translated_label;
		}
		$field_options[$metadata_name] = $label;
	}

	ksort($field_options);

	$field_selector .= "<optgroup label='" . elgg_echo("profile_manager:profile_fields:list:title") . "'>";
	foreach($field_options as $name => $label){
		$selected = "";
		if($name == $value){
			$selected = " selected='selected'";
		}
		$field_selector .= "<option value='" . $name . "'" . $selected . ">" . $label . "</option>";
	}
	$field_selector .= "</optgroup>";
}

$field_selector .= "<optgroup label='" . elgg_echo("profile_manager:user_summary_control:options:spacers") . "'>";
foreach($spacers as $spacer){
	$selected = "";
	if("spacer_" . $spacer == $value){
		$selected = " selected='selected'";
	}
	$field_selector .= "<option value='spacer_" . $spacer . "'" . $selected . ">" . elgg_echo("profile_manager:user_summary_control:options:spacers:" . $spacer) . "</option>";
}
$field_selector .= "</optgroup>";

$field_selector .= "<option class='profile-manager-user-summary-config-options-delete'>" . elgg_echo("delete") . "</option>";

$field_selector .= "</select>";

echo $field_selector;
