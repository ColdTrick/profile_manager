<?php

use ColdTrick\ProfileManager\CustomField;
use ColdTrick\ProfileManager\DefaultProfileType;

$entity = elgg_extract('entity', $vars);
$profile_type_guid = (int) elgg_extract('profile_type', $vars, $entity->custom_profile_type);
$profile_type = get_entity($profile_type_guid);
if (!$profile_type) {
	$profile_type = new DefaultProfileType();
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'custom_profile_type',
	'value' => $profile_type->guid,
]);

echo elgg_view_field([
	'name' => 'accesslevel[custom_profile_type]',
	'value' => ACCESS_PUBLIC,
]);

$categorized_fields = profile_manager_get_categorized_fields($entity, true, false, true, $profile_type_guid);
$categories = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$edit_profile_mode = elgg_get_plugin_setting('edit_profile_mode', 'profile_manager');
$simple_access_control = elgg_get_plugin_setting('simple_access_control', 'profile_manager');
$default_access_id = get_default_access($entity);

$tabs = [];

foreach ($categories as $category_guid => $category) {

	if (empty($fields[$category_guid])) {
		continue;
	}
	$category_title = $category->getTitle();
	$category_view = '';

	foreach ($fields[$category_guid] as $field) {
		/* @var $field CustomField */

		if ($simple_access_control == 'yes' && !isset($simple_default_access_id)) {
			$metadata = elgg_get_metadata([
				'guid' => $entity->guid,
				'metadata_name' => $metadata_name,
				'limit' => 1,
			]);
			if ($metadata) {
				$metadata = $metadata[0];
				$simple_default_access_id = $metadata->access_id;
			} else {
				$simple_default_access_id = get_default_access($entity);
			}
		}

		$category_view .= elgg_view('profile_manager/field/input', [
			'field' => $field,
			'category' => $category,
			'entity' => $entity,
			'access' => $simple_access_control == 'yes' ? 'hidden' : 'access',
		]);
	}

	$tabs[] = [
		'text' => $category_title,
		'content' => $category_view,
	];
}

if (empty($tabs)) {
	return;
}

$description = $profile_type->getDescription();
if ($description) {
	echo elgg_view('output/longtext', [
		'value' => $description,
		'class' => 'profile-manager-profile-type-description',
	]);
}

if ($simple_access_control == 'yes') {
	echo elgg_view_field([
		'#type' => 'access',
		'#label' => elgg_echo('profile_manager:simple_access_control'),
		'value' => $simple_default_access_id,
		'#class' => 'profile-manager-simple-access-control',
	]);
}

if ($edit_profile_mode == 'tabbed' && count($tabs) > 1) {
	$tabs[0]['selected'] = true;
	echo elgg_view('page/components/tabs', [
		'tabs' => $tabs,
		'class' => 'profile-manager-tabs',
	]);
} else {
	foreach ($tabs as $tab) {
		$title = count($tabs) > 1 ? $tab['text'] : null;
		echo elgg_view_module('info', $title, $tab['content'], [
			'class' => 'profile-manager-profile-edit-module',
		]);
	}
}
