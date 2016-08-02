<?php
/**
* Profile Manager
*
* Object view of a custom profile field
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
	'href' => 'ajax/view/forms/profile_manager/profile_field?guid=' . $field->guid,
	'class' => 'elgg-lightbox',
	'data-colorbox-opts' => json_encode([
		'maxHeight' => '90%'
	]),
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

$metadata = '';

$toggle_options = ['show_on_register', 'mandatory', 'user_editable', 'output_as_tags', 'admin_only'];

if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') == 'yes') {
	$toggle_options[] = 'count_for_completeness';
}

foreach ($toggle_options as $option) {
	$metadata .= elgg_view('profile_manager/toggle_metadata', ['entity' => $field, 'metadata_name' => $option]);
}

$metadata = elgg_format_element('div', ['class' => 'float-alt'], $metadata);
		
echo elgg_format_element('div', [
	'id' => "custom_profile_field_{$field->guid}",
	'class' => 'custom_field',
	'rel' => "{$field->category_guid}",
	'title' => elgg_echo("profile:{$field->metadata_name}"),
], $metadata . $title);
	