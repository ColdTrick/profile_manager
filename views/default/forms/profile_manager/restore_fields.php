<?php

$fieldtype = elgg_extract('fieldtype', $vars);

$form_body = elgg_view('output/longtext', ['value' => elgg_echo('profile_manager:actions:configuration:restore:description')]);
$form_body .= elgg_view_field([
	'#type' => 'file',
	'name' => 'restoreFile',
]);
$form_body .= elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('profile_manager:actions:configuration:restore:upload'),
]);

echo elgg_view('input/form', [
	'action' => 'action/profile_manager/configuration/restore?fieldtype=' . $fieldtype,
	'id' => 'restoreForm',
	'enctype' => 'multipart/form-data',
	'body' => $form_body,
]);
