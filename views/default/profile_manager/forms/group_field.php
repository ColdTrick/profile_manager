<?php

use ColdTrick\ProfileManager\CustomGroupField;

elgg_ajax_gatekeeper();
elgg_admin_gatekeeper();

$guid = get_input('guid');
if ($guid) {
	$entity = get_entity($guid);
	if (!$entity instanceof CustomGroupField) {
		return;
	}
	$vars['entity'] = $entity;
	$form_title = elgg_echo('profile_manager:group_fields:edit');
} else {
	$form_title = elgg_echo('profile_manager:group_fields:add');
}

$form = elgg_view_form('profile_manager/group_field', [
	'action' => 'action/profile_manager/new',
], $vars);

echo elgg_view_module('inline', $form_title, $form, [
	'class' => 'mvn',
	'id' => 'custom_fields_form',
]);