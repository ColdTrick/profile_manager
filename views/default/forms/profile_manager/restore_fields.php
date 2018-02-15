<?php

$fieldtype = elgg_extract('fieldtype', $vars);

$form_body = elgg_view('output/longtext', ['value' => elgg_echo('profile_manager:actions:configuration:restore:description')]);
$form_body .= elgg_view_field([
	'#type' => 'file',
	'name' => 'restoreFile',
]);
$form_body .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('profile_manager:actions:configuration:restore:upload'),
]);

echo elgg_view('input/form', [
	'action' => 'action/profile_manager/configuration/restore?fieldtype=' . $fieldtype,
	'id' => 'restoreForm',
	'body' => $form_body,
	'enctype' => 'multipart/form-data',
]);
