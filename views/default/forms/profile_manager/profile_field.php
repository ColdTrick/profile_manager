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

$guid = get_input('guid');

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

$type_control = elgg_view('input/dropdown', [
	'name' => 'metadata_type',
	'options_values' => $options_values,
	'onchange' => 'elgg.profile_manager.change_field_type();',
	'value' => $metadata_type,
]);

$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ':' . elgg_view('input/text', ['name' => 'metadata_name', 'value' => $metadata_name]);
$formbody .= elgg_echo('profile_manager:admin:metadata_label') . '*:' . elgg_view('input/text', ['name' => 'metadata_label', 'value' => $metadata_label]);
$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . '*:' . elgg_view('input/text', ['name' => 'metadata_hint', 'value' => $metadata_hint]);
$formbody .= elgg_echo('profile_manager:admin:metadata_placeholder') . '*:' . elgg_view('input/text', ['name' => 'metadata_placeholder', 'value' => $metadata_placeholder]);
$formbody .= elgg_echo('profile_manager:admin:field_type') . ': ' . $type_control;
$formbody .= '<br />' . elgg_echo('profile_manager:admin:metadata_options') . '*:' . elgg_view('input/text', ['name' => 'metadata_options', 'value' => $metadata_options]);

$hint = elgg_view('output/pm_hint', [
	'id' => 'more_info_profile_field_additional',
	'text' => elgg_echo('profile_manager:tooltips:profile_field_additional'),
]);

$formbody .= "<div class='elgg-module elgg-module-inline'><div class='elgg-head'><h3>" . elgg_echo("profile_manager:admin:additional_options") . $hint . "</h3></div><div class='elgg-body'>";
$formbody .= "<table>";

$class = elgg_extract('show_on_register', $option_classes, '');

$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:show_on_register') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'show_on_register', 'options_values' => $no_yes_options , 'value' => $show_on_register, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:show_on_register:description') . "</td>";
$formbody .= "</tr>";

$class = elgg_extract('mandatory', $option_classes, '');

$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:mandatory') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'mandatory', 'options_values' => $no_yes_options, 'value' => $mandatory, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:mandatory:description') . "</td>";
$formbody .= "</tr>";

$class = elgg_extract('user_editable', $option_classes, '');
	
$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:user_editable') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'user_editable', 'options_values' => $yes_no_options, 'value' => $user_editable, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:user_editable:description') . "</td>";
$formbody .= "</tr>";

$class = elgg_extract('output_as_tags', $option_classes, '');
	
$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'output_as_tags', 'options_values' => $no_yes_options, 'value' => $output_as_tags, 'class' => 'custom_fields_form_field_option field_option_enable_text' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags:description') . "</td>";
$formbody .= "</tr>";

$class = elgg_extract('blank_available', $option_classes, '');

$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'blank_available', 'options_values' => $no_yes_options, 'value' => $blank_available, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available:description') . "</td>";
$formbody .= "</tr>";

$class = elgg_extract('admin_only', $option_classes, '');

$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'admin_only', 'options_values' => $no_yes_options, 'value' => $admin_only, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only:description') . "</td>";
$formbody .= "</tr>";

$formbody .= "</table></div></div>";

$formbody .= elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);
$formbody .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

$form = elgg_view('input/form', ['body' => $formbody, 'action' => 'action/profile_manager/new']);

?>
<div class="elgg-module elgg-module-inline mvn" id="custom_fields_form">
	<div class="elgg-head">
		<h3>
			<?php
			echo $form_title;
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_profile_field',
				'text' => elgg_echo('profile_manager:tooltips:profile_field'),
			]);
			?>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form; ?>
	</div>
</div>
<script type="text/javascript">
elgg.profile_manager.change_field_type();
</script>