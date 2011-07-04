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
	$formbody .= "<br />" . elgg_echo('profile_manager:admin:metadata_options') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_options'));

	$formbody .= "<h3 class='settings'>" . elgg_echo("profile_manager:admin:additional_options") . "</h3>";
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
												'js' => "onClick='resetProfileFieldsForm();'"));
	
	$form = elgg_view('input/form', array('body' => $formbody, 
										'action' => $vars['url'] . 'action/profile_manager/new')
									);	
?>
<div class="contentWrapper">
	<div>
		<?php echo elgg_echo("profile_manager:group_fields:add:description"); ?>
		<br />
		<?php echo elgg_view("input/button", array("type" => "button", "value" => elgg_echo("profile_manager:group_fields:add:link"), "js" => "onclick=\"toggleForm('custom_fields_form');\""));?>
	</div>
	<div id="custom_fields_form">
		<?php echo $form; ?>
	</div>
</div>