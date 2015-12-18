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

$guid = get_input('guid');

$entity = get_entity($guid);
if (!($entity instanceof \ColdTrick\ProfileManager\CustomGroupField)) {
	$entity = null;
}

$form_title = elgg_echo('profile_manager:group_fields:add');

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
$metadata_hint = null;
$metadata_placeholder = null;
$metadata_type = null;
$metadata_options = null;
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
	
	$output_as_tags = $entity->output_as_tags;
	$blank_available = $entity->blank_available;
	$admin_only = $entity->admin_only;
	
	if (!array_key_exists($metadata_type, $options_values)) {
		$options_values[$metadata_type] = $metadata_type;
	}
}

$no_yes_options = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

$formbody .= elgg_echo('profile_manager:admin:metadata_name') . '*:' . elgg_view('input/text', ['name' => 'metadata_name', 'value' => $metadata_name, 'required' => true]);
$formbody .= elgg_echo('profile_manager:admin:metadata_label') . ':' . elgg_view('input/text', ['name' => 'metadata_label', 'value' => $metadata_label]);
$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . ':' . elgg_view('input/text', ['name' => 'metadata_hint', 'value' => $metadata_hint]);
$formbody .= elgg_echo('profile_manager:admin:metadata_placeholder') . ':' . elgg_view('input/text', ['name' => 'metadata_placeholder', 'value' => $metadata_placeholder]);
$formbody .= elgg_echo('profile_manager:admin:field_type') . ': ' . elgg_view('input/dropdown', [
	'name' => 'metadata_type',
	'options_values' => $options_values,
	'onchange' => 'elgg.profile_manager.change_field_type();',
	'value' => $metadata_type,
]);
$formbody .= '<div>' . elgg_echo('profile_manager:admin:metadata_options') . ':' . elgg_view('input/text', ['name' => 'metadata_options', 'value' => $metadata_options]) . '</div>';

$options_table = '';

$options = ['output_as_tags', 'admin_only', 'blank_available'];
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

$formbody .= elgg_view_module('inline', $options_title, $options_table);

$formbody .= '<br />';

$formbody .= elgg_view('input/hidden', ['name' => 'type', 'value' => 'group']);
$formbody .= elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);
$formbody .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

$form = elgg_view('input/form', ['body' => $formbody, 'action' => 'action/profile_manager/new']);

echo elgg_view_module('inline', $form_title, $form, ['class' => 'mvn', 'id' => 'custom_fields_form']);
