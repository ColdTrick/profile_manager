<?php

$selected_value = sanitise_int($vars['value'], false);

echo "<div>";
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		echo elgg_view_icon("star-alt");
	} else {
		echo elgg_view_icon("star-empty");
	}
}
echo "</div>";
