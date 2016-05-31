<?php
/**
* Profile Manager
*
* Object view of a custom group field
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

elgg_load_js('lightbox');
elgg_load_css('lightbox');
	
$field = elgg_extract('entity', $vars);

$title = '<b>' . $field->metadata_name . '</b> [' . $field->metadata_type . ']';
$title .= elgg_view('output/url', [
	'href' => 'ajax/view/forms/profile_manager/group_field?guid=' . $field->guid,
	'class' => 'elgg-lightbox',
	'title' => elgg_echo('edit'),
	'text' => elgg_view_icon('settings-alt')
		
]);
$title .= elgg_view('output/url', [
	'href' => false,
	'class' => 'profile-manager-remove-field',
	'data-guid' => $field->guid,
	'title' => elgg_echo('delete'),
	'text' => elgg_view_icon('delete-alt'),
]);

$title = elgg_format_element('div', [], $title);

// set default display values
if (empty($field->user_editable)) {
	$field->user_editable = 'yes';
}
if (empty($field->output_as_tags)) {
	$field->output_as_tags = 'no';
}

$metadata = '';

$toggle_options = ['output_as_tags', 'admin_only'];

foreach ($toggle_options as $option) {
	$metadata .= elgg_view('profile_manager/toggle_metadata', ['entity' => $field, 'metadata_name' => $option]);
}

$metadata = elgg_format_element('div', ['class' => 'float-alt'], $metadata);

echo elgg_format_element('div', [
	'id' => "custom_profile_field_{$field->guid}",
	'class' => 'custom_field',
	'rel' => "{$field->category_guid}",
	'title' => "groups:{$field->metadata_name}",
], $metadata . $title);

	