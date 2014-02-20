<?php

if ($free_text = elgg_get_plugin_setting("registration_free_text", "profile_manager")) {
	echo elgg_view("output/longtext", array("value" => $free_text));
}