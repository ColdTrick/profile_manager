<?php
	/**
	 * Elgg forgotten password.
	 *
	 * @package Elgg
	 * @subpackage Core
	 */
	
	if(get_plugin_setting("login_by_email", "profile_manager") != "yes"){
		$action = $vars["url"] . "action/user/requestnewpassword";
		
		$form_body = "<div>" . elgg_echo("user:password:text") . "</div>";
		$form_body .= "<div><label>". elgg_echo("username") . "</label></div>";
		$form_body .= elgg_view("input/text", array("internalname" => "username"));
	} else {
		$action = $vars["url"] . "action/user/requestnewpassword_by_email";
		
		$form_body = "<div>" . elgg_echo("profile_manager:user:password_email:text") . "</div>";
		$form_body .= "<div><label>". elgg_echo("email") . "</label></div>";
		$form_body .= elgg_view("input/email", array("internalname" => "email"));
	}

	// support for captcha
	if($captcha = elgg_view("input/captcha")){
		$form_body .= "<div>" . $captcha . "</div>";
	}
	
	// closing buttons
	$form_body .= "<div>";
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("request")));
	$form_body .= "</div>";
	
	// make form
	$form = elgg_view("input/form", array("body" => $form_body,
											"action" => $action));
	
	echo elgg_view("page_elements/contentwrapper", array("body" => $form));
	
?>