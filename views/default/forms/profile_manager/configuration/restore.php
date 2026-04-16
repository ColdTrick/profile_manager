<?php

echo elgg_view('output/longtext', ['value' => elgg_echo('profile_manager:actions:configuration:restore:description')]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'fieldtype',
	'value' => elgg_extract('fieldtype', $vars),
]);

echo elgg_view_field([
	'#type' => 'file',
	'name' => 'restoreFile',
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('profile_manager:actions:configuration:restore:upload'),
]);

elgg_set_form_footer($footer);
