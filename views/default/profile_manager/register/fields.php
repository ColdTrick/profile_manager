<?php
/**
* Profile Manager
*
* Extended registerpage view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$field_location = $vars["field_location"];
$field_location_setting = elgg_get_plugin_setting("registration_extra_fields", "profile_manager");
if ($field_location == "beside") {
	if ($field_location_setting !== "beside") {
		// beside should be beside
		return true;
	}
} elseif ($field_location_setting == "beside") {
	// below or default
	return true;
}

$profile_icon = elgg_get_plugin_setting("profile_icon_on_register", "profile_manager");
$profile_type_selection = elgg_get_plugin_setting("profile_type_selection", "profile_manager");

$tabbed = false;
if (elgg_get_plugin_setting("edit_profile_mode", "profile_manager") == "tabbed") {
	$tabbed = true;
}

$result = "";

// mandatory profile icon
if ($profile_icon == "yes" || $profile_icon == "optional") {
	$result .= elgg_view("input/profile_icon");
}

$categorized_fields = profile_manager_get_categorized_fields(null, true, true);
$fields = $categorized_fields['fields'];
$cats = $categorized_fields['categories'];

if (elgg_is_sticky_form('profile_manager_register')) {
	$sticky_values = elgg_get_sticky_values('profile_manager_register');
	extract($sticky_values);
	elgg_clear_sticky_form('profile_manager_register');
}
	
if ($profile_type_selection != "admin") {
	$types_options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"limit" => 0,
			"owner_guid" => elgg_get_site_entity()->getGUID()
		);
	$types = elgg_get_entities($types_options);
	
	if ($types) {
		
		$types_options_values = array();
		if (elgg_get_plugin_setting("hide_profile_type_default", "profile_manager") !== "yes") {
			$types_options_values[""] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
		}
		
		// Generate type descriptions for all profile types
		$types_description = "";
		foreach ($types as $type) {
			$types_options_values[$type->guid] = $type->getTitle();
			
			// preparing descriptions of profile types
			$description = $type->getDescription();
			
			if (!empty($description)) {
				$types_description .= "<div id='" . $type->guid . "' class='custom_profile_type_description'>";
				$types_description .= $description;
				$types_description .= "</div>";
			}
		}
		
		if (empty($custom_profile_fields_custom_profile_type)) {
			$custom_profile_fields_custom_profile_type = elgg_get_plugin_setting("default_profile_type", "profile_manager");
		}
		
		$types_result = "<div>";
		$types_result .= "<label>" . elgg_echo("profile_manager:profile:edit:custom_profile_type:label") . "</label><br />";
		$types_result .= elgg_view("input/dropdown", array(
										"name" => "custom_profile_fields_custom_profile_type",
										"id" => "custom_profile_fields_custom_profile_type",
										"options_values" => $types_options_values,
										"onchange" => "elgg.profile_manager.change_profile_type_register();",
										"value" => $custom_profile_fields_custom_profile_type)
									);
		
		$types_result .= $types_description;
		$types_result .= "</div>";
		
		$result .= $types_result;
	}
}

if (count($fields) > 0) {
	$tabbed_cat_titles = "";
	$tabbed_cat_content = "";
	
	foreach ($cats as $cat_guid => $cat) {
		
		$linked_profile_types = array(0);
		if ($cat instanceof ProfileManagerCustomFieldCategory) {
			$linked_profile_types = $cat->getLinkedProfileTypes();
		}
		
		$fields_result = "";
		foreach ($fields[$cat_guid] as $field) {
			$metadata_type = $field->metadata_type;
			if ($metadata_type == "longtext") {
				// bug when showing tinymce on register page (when moving) newer versions of tinymce are working correctly
				$metadata_type = "plaintext";
			}
			
			$sticky_name = "custom_profile_fields_" . $field->metadata_name;
			
			$value = "";
			if (isset($$sticky_name)) {
				$value = $$sticky_name;
			}
			
			if (is_array($value)) {
				$value = implode(", ", $value);
			}
			$class = "";
			if ($field->mandatory == "yes") {
				$class = " class='mandatory'";
			}
			
			$fields_result .= "<div" . $class . ">";
			$fields_result .= "<label>" . $field->getTitle() . "</label>";
			
			if ($hint = $field->getHint()) {
				$fields_result .= "<span class='custom_fields_more_info' id='more_info_" . $field->metadata_name . "'></span>";
				$fields_result .= "<span class='hidden' id='text_more_info_" . $field->metadata_name . "'>" . $hint . "</span>";
			}
			
			$fields_result .= "<br />";
			
			$fields_result .= elgg_view("input/{$metadata_type}", array(
													"name" => "custom_profile_fields_" . $field->metadata_name,
													"value" => $value,
													"options" => $field->getOptions(),
													"placeholder" => $field->getPlaceholder()
													));
			$fields_result .= "</div>";
		}
		
		$class = "category_" . $cat_guid;
		foreach ($linked_profile_types as $type_guid) {
			$class .= " profile_type_" . $type_guid;
		}
		$cat_result = "<div class='profile_manager_register_category elgg-module elgg-module-info " . $class . "'>";
			
		if (count($cats) > 1) {
			// make nice title
			if ($cat_guid == 0) {
				$title = elgg_echo("profile_manager:categories:list:default");
			} else {
				$title = $cat->getTitle();
			}
			if ($tabbed) {
				$tabbed_cat_titles .= "<li class='" . $class . "'><a href='javascript:void(0);' onclick='elgg.profile_manager.toggle_tabbed_nav(\"" . $cat_guid . "\", this);'>" . $title . "</a></li>";
			} else {
				$cat_result .= "<div class='elgg-head'>";
				$cat_result .= "<h3>" . $title . "</h3>";
				$cat_result .= "</div>";
			}
		}
		
		$cat_result .= "<div class='elgg-body'><fieldset>" . $fields_result . "</fieldset></div>";
		$cat_result .= "</div>";
		
		if ($tabbed) {
			$tabbed_cat_content .= $cat_result;
		} else {
			$result .= $cat_result;
		}
	}
	if ($tabbed) {
		if ($tabbed_cat_titles) {
			
			$result .= "<ul class='elgg-tabs elgg-htabs' id='profile_manager_register_tabbed'>";
			$result .= $tabbed_cat_titles;
			$result .= "</ul>";
			
			$result .= "<div>";
			$result .= $tabbed_cat_content;
			$result .= "</div>";
		} else {
			$result .= $tabbed_cat_content;
		}
	}
}

if (!empty($result)) {
	echo "<fieldset>" . $result . "</fieldset>";
}
