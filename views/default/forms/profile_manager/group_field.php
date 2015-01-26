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

if ($guid = get_input("guid")) {
	if ($entity = get_entity($guid)) {
		if ($entity instanceof ProfileManagerCustomGroupField) {
			$vars["entity"] = $entity;
		}
	}
}

$form_title = elgg_echo('profile_manager:group_fields:add');

$options_values = array();
$option_classes = array();

$types = profile_manager_get_custom_field_types("custom_profile_field_types");
if ($types) {
	foreach ($types as $type) {
		$options_values[$type->type] = $type->name;
		foreach ($type->options as $option_name => $option_value) {
			if ($option_value) {
				$option_classes[$option_name] .= " field_option_enable_" . $type->type;
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

if ($vars["entity"]) {
	
	$form_title = elgg_echo('profile_manager:group_fields:edit');
	
	$guid = $vars["entity"]->guid;
	$metadata_name = $vars["entity"]->metadata_name;
	$metadata_label = $vars["entity"]->metadata_label;
	$metadata_hint = $vars["entity"]->metadata_hint;
	$metadata_placeholder = $vars["entity"]->metadata_placeholder;
	$metadata_type = $vars["entity"]->metadata_type;
	$metadata_options = $vars["entity"]->metadata_options;
	
	$output_as_tags = $vars["entity"]->output_as_tags;
	$blank_available = $vars["entity"]->blank_available;
	$admin_only = $vars["entity"]->admin_only;
	
	if (!array_key_exists($metadata_type, $options_values)) {
		$options_values[$metadata_type] = $metadata_type;
	}
}

$no_yes_options = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

$type_control = elgg_view('input/dropdown', array('name' => 'metadata_type', 'options_values' => $options_values, 'onchange' => 'elgg.profile_manager.change_field_type();', "value" => $metadata_type));

$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":" . elgg_view('input/text', array('name' => 'metadata_name', "value" => $metadata_name));
$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:" . elgg_view('input/text', array('name' => 'metadata_label', "value" => $metadata_label));
$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . "*:" . elgg_view('input/text', array('name' => 'metadata_hint', "value" => $metadata_hint));
$formbody .= elgg_echo('profile_manager:admin:metadata_placeholder') . "*:" . elgg_view('input/text', array('name' => 'metadata_placeholder', "value" => $metadata_placeholder));
$formbody .= elgg_echo('profile_manager:admin:field_type') . ": " . $type_control;
$formbody .= "<div>" . elgg_echo('profile_manager:admin:metadata_options') . "*:" . elgg_view('input/text', array('name' => 'metadata_options', "value" => $metadata_options)) . "</div>";

$formbody .= "<div class='elgg-module elgg-module-inline'><div class='elgg-head'><h3>" . elgg_echo("profile_manager:admin:additional_options") . "</h3></div><div class='elgg-body'>";

$formbody .= "<table>";

if (array_key_exists("output_as_tags", $option_classes)) {
	$class = $option_classes['output_as_tags'];
} else {
	$class = "";
}
$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'output_as_tags', 'options_values' => $no_yes_options, 'value' => $output_as_tags, 'class' => 'custom_fields_form_field_option field_option_enable_text' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags:description') . "</td>";
$formbody .= "</tr>";

if (array_key_exists("admin_only", $option_classes)) {
	$class = $option_classes['admin_only'];
} else {
	$class = "";
}
$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'admin_only', 'options_values' => $no_yes_options, 'value' => $admin_only, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only:description') . "</td>";
$formbody .= "</tr>";

if (array_key_exists("blank_available", $option_classes)) {
	$class = $option_classes['blank_available'];
} else {
	$class = "";
}
$formbody .= "<tr>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available') . ":</td>";
$formbody .= "<td>" . elgg_view('input/dropdown', array('name' => 'blank_available', 'options_values' => $no_yes_options, 'value' => $blank_available, 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available:description') . "</td>";
$formbody .= "</tr>";

$formbody .= "</table></div></div>";

$formbody .= "<br />";

$formbody .= elgg_view("input/hidden", array("name" => "type", "value" => "group"));
$formbody .= elgg_view('input/hidden', array('name' => 'guid', "value" => $guid));
$formbody .= elgg_view('input/submit', array('value' => elgg_echo('save')));

$form = elgg_view('input/form', array('body' => $formbody, 'action' => 'action/profile_manager/new'));
		
?>
<div class="elgg-module elgg-module-inline mvn" id="custom_fields_form">
	<div class="elgg-head">
		<h3>
			<?php echo $form_title; ?>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form; ?>
	</div>
</div>