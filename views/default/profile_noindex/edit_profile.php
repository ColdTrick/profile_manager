<?php
	
	echo elgg_view("usersettings/plugins_opt/plugin", array("plugin" => "profile_noindex", "details" => array("user_guid" => page_owner())));