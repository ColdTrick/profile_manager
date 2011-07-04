<?php 
	/**
	* Profile Manager
	* 
	* Category add form
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
	$formbody .= "</td>\n";
	$formbody .= "<td rowspan='2' class='custom_fields_add_form_table_right'>\n"; 
	
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid
		);
	
	$type_count = elgg_get_entities($options);
	
	if($type_count > 0){
		$options["count"] = false;
		$options["limit"] = $type_count; 
		
		$types = elgg_get_entities($options);
		
		$checkbox_options = array();
		
		foreach($types as $type){
			$title = $type->getTitle();
			
			$checkbox_options[$title] = $type->guid;
		}
		
		$formbody .= elgg_view("input/checkboxes", array("internalname" => "profile_types", "options" => $checkbox_options));
	} else {
		$formbody .= "&nbsp;";
	}
	
	$formbody .= "</td>\n";
	$formbody .= "</tr>\n";
	$formbody .= "<tr>\n";
	$formbody .= "<td>\n"; 
	$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:";
	$formbody .= elgg_view('input/text', array('internalname' => 'metadata_label'));
	$formbody .= "</td>\n";
	$formbody .= "</tr>\n";
	$formbody .= "</table>\n";
	
	$formbody .= elgg_view("input/hidden", array("internalname" => "guid"));
	$formbody .= elgg_view('input/submit', array('internalname' => elgg_echo('save'), 'value' => elgg_echo('save')));
	$formbody .= "&nbsp;";
	$formbody .= elgg_view('input/reset', array('internalname' => elgg_echo('cancel'), 
												'value' => elgg_echo('cancel'),
												'js' => "onClick='resetCategoryForm();'"));
	$formbody .= "&nbsp;";
	$formbody .= elgg_view('input/button', array('internalname' => elgg_echo('delete'),
												'class' => "submit_button custom_fields_category_delete_button", 
												'value' => elgg_echo('delete'),
												'type' => "button",
												'js' => "onClick='deleteCategory();'"));
	
	$form = elgg_view('input/form', array('body' => $formbody, 
										'action' => $vars['url'] . 'action/profile_manager/categories/add')
									);
	
?>
<div class="contentWrapper" id="custom_fields_category_form">
	<h3 class="settings"><span class='custom_fields_more_info' id='more_info_category'></span><?php echo elgg_echo("profile_manager:categories:add:link"); ?></h3>
	<?php echo $form; ?>
</div>