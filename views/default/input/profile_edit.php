<?php

$name = elgg_extract('name', $vars);

$access_id = elgg_extract('pm_access_id', $vars);
unset($vars['pm_access_id']);

$input_type = elgg_extract('pm_type', $vars);
unset($vars['pm_type']);

echo elgg_view("input/$input_type", $vars);

echo '<div>' . elgg_view('input/access', [
	'name' => 'accesslevel[' . $name . ']',
	'value' => $access_id,
]) . '</div>';
