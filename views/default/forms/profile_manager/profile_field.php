<?php
/**
* Profile Manager
*
* Profile Field add form
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
if (!($entity instanceof \ColdTrick\ProfileManager\CustomField)) {
	$entity = null;
}

$form_title = elgg_echo('profile_manager:profile_fields:add');

$options_values = [];
$option_classes = [];

$types = profile_manager_get_custom_field_types('custom_profile_field_types');
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
$metadata_input_label = null;
$metadata_hint = null;
$metadata_placeholder = null;
$metadata_type = null;
$metadata_options = null;

$show_on_register = null;
$mandatory = null;
$user_editable = null;
$output_as_tags = null;
$blank_available = null;
$admin_only = null;

if ($entity) {
	
	$form_title = elgg_echo('profile_manager:profile_fields:edit');
	
	$guid = $entity->guid;
	$metadata_name = $entity->metadata_name;
	$metadata_label = $entity->metadata_label;
	$metadata_input_label = $entity->metadata_input_label;
	$metadata_hint = $entity->metadata_hint;
	$metadata_placeholder = $entity->metadata_placeholder;
	$metadata_type = $entity->metadata_type;
	$metadata_options = $entity->metadata_options;
	
	$show_on_register = $entity->show_on_register;
	$mandatory = $entity->mandatory;
	$user_editable = $entity->user_editable;
	$output_as_tags = $entity->output_as_tags;
	$blank_available = $entity->blank_available;
	$admin_only = $entity->admin_only;
	
	if (!array_key_exists($metadata_type, $options_values)) {
		$options_values[$metadata_type] = $metadata_type;
	}
}

$yes_no_options = ['yes' => elgg_echo('option:yes'),'no' => elgg_echo('option:no')];
$no_yes_options = array_reverse($yes_no_options);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_name',
	'value' => $metadata_name,
	'required' => true,
	'label' => elgg_echo('profile_manager:admin:metadata_name'),
]);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_label',
	'value' => $metadata_label,
	'label' => elgg_echo('profile_manager:admin:metadata_label'),
]);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_input_label',
	'value' => $metadata_input_label,
	'label' => elgg_echo('profile_manager:admin:metadata_input_label'),
	'help' => elgg_echo('profile_manager:admin:metadata_input_label:help'),
]);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_hint',
	'value' => $metadata_hint,
	'label' => elgg_echo('profile_manager:admin:metadata_hint'),
]);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_placeholder',
	'value' => $metadata_placeholder,
	'label' => elgg_echo('profile_manager:admin:metadata_placeholder'),
]);

$formbody .= elgg_view_input('select', [
	'name' => 'metadata_type',
	'options_values' => $options_values,
	'value' => $metadata_type,
	'label' => elgg_echo('profile_manager:admin:field_type'),
	'onchange' => 'elgg.profile_manager.change_field_type();',
]);

$formbody .= elgg_view_input('text', [
	'name' => 'metadata_options',
	'value' => $metadata_options,
	'label' => elgg_echo('profile_manager:admin:metadata_options'),
]);

$options_table = '';

$options = ['show_on_register', 'mandatory', 'user_editable', 'output_as_tags', 'blank_available', 'admin_only'];
foreach ($options as $option) {
	$class = elgg_extract($option, $option_classes, '');
	
	$options_table .= '<tr>';
	$options_table .= '<td>' . elgg_echo("profile_manager:admin:{$option}") . ':</td>';
	$options_table .= '<td>';
	$options_table .=  elgg_view('input/dropdown', [
		'name' => $option,
		'options_values' => $no_yes_options ,
		'value' => $$option,
		'class' => 'mhs custom_fields_form_field_option' . $class,
	]);
	$options_table .= '</td>';
	$options_table .= elgg_format_element('td', [], elgg_echo("profile_manager:admin:{$option}:description"));
	$options_table .= '</tr>';
}

$options_table = elgg_format_element('table', [], $options_table);

$options_title = elgg_echo('profile_manager:admin:additional_options');
$options_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_field_additional',
	'text' => elgg_echo('profile_manager:tooltips:profile_field_additional'),
]);

$formbody .= elgg_view_module('inline', $options_title, $options_table);

$formbody .= elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);
$formbody .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

$form = elgg_view('input/form', ['body' => $formbody, 'action' => 'action/profile_manager/new']);

$form_title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_field',
	'text' => elgg_echo('profile_manager:tooltips:profile_field'),
]);

echo elgg_view_module('inline', $form_title, $form, ['class' => 'mvn', 'id' => 'custom_fields_form']);

echo elgg_format_element('script', [], 'elgg.profile_manager.change_field_type();');
