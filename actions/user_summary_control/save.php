<?php

$config_positions = array("title", "entity_menu", "subtitle", "content");

$new_config = array();

foreach($config_positions as $position){
	$position_input = get_input("config_" . $position, false);
	if(!empty($position_input)){
		foreach($position_input as $field){
			if(!empty($field)){
				$new_config[$position][] = $field;
			}
		}
	}
}

if(!empty($new_config)){
	$config = json_encode($new_config);
	$result = elgg_set_plugin_setting("user_summary_config", $config, "profile_manager");
} else {
	$result = elgg_unset_plugin_setting("user_summary_config", "profile_manager");
}

if($result){
	system_message(elgg_echo("admin:configuration:success"));
} else {
	register_error(elgg_echo("admin:configuration:fail"));
}

forward(REFERER);