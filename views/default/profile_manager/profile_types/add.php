<?php 
	/**
	* Profile Manager
	* 
	* Profile Types add form 
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	global $CONFIG;

	$formbody = "<table class='custom_fields_add_form_table'>\n";
	$formbody .= "<tr>\n";
	$formbody .= "<td class='custom_fields_add_form_table_left'>\n"; 
	$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":";
	$formbody .= elgg_view('input/text', array('internalname' => 'metadata_name'));
	
	$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:";
	$formbody .= elgg_view('input/text', array('internalname' => 'metadata_label'));
	
	$formbody .= elgg_echo('profile_manager:admin:metadata_description') . "*:";
	$formbody .= elgg_view('input/plaintext', array('internalname' => 'metadata_description'));
	
	$formbody .= elgg_echo('profile_manager:admin:show_on_members') . "*:";
	$formbody .= elgg_view('input/pulldown', array('internalname' => 'show_on_members',
													"options_values" => array("no" => elgg_echo("option:no"),
																				"yes" => elgg_echo("option:yes"))));
			
	$formbody .= "</td>\n";
	$formbody .= "<td class='custom_fields_add_form_table_right'>\n"; 
	
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid
		);
	
	$category_count = elgg_get_entities($options);
	
	if($category_count > 0){
		$options["limit"] = $category_count;
		$options["count"] = false;
		
		$categories = elgg_get_entities($options);
		
		$checkbox_options = array();
		
		foreach($categories as $cat){
			$title = $cat->getTitle();
			
			$checkbox_options[$title] = $cat->guid;
		}
		
		$formbody .= elgg_view("input/checkboxes", array("internalname" => "categories", "options" => $checkbox_options));
	} else {
		$formbody .= "&nbsp;";
	}
	
	$formbody .= "</td>\n";
	$formbody .= "</tr>\n";
	$formbody .= "</table>\n";
	
	$formbody .= elgg_view("input/hidden", array("internalname" => "guid"));
	$formbody .= elgg_view('input/submit', array('internalname' => elgg_echo('save'), 'value' => elgg_echo('save')));
	$formbody .= elgg_view('input/reset', array('internalname' => elgg_echo('cancel'), 
												'value' => elgg_echo('cancel'),
												'js' => "onClick='resetProfileTypeForm();'",
												'class' => "elgg-button-cancel"));
	$formbody .= elgg_view('input/button', array('internalname' => elgg_echo('delete'),
												'class' => "submit_button custom_fields_profile_type_delete_button", 
												'value' => elgg_echo('delete'),
												'type' => "button",
												'js' => "onClick='deleteProfileType();'",
												'class' => "elgg-button-action"));
	
	$form = elgg_view('input/form', array('body' => $formbody, 
										'action' => $vars['url'] . 'action/profile_manager/profile_types/add')
									);

?>
<div class="custom_fields_forms">
	<div class="elgg-module elgg-module-inline" id="custom_fields_profile_type_form">
		<div class="elgg-head">
			<h3>
				<?php echo elgg_echo('profile_manager:profile_types:add:link'); ?>
				<span class='custom_fields_more_info' id='more_info_profile_type'></span>
			</h3>
		</div>
		<div class="elgg-body">
			<?php echo $form; ?>
		</div>
	</div>
</div>