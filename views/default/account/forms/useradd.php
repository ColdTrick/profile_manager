<?php
	/**
	 * Elgg add user form. 
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

	$admin_option = false;
	if (isadminloggedin() && ($vars['show_admin'])) 
		$admin_option = true;
		
	$form_body = "<p><label>" . elgg_echo('name') . "<br />" . elgg_view('input/text' , array('internalname' => 'name')) . "</label></p>";
	$form_body .= "<p><label>" . elgg_echo('email') . "<br />" . elgg_view('input/text' , array('internalname' => 'email')) . "</label></p>";
	$form_body .= "<p><label>" . elgg_echo('username') . "<br />" . elgg_view('input/text' , array('internalname' => 'username')) . "</label></p>";
	$form_body .= "<p><label>" . elgg_echo('password') . "<br />" . elgg_view('input/password' , array('internalname' => 'password')) . "</label></p>";
	$form_body .= "<p><label>" . elgg_echo('passwordagain') . "<br />" . elgg_view('input/password' , array('internalname' => 'password2')) . "</label></p>";
	
	if ($admin_option) {
		$form_body .= "<p>" . elgg_view('input/checkboxes', array('internalname' => "admin", 'options' => array(elgg_echo('admin_option'))));
	}
	
	$form_body .= "<p>" . elgg_view('input/checkboxes', array('internalname' => "notify", 'options' => array(elgg_echo('profile_manager:admin:adduser:notify'))));
	$form_body .= "<p>" . elgg_view('input/checkboxes', array('internalname' => "mark_as_validated", 'value' => elgg_echo('profile_manager:admin:adduser:mark_as_validated'), 'options' => array(elgg_echo('profile_manager:admin:adduser:mark_as_validated'))));
	$form_body .= "<p>" . elgg_view('input/checkboxes', array('internalname' => "use_default_access", 'value' => elgg_echo('profile_manager:admin:adduser:use_default_access'), 'options' => array(elgg_echo('profile_manager:admin:adduser:use_default_access'))));
	
	// get profile types
	$profile_type_options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				"limit" => 0,
				"owner_guid" => $CONFIG->site_guid
			);
	
	$types = elgg_get_entities($profile_type_options);
	
	$categorized_fields = profile_manager_get_categorized_fields(null, true);
	$cats = $categorized_fields['categories'];
	$fields = $categorized_fields['fields'];
	
	if($types || !empty($fields[0])){
		$form_body .= "<a href='javascript:void(0);' onclick='$(\"#extra_metadata\").show(); $(this).hide();'>" . elgg_echo("profile_manager:admin:adduser:extra_metadata") . "</a><div id='extra_metadata' style='display:none;'>";	
		
	}
	
	if($types){
		
		$options = array();
		$options[""] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
		
		foreach($types as $type){
			$options[$type->guid] = $type->getTitle();
		}
		
		$form_body .= "<p>\n";
		$form_body .= "<label>\n";
		$form_body .= elgg_echo("profile_manager:profile:edit:custom_profile_type:label") . "<br />\n";
		
		$form_body .= elgg_view("input/pulldown", array("internalname" => "custom_profile_fields[custom_profile_type]",
												"options_values" => $options));
		$form_body .= "</label>\n";
		$form_body .= "</p>\n";	
	}
	
	if(!empty($cats)){
		foreach($cats as $cat_guid => $cat){		
			// display each field for currect category
			foreach($fields[$cat_guid] as $field){
				$metadata_name = $field->metadata_name;
				// get options
				$options = $field->getOptions(true);
	
				// make title
				$title = $field->getTitle();
				
				$form_body .= "<p><label>\n" . $title . "<br /></label>\n";
				$form_body .= elgg_view("input/" . $field->metadata_type, array(
																'internalname' => "custom_profile_fields[" . $metadata_name . "]",
																'options' => $options
																));
				$form_body .= "</p>\n";
			}
		}
	}
	
	if($types || !empty($fields[0])){
		$form_body .= "</div>";
	}
	$form_body .= elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('register'))) . "</p>";
?>

	
	<div id="add-box">
		<h3 class='settings'><?php echo elgg_echo('adduser'); ?></h3>
		<?php echo elgg_view('input/form', array('action' => "{$vars['url']}action/useradd", 'body' => $form_body)) ?>
	</div>