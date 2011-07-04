<?php
	/**
	 * Elgg login form
	 *
	 * @package Elgg
	 * @subpackage Core
	 */
	
	global $CONFIG;
	
	$login_url = $vars['url'];
	if ((isset($CONFIG->https_login)) && ($CONFIG->https_login)) {
		$login_url = str_replace("http", "https", $vars['url']);
	}
	
	$form_body = "<div class='loginbox'>";
	if(get_plugin_setting("login_by_email", "profile_manager") != "yes"){
		$form_body .= "<label>" . elgg_echo('username') . "</label><br />";
	} else {
		$form_body .= "<label>" . elgg_echo('email') . "</label><br />";
	}
	$form_body .= elgg_view('input/text', array('internalname' => 'username', 'class' => 'login-textarea'));
	$form_body .= "<br />";
	$form_body .= "<label>" . elgg_echo('password') . "</label><br />";
	$form_body .= elgg_view('input/password', array('internalname' => 'password', 'class' => 'login-textarea'));
	$form_body .= "<br />";
	
	$form_body .= elgg_view('login/extend');
	
	$form_body .= "</div>";
	
	$form_body .= "<div class='loginbox'>";
	$form_body .= elgg_view('input/submit', array('value' => elgg_echo('login')));
	$form_body .= "</div>";
	
	$form_body .= "<div id='persistent_login'>";
	$form_body .= "<input type='checkbox' name='persistent' value='true' />";
	$form_body .= "<label>" . elgg_echo('user:persistent') . "</label>";
	$form_body .= "</div>";
	
	$form_body .= "<div class='loginbox'>";
	if(!isset($CONFIG->disable_registration) || !($CONFIG->disable_registration)){
		$form_body .= elgg_view("output/url", array("href" => $vars['url'] . "pg/register/", "text" => elgg_echo('register'))) . " | ";
	}
	
	$form_body .= elgg_view("output/url", array("href" => $vars['url'] . "account/forgotten_password.php", "text" => elgg_echo('user:password:lost')));
	$form_body .= "</div>";
	
?>
<div id="login-box">
	<h2><?php echo elgg_echo('login'); ?></h2>
	<?php
		echo elgg_view('input/form', array('body' => $form_body, 'action' => $login_url . "action/login"));
	?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#login-box input[name=username]').focus(); 
	});
</script>