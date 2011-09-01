<?php
	
	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	echo "<div>";
	echo elgg_echo("profile_noindex:usersettings:hide_from_search_engine");
	echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[hide_from_search_engine]", "options_values" => $noyes_options, "value" => $plugin->hide_from_search_engine));
	echo "<div class='profile_noindex_explain'>" . elgg_echo("profile_noindex:usersettings:hide_from_search_engine:explain") . "</div>";
	echo "</div>";