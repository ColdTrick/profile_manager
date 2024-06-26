<?php
/**
 * Profile Manager
 *
 * Profile Types add form
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

use ColdTrick\ProfileManager\CustomFieldCategory;

if (!elgg_is_admin_logged_in()) {
	echo elgg_echo('adminrequired');
	return;
}

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof \ColdTrick\ProfileManager\CustomProfileType) {
	$entity = null;
}

$form_title = elgg_echo('profile_manager:profile_types:add');

$metadata_name = null;
$metadata_label = null;
$metadata_label_plural = null;
$metadata_description = null;

$related_categories = [];

if ($entity) {
	$form_title = elgg_echo('profile_manager:profile_types:edit');
	
	$guid = $entity->guid;
	$metadata_name = $entity->metadata_name;
	$metadata_label = $entity->metadata_label;
	$metadata_label_plural = $entity->metadata_label_plural;
	$metadata_description = $entity->metadata_description;
	
	$cats = elgg_get_entities([
		'type' => 'object',
		'subtype' => CustomFieldCategory::SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_site_entity()->guid,
		'relationship' => \ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP,
		'relationship_guid' => $guid,
		'inverse_relationship' => false,
	]);
	
	if ($cats) {
		foreach ($cats as $cat) {
			$related_categories[] = $cat->guid;
		}
	}
}

$formbody = '';

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_name'),
	'name' => 'metadata_name',
	'value' => $metadata_name,
	'required' => true,
]);

$formbody .= elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'text',
			'#label' => elgg_echo('profile_manager:profile_types:edit:metadata_label:singular'),
			'name' => 'metadata_label',
			'value' => $metadata_label,
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('profile_manager:profile_types:edit:metadata_label:plural'),
			'name' => 'metadata_label_plural',
			'value' => $metadata_label_plural,
		],
	]
]);

$formbody .= elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('description'),
	'name' => 'metadata_description',
	'value' => $metadata_description,
]);
	
$categories = elgg_get_entities([
	'type' => 'object',
	'subtype' => CustomFieldCategory::SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
]);

if (!empty($categories)) {
	$checkbox_options = [];
	
	foreach ($categories as $cat) {
		$checkbox_options[$cat->getDisplayName()] = $cat->guid;
	}
	
	$formbody .= elgg_view_field([
		'#type' => 'checkboxes',
		'#label' => elgg_echo('profile_manager:profile_types:edit:related_categories'),
		'name' => 'categories',
		'options' => $checkbox_options,
		'value' => $related_categories,
	]);
}

$formbody .= elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $guid,
]);
$formbody .= elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('save'),
]);

$form = elgg_view('input/form', [
	'body' => $formbody,
	'action' => 'action/profile_manager/profile_types/add',
]);

$form_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_type',
	'text' => elgg_echo('profile_manager:tooltips:profile_type'),
]);

echo elgg_view_module('info', $form_title, $form, ['class' => 'mvn', 'id' => 'custom_fields_profile_type_form']);
