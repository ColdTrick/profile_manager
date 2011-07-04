<?php
	/**
	 * Elgg register form
	 *
	 * @package Elgg
	 * @subpackage Core
	 */
	
	$name = get_input("n", $_SESSION["register_post_backup"]["name"]);
	$email = get_input("e", $_SESSION["register_post_backup"]["email"]);
	$username = get_input("u", $_SESSION["register_post_backup"]["username"]);

	// must accept terms
	if($accept_terms = get_plugin_setting("registration_terms", "profile_manager")){
		$link_begin = "<a target='_blank' href='" . $accept_terms . "'>";
		$link_end = "</a>";
		
		$terms .= "<div class='mandatory'>";
		$terms .= "<input type='checkbox' name='accept_terms' value='yes' /> ";
		$terms .= "<label>" . sprintf(elgg_echo("profile_manager:registration:accept_terms"), $link_begin, $link_end) . "</label>";
		$terms .= "</div>";
	}
	
	// account details
	
	$account = "<div class='mandatory'>";
	
	$account .= "<label>" . elgg_echo("name") . "</label><br />";
	$account .= elgg_view("input/text" , array("internalname" => "name", "value" => $name)) . "<br />";
	
	$account .= "<label>" . elgg_echo("email") . "</label><br />";
	$account .= elgg_view("input/text" , array("internalname" => "email", "value" => $email)) . "<br />";
	
	if(get_plugin_setting("login_by_email", "profile_manager") != "yes"){
		$account .= "<label>" . elgg_echo("username") . "</label><br />";
		$account .= elgg_view("input/text" , array("internalname" => "username", "value" => $username)) . "<br />";
	}
	
	$account .= "<label>" . elgg_echo("password") . "</label><br />";
	$account .= elgg_view("input/password" , array("internalname" => "password")) . "<br />";
	
	$account .= "<label>" . elgg_echo("passwordagain") . "</label><br />";
	$account .= elgg_view("input/password" , array("internalname" => "password2")) . "<br />";
	$account .= "</div>";
	
	// layout
	$form_body = "<table>";
	$form_body .= "<tr><td>";
	
	// account part
	$form_body .= $account;
	
	// view to extend the registration form
	$form_body .= elgg_view("register/extend");
	
	// Add captcha hook
	$form_body .= elgg_view("input/captcha");
	
	$form_body .= $terms;	
	
	$form_body .= "</td>";
	
	$form_body .= "<td>";
	
	// rightside extendable view
	$form_body .= elgg_view("register/extend_side");
	
	$form_body .= "</td></tr>";
	$form_body .= "</table>";

	$form_body .= elgg_view("input/hidden", array("internalname" => "friend_guid", "value" => $vars["friend_guid"]));
	$form_body .= elgg_view("input/hidden", array("internalname" => "invitecode", "value" => $vars["invitecode"]));
	$form_body .= elgg_view("input/hidden", array("internalname" => "action", "value" => "register"));
	$form_body .= elgg_view("input/submit", array("internalname" => "submit", "value" => elgg_echo("register")));
	
	$title = elgg_view_title(elgg_echo('register'));
	
	$body = "<div id='register-box' class='table_layout'>"; 
	$body .= elgg_view("input/form", array("internalid" => "register_form", "action" => $vars["url"] . "action/register", "body" => $form_body));
	$body .= "<div>" . elgg_echo("profile_manager:register:mandatory") . "</div>"; 
	$body .= "</div>"; 
	
	$body = elgg_view("page_elements/contentwrapper", array("body" => $body));
	$body .= elgg_view("profile_manager/register/js");

	$page_data = $title . $body;
	
	echo elgg_view_layout("one_column", $page_data);

	// cleanup $_SESSION
	unset($_SESSION["register_post_backup"]); 
?>