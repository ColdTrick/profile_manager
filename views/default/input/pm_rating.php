<?php

elgg_require_js("profile_manager/rating");

$selected_value = sanitise_int($vars['value'], false);

$rating_id = $vars["name"] . "_container";

echo "<div class='profile-manager-input-pm-rating' id='" . $rating_id . "'>";
echo elgg_view("input/hidden", $vars);
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		echo elgg_view_icon("star-alt", "link");
	} else {
		echo elgg_view_icon("star-empty","link");
	}
}

echo " " . elgg_view("output/url", array("text" => elgg_echo("reset"), "href" => "#"));;
echo "</div>";
