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

	$form_title = elgg_echo('profile_manager:group_fields:add');
	
	if($vars["entity"]){
		
		$form_title = elgg_echo('profile_manager:group_fields:edit');
		
		$guid = $vars["entity"]->guid;
		$metadata_name = $vars["entity"]->metadata_name;
		$metadata_label = $vars["entity"]->metadata_label;
		$metadata_hint = $vars["entity"]->metadata_hint;
		$metadata_type = $vars["entity"]->metadata_type;
		$metadata_options = $vars["entity"]->metadata_options;
		
		$output_as_tags = $vars["entity"]->output_as_tags;
		$blank_available = $vars["entity"]->blank_available;
		$admin_only = $vars["entity"]->admin_only;
	}	

	$options_values = array();
	
	if($types = get_custom_field_types("custom_group_field_types")){
		foreach($types as $type){
			$options_values[$type->type] = $type->name; 
		}
	}
	
	$no_yes_options = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

	$type_control = elgg_view('input/dropdown', array('name' => 'metadata_type', 'options_values' => $options_values, "value" => $metadata_type));
	
	$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":" . elgg_view('input/text', array('name' => 'metadata_name', "value" => $metadata_name));
	$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:" . elgg_view('input/text', array('name' => 'metadata_label', "value" => $metadata_label));
	$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . "*:" . elgg_view('input/text', array('name' => 'metadata_hint', "value" => $metadata_hint));
	$formbody .= elgg_echo('profile_manager:admin:field_type') . ": " . $type_control;
	$formbody .= "<div>" . elgg_echo('profile_manager:admin:metadata_options') . "*:" . elgg_view('input/text', array('name' => 'metadata_options', "value" => $metadata_options)) . "</div>";

	$formbody .= "<div class='elgg-module elgg-module-inline'><div class='elgg-head'><h3>" . elgg_echo("profile_manager:admin:additional_options") . "</h3></div><div class='elgg-body'>";
	
	$formbody .= "<table>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:output_as_tags') . ":</td><td>" . elgg_view('input/dropdown', array('name' => 'output_as_tags', 'options_values' => $no_yes_options, 'value' => $output_as_tags)) . "</td></tr>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:admin_only') . ":</td><td>" . elgg_view('input/dropdown', array('name' => 'admin_only', 'options_values' => $no_yes_options, 'value' => $admin_only)) . "</td></tr>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:blank_available') . ":</td><td>" . elgg_view('input/dropdown', array('name' => 'blank_available', 'options_values' => $no_yes_options, 'value' => $blank_available)) . "</td></tr>";
	$formbody .= "</table></div></div>";
	
	$formbody .= "<br />";
	
	$formbody .= elgg_view("input/hidden", array("name" => "type", "value" => "group"));
	$formbody .= elgg_view('input/hidden', array('name' => 'guid', "value" => $guid));
	$formbody .= elgg_view('input/submit', array('value' => elgg_echo('save')));
	
	$form = elgg_view('input/form', array('body' => $formbody, 'action' => $vars['url'] . 'action/profile_manager/new'));
		
?>
<div class="elgg-module elgg-module-inline" id="custom_fields_form">
	<div class="elgg-head">
		<h3>
			<?php echo $form_title; ?>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form; ?>
	</div>
</div>