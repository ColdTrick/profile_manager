<?php

$title = elgg_echo("preview");

$body = "<iframe scroll='auto' id='profile-manager-user-summary-preview' src='" . elgg_get_site_url() . "profile_manager/user_summary_control'></iframe>";

echo elgg_view_module("inline", $title, $body);