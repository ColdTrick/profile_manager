<?php

// must accept terms
$accept_terms = elgg_get_plugin_setting("registration_terms", "profile_manager");
if ($accept_terms) {
	$link_begin = "<a target='_blank' href='" . $accept_terms . "'>";
	$link_end = "</a>";
	
	$label = elgg_echo("profile_manager:registration:accept_terms", array($link_begin, $link_end));

	$terms = "<div class='mandatory mbm'>";
	$terms .= elgg_view("input/checkbox", array(
		"id" => "register-accept_terms",
		"name" => "accept_terms",
		"value" => "yes",
		"default" => false
	));
	$terms .= "<label for='register-accept_terms'>" . $label . "</label>";
	$terms .= "</div>";
	
	echo $terms;
}