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

	elgg_load_js('lightbox');
	elgg_load_css('lightbox');

	$options_values = array();
	if($types = get_register("custom_group_field_types")){
		foreach($types as $type){
			$options_values[$type->name] = $type->value; 
		}
	}

	$type_control = elgg_view('input/pulldown', array('internalname' => 'metadata_type', 'options_values' => $options_values));
	
	$formbody .= elgg_view('input/hidden', array('internalname' => 'guid'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":" . elgg_view('input/text', array('internalname' => 'metadata_name'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_label'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_hint'));
	$formbody .= elgg_echo('profile_manager:admin:field_type') . ": " . $type_control;
	$formbody .= "<div>" . elgg_echo('profile_manager:admin:metadata_options') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_options')) . "</div>";

	$formbody .= "<h3>" . elgg_echo("profile_manager:admin:additional_options") . "</h3>";
	$formbody .= "<table>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:output_as_tags') . ":</td><td>" . elgg_view('input/pulldown', array('internalname' => 'output_as_tags', 'options_values' => array('yes' => elgg_echo('option:yes'),'no' => elgg_echo('option:no')), 'value'=>'no')) . "</td></tr>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:admin_only') . ":</td><td>" . elgg_view('input/pulldown', array('internalname' => 'admin_only', 'options_values' => array('yes' => elgg_echo('option:yes'),'no' => elgg_echo('option:no')), 'value'=>'no')) . "</td></tr>";
	$formbody .= "<tr><td>" . elgg_echo('profile_manager:admin:blank_available') . ":</td><td>" . elgg_view('input/pulldown', array('internalname' => 'blank_available', 'options_values' => array('yes' => elgg_echo('option:yes'),'no' => elgg_echo('option:no')), 'value'=>'no')) . "</td></tr>";
	$formbody .= "</table>";
	
	$formbody .= "<br />";
	$formbody .= elgg_view("input/hidden", array("internalname" => "type", "value" => "group"));
	$formbody .= elgg_view('input/submit', array('internalname' => elgg_echo('save'), 'value' => elgg_echo('save')));
	
	$formbody .= "&nbsp;";
	$formbody .= elgg_view('input/reset', array('internalname' => elgg_echo('cancel'), 
												'value' => elgg_echo('cancel'),
												'js' => "onClick='resetProfileFieldsForm();'",
												'class' => "elgg-button-cancel"));
	
	$form = elgg_view('input/form', array('body' => $formbody, 
										'action' => $vars['url'] . 'action/profile_manager/new')
									);	
?>
<div class="custom_fields_forms">
	<div class="elgg-module elgg-module-inline" id="custom_fields_form">
		<div class="elgg-head">
			<h3><?php echo elgg_echo('profile_manager:group_fields:add:link'); ?></h3>
		</div>
		<div class="elgg-body">
			<?php echo $form; ?>
		</div>
	</div>
</div>