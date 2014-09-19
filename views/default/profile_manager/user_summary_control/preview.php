<?php

$title = elgg_echo("preview");

$body = elgg_view("output/iframe", array(
	"scroll" => "auto",
	"id" => "profile-manager-user-summary-preview",
	"src" => "profile_manager/user_summary_control"
));

echo elgg_view_module("inline", $title, $body);
