<?php
/**
 * User summary
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity metadata and actions (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (optional)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

if ((elgg_get_plugin_setting("user_summary_control", "profile_manager") == "yes") && !$vars["entity"]->isBanned() && !elgg_in_context("admin")) {
	
	$current_config = elgg_get_plugin_setting("user_summary_config", "profile_manager");
	if (!empty($current_config)) {
		$current_config = json_decode($current_config, true);
	}
	
	$profile_fields = elgg_get_config("profile_fields");
	
	if (!empty($current_config) && is_array($current_config) && !empty($profile_fields)) {
		$config_positions = array("title", "subtitle", "content"); // entity_menu is handled in a hook
		
		foreach ($config_positions as $position) {
			if ($position !== "title") {
				$vars[$position] = "";
			}
			
			if (array_key_exists($position, $current_config)) {
				$fields = $current_config[$position];
				$spacer_allowed = true;
				$spacer_result = "";
				
				foreach ($fields as $field) {
					$field_result = "";
					
					switch ($field) {
						case "spacer_dash":
							if ($spacer_allowed) {
								$spacer_result = " - ";
							}
							$spacer_allowed = false;
							break;
						case "spacer_space":
							if ($spacer_allowed) {
								$spacer_result = " ";
							}
							$spacer_allowed = false;
							break;
						case "spacer_new_line":
							$spacer_allowed = true;
							$field_result = "<br />";
							break;
						default:
							$value = $vars["entity"]->$field;
							if (!empty($value)) {
								if (array_key_exists($field, $profile_fields)) {
									$spacer_allowed = true;
									$field_result = elgg_view("output/" . $profile_fields[$field], array("value" => $value));
								}
							}
							break;
					}
					
					if (!empty($field_result)) {
						$vars[$position] .= $spacer_result . $field_result;
					}
				}
			}
		}
	}
}

echo elgg_view('object/elements/summary', $vars);
