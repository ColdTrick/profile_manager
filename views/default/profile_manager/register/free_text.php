<?php 

	if($free_text = get_plugin_setting("registration_free_text", "profile_manager")){
		echo elgg_view("output/longtext", array("value" => $free_text));
	}
?>