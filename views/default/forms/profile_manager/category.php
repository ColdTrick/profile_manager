<?php
/**
* Profile Manager
*
* Category add form
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

if (!elgg_is_admin_logged_in()) {
	echo elgg_echo('adminrequired');
	return;
}
$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!($entity instanceof \ColdTrick\ProfileManager\CustomFieldCategory)) {
	$entity = null;
}

$form_title = elgg_echo('profile_manager:categories:add');

$metadata_name = null;
$metadata_label = null;
$related_types = [];

if ($entity) {
	
	$form_title = elgg_echo('profile_manager:categories:edit');
	
	$guid = $entity->guid;
	$metadata_name = $entity->metadata_name;
	$metadata_label = $entity->metadata_label;
	
	$types = elgg_get_entities_from_relationship([
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID(),
		"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
		"relationship_guid" => $guid,
		"inverse_relationship" => true,
	]);
	
	if ($types) {
		foreach ($types as $type) {
			$related_types[] = $type->guid;
		}
	}
}

$formbody = "<table class='custom_fields_add_form_table'>";
$formbody .= "<tr>";
$formbody .= "<td class='custom_fields_add_form_table_left'>";
$formbody .= elgg_echo('profile_manager:admin:metadata_name') . "*:";
$formbody .= elgg_view('input/text', [
	'name' => 'metadata_name',
	'value' => $metadata_name,
	'required' => true,
]);
$formbody .= "</td>";
$formbody .= "<td rowspan='2' class='custom_fields_add_form_table_right'>";

$options = [
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->getGUID()
];

$types = elgg_get_entities($options);

if (count($types) > 0) {
	
	$checkbox_options = [];
	
	foreach ($types as $type) {
		$title = $type->getTitle();
		$checkbox_options[$title] = $type->guid;
	}
	
	$formbody .= elgg_view('input/checkboxes', [
		'name' => 'profile_types',
		'options' => $checkbox_options,
		'value' => $related_types,
	]);
} else {
	$formbody .= '&nbsp;';
}

$formbody .= "</td>";
$formbody .= "</tr>";
$formbody .= "<tr>";
$formbody .= "<td>";
$formbody .= elgg_echo('profile_manager:admin:metadata_label') . ":";
$formbody .= elgg_view('input/text', [
	'name' => 'metadata_label',
	'value' => $metadata_label,
]);
$formbody .= "</td>";
$formbody .= "</tr>";
$formbody .= "</table>";

$formbody .= elgg_view('input/hidden', [
	'name' => 'guid',
	'value' => $guid,
]);
$formbody .= elgg_view('input/submit', [
	'name' => elgg_echo('save'),
	'value' => elgg_echo('save'),
]);

$form = elgg_view('input/form', [
	'body' => $formbody,
	'action' => 'action/profile_manager/categories/add',
]);

$form_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_category',
	'text' => elgg_echo('profile_manager:tooltips:category'),
]);

echo elgg_view_module('inline', $form_title, $form, ['class' => 'mvn', 'id' => 'custom_fields_category_form']);
