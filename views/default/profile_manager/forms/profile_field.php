<?php

use ColdTrick\ProfileManager\CustomProfileField;

elgg_ajax_gatekeeper();
elgg_admin_gatekeeper();

$guid = get_input('guid');
if ($guid) {
	$entity = get_entity($guid);
	if (!$entity instanceof CustomProfileField) {
		return;
	}
	$vars['entity'] = $entity;
	$form_title = elgg_echo('profile_manager:profile_fields:edit');
} else {
	$form_title = elgg_echo('profile_manager:profile_fields:add');
}

$form_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_field',
	'text' => elgg_echo('profile_manager:tooltips:profile_field'),
]);

$form = elgg_view_form('profile_manager/profile_field', [
	'action' => 'action/profile_manager/new',
], $vars);

echo elgg_view_module('inline', $form_title, $form, [
	'class' => 'mvn',
	'id' => 'custom_fields_form',
]);