<?php

$selected_value = sanitise_int($vars['value'], false);

$stars = '';
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		$stars .= elgg_view_icon('star-alt');
	} else {
		$stars .= elgg_view_icon('star-empty');
	}
}

echo elgg_format_element('div', [], $stars);
