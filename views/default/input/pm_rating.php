<?php

elgg_require_js("profile_manager/rating");

$selected_value = sanitise_int($vars['value'], false);

$rating_id = $vars["name"] . "_container";


$body = elgg_view("input/hidden", $vars);
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		$body .= elgg_view_icon("star-alt", "link");
	} else {
		$body .= elgg_view_icon("star-empty","link");
	}
}

$body .= " " . elgg_view("output/url", array("text" => elgg_echo("reset"), "href" => "#"));;

echo elgg_format_element('div', ['class' => 'profile-manager-input-pm-rating', 'id' => $rating_id], $body);
