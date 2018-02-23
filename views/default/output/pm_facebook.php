<?php
$href = elgg_extract('value', $vars);

if (empty($href)) {
	return;
}

$vars['class'] = elgg_extract('class', $vars, 'profile-manager-output-facebook');

echo elgg_view('output/url', $vars);
