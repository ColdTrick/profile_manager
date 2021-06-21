<?php

$selected_value = (int) $vars['value'];

$stars = '';
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		$stars .= elgg_view_icon('star');
	} else {
		$stars .= elgg_view_icon('star-regular');
	}
}

echo elgg_format_element('div', [], $stars);
