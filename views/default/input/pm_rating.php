<?php

elgg_require_js('input/pm_rating');

$selected_value = (int) elgg_extract('value', $vars);

$rating_id = elgg_extract('name', $vars) . '_container';

$body = elgg_view('input/hidden', $vars);
for ($i = 1; $i <= 5; $i++) {
	if ($i <= $selected_value) {
		$body .= elgg_view_icon('star', ['class' => ['link', 'pm-rating-selected']]);
	} else {
		$body .= elgg_view_icon('star-regular', ['class' => 'link']);
	}
}

$body .= elgg_view('output/url', [
	'text' => elgg_echo('reset'),
	'class' => 'mlm',
	'href' => false,
]);

echo elgg_format_element('div', ['class' => 'profile-manager-input-pm-rating', 'id' => $rating_id], $body);
