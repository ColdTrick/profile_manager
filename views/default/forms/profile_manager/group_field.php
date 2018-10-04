<?php
	/**
* Profile Manager
*
* Group Fields add form
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
if (!($entity instanceof \ColdTrick\ProfileManager\CustomGroupField)) {
	$entity = null;
}

$form_title = elgg_echo('profile_manager:group_fields:add');
$formbody = '';

$options_values = [];
$option_classes = [];

$types = profile_manager_get_custom_field_types('custom_group_field_types');
if ($types) {
	foreach ($types as $type) {
		$options_values[$type->type] = $type->name;
		foreach ($type->options as $option_name => $option_value) {
			if ($option_value) {
				$option_classes[$option_name] .= ' field_option_enable_' . $type->type;
			}
		}
	}
}

$metadata_name = null;
$metadata_label = null;
$metadata_hint = null;
$metadata_placeholder = null;
$metadata_type = null;
$metadata_options = null;
$show_on_profile = null;
$output_as_tags = null;
$blank_available = null;
$admin_only = null;

if ($entity) {
	
	$form_title = elgg_echo('profile_manager:group_fields:edit');
	
	$guid = $entity->guid;
	$metadata_name = $entity->metadata_name;
	$metadata_label = $entity->metadata_label;
	$metadata_hint = $entity->metadata_hint;
	$metadata_placeholder = $entity->metadata_placeholder;
	$metadata_type = $entity->metadata_type;
	$metadata_options = $entity->metadata_options;
	
	$show_on_profile = $entity->show_on_profile;
	$output_as_tags = $entity->output_as_tags;
	$blank_available = $entity->blank_available;
	$admin_only = $entity->admin_only;
	
	if (!array_key_exists($metadata_type, $options_values)) {
		$options_values[$metadata_type] = $metadata_type;
	}
}

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_name'),
	'name' => 'metadata_name',
	'value' => $metadata_name,
	'required' => true,
]);

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_label'),
	'name' => 'metadata_label',
	'value' => $metadata_label,
]);

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_hint'),
	'name' => 'metadata_hint',
	'value' => $metadata_hint,
]);

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_placeholder'),
	'name' => 'metadata_placeholder',
	'value' => $metadata_placeholder,
]);

$formbody .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:admin:field_type'),
	'name' => 'metadata_type',
	'options_values' => $options_values,
	'value' => $metadata_type,
	'onchange' => 'elgg.profile_manager.change_field_type();',
]);

$formbody .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('profile_manager:admin:metadata_options'),
	'name' => 'metadata_options',
	'value' => $metadata_options,
]);

$options_content = '';

$options = [
	'show_on_profile',
	'output_as_tags',
	'admin_only',
	'blank_available',
];
foreach ($options as $option) {
	$class = 'custom_fields_form_field_option'. elgg_extract($option, $option_classes, '');
	
	$checked = ($$option === 'yes');
	if (in_array($option, ['show_on_profile'])) {
		$checked = ($$option !== 'no');
	}
	
	$options_content .= elgg_view_field([
		'#type' => 'checkbox',
		'#label' => elgg_echo("profile_manager:admin:{$option}"),
		'#help' => elgg_echo("profile_manager:admin:{$option}:description"),
		'name' => $option,
		'class' => $class,
		'checked' => $checked,
		'switch' => true,
		'default' => 'no',
		'value' => 'yes',
	]);
}

$options_title = elgg_echo('profile_manager:admin:additional_options');
$options_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_field_additional',
	'text' => elgg_echo('profile_manager:tooltips:profile_field_additional'),
]);

$formbody .= elgg_view_module('info', $options_title, $options_content);

$formbody .= elgg_view('input/hidden', ['name' => 'type', 'value' => 'group']);
$formbody .= elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);
$formbody .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

$form = elgg_view('input/form', ['body' => $formbody, 'action' => 'action/profile_manager/new']);

echo elgg_view_module('info', $form_title, $form, ['class' => 'mvn', 'id' => 'custom_fields_form']);
