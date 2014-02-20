<?php

$config = elgg_view("profile_manager/user_summary_control/configuration");
$preview = elgg_view("profile_manager/user_summary_control/preview");

$page_data = $config . $preview;

echo elgg_view("profile_manager/admin/tabs", array("user_summary_control_selected" => true));
echo $page_data;
