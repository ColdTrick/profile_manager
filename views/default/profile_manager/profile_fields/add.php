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

	$options_values = array();
	$option_classes = array();
	
	// TODO: make a new system for these options as the register functions are deprecated
	
	if($types = get_register("custom_profile_field_types")){
		foreach($types as $type){
			$options_values[$type->name] = $type->value;
			foreach($type->children as $option_name => $option_value){
				if($option_value){
					$option_classes[$option_name] .= " field_option_enable_". $type->name;
				} 
			}
		}
	}
	
	$yes_no_options = array('yes' => elgg_echo('option:yes'),'no' => elgg_echo('option:no'));

	$type_control = elgg_view('input/pulldown', array('internalname' => 'metadata_type', 'options_values' => $options_values, 'js' => 'onchange="changeFieldType();"'));
	$formbody .= elgg_view('input/hidden', array('internalname' => 'guid'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":" . elgg_view('input/text', array('internalname' => 'metadata_name'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_label'));
	$formbody .= elgg_echo('profile_manager:admin:metadata_hint') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_hint'));
	$formbody .= elgg_echo('profile_manager:admin:field_type') . ": " . $type_control;
	$formbody .= "<br />" . elgg_echo('profile_manager:admin:metadata_options') . "*:" . elgg_view('input/text', array('internalname' => 'metadata_options'));

	$formbody .= "<br /><br /><h3>" . elgg_echo("profile_manager:admin:additional_options") . "<span class='custom_fields_more_info' id='more_info_profile_field_additional'></span></h3>";
	$formbody .= "<table>";	
	
	if(array_key_exists("show_on_register", $option_classes)){
		$class = $option_classes['show_on_register'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:show_on_register') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'show_on_register', 'options_values' => $yes_no_options , 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:show_on_register:description') . "</td>";
	$formbody .= "</tr>";

	if(array_key_exists("mandatory", $option_classes)){
		$class = $option_classes['mandatory'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:mandatory') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'mandatory', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:mandatory:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("user_editable", $option_classes)){
		$class = $option_classes['user_editable'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:user_editable') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'user_editable', 'options_values' => $yes_no_options, 'value'=>'yes', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:user_editable:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("output_as_tags", $option_classes)){
		$class = $option_classes['output_as_tags'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'output_as_tags', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option field_option_enable_text' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:output_as_tags:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("blank_available", $option_classes)){
		$class = $option_classes['blank_available'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'blank_available', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:blank_available:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("admin_only", $option_classes)){
		$class = $option_classes['admin_only'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'admin_only', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:admin_only:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("simple_search", $option_classes)){
		$class = $option_classes['simple_search'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:simple_search') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'simple_search', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:simple_search:description') . "</td>";
	$formbody .= "</tr>";
	
	if(array_key_exists("advanced_search", $option_classes)){
		$class = $option_classes['advanced_search'];	
	} else {
		$class = "";
	}
	$formbody .= "<tr>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:advanced_search') . ":</td>";
	$formbody .= "<td>" . elgg_view('input/pulldown', array('internalname' => 'advanced_search', 'options_values' => $yes_no_options, 'value'=>'no', 'class' => 'custom_fields_form_field_option' . $class)) . "</td>";
	$formbody .= "<td>" . elgg_echo('profile_manager:admin:advanced_search:description') . "</td>";
	$formbody .= "</tr>";
	
	$formbody .= "</table>";
	
	$formbody .= elgg_view('input/submit', array('internalname' => elgg_echo('save'), 'value' => elgg_echo('save')));
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
			<h3><?php echo elgg_echo('profile_manager:profile_fields:add:link'); ?><span class='custom_fields_more_info' id='more_info_profile_field'></span></h3>
		</div>
		<div class="elgg-body">
			<?php echo $form; ?>
		</div>
	</div>
</div>