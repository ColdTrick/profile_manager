<?php
/**
 * Object view of a custom profile field
 */

$field = elgg_extract('entity', $vars);
if (!$field instanceof \ColdTrick\ProfileManager\CustomProfileField) {
	return;
}

$title = '<strong>' . $field->metadata_name . '</strong> [' . $field->metadata_type . ']';

$title .= elgg_view('output/url', [
	'href' => elgg_http_add_url_query_elements('ajax/view/forms/profile_manager/profile_field', [
		'guid' => $field->guid,
	]),
	'class' => ['elgg-lightbox', 'mls'],
	'title' => elgg_echo('edit'),
	'text' => false,
	'icon' => 'settings-alt',
]);

$title .= elgg_view('output/url', [
	'href' => false,
	'class' => ['profile-manager-remove-field', 'mls'],
	'data-guid' => $field->guid,
	'title' => elgg_echo('delete'),
	'text' => false,
	'icon' => 'delete-alt',
]);

$title = elgg_format_element('div', [], $title);

$metadata = '';

$toggle_options = [
	'show_on_register',
	'mandatory',
	'user_editable',
	'output_as_tags',
	'admin_only',
];

if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') == 'yes') {
	$toggle_options[] = 'count_for_completeness';
}

foreach ($toggle_options as $option) {
	$metadata .= elgg_view('profile_manager/toggle_metadata', [
		'entity' => $field,
		'metadata_name' => $option,
	]);
}

echo elgg_view_image_block('', $title, [
	'id' => "custom_profile_field_{$field->guid}",
	'class' => 'custom_field',
	'rel' => "{$field->category_guid}",
	'title' => $field->getDisplayName(),
	'image_alt' => $metadata,
]);
