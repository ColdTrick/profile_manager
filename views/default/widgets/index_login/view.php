<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
	
	if(!isloggedin()){
		$login_url = $vars['url'];
		if ((isset($vars["config"]->https_login)) && ($vars["config"]->https_login)) {
			$login_url = str_replace("http", "https", $vars['url']);
		}
		
		$form_body = "<p class='loginbox'>";
		if(get_plugin_setting("login_by_email", "profile_manager") != "yes"){
			$form_body .= "<label>" . elgg_echo('username') . "</label><br />";
		} else {
			$form_body .= "<label>" . elgg_echo('email') . "</label><br />";
		}
		$form_body .= elgg_view('input/text', array('internalname' => 'username'));
		$form_body .= "<br />";
		$form_body .= "<label>" . elgg_echo('password') . "</label><br />";
		$form_body .= elgg_view('input/password', array('internalname' => 'password'));
		$form_body .= "<br />";
		
		$form_body .= elgg_view('login/extend');
		$form_body .= elgg_view('socialink/login');
		
		$form_body .= elgg_view('input/submit', array('value' => elgg_echo('login')));
		$form_body .= "<div id='persistent_login'>";
		$form_body .= "<label><input type='checkbox' name='persistent' value='true' />" . elgg_echo('user:persistent') . "</label>";
		$form_body .= "</div>";
		$form_body .= "</p>";
		
		$form_body .= "<p class='loginbox'>";
		if(!isset($vars["config"]->disable_registration) || !($vars["config"]->disable_registration)){
			$form_body .= "<a href='" . $vars['url'] . "pg/register/'>" . elgg_echo('register') . "</a> | ";
		}
		$form_body .= "<a href='" . $vars['url'] . "account/forgotten_password.php'>" . elgg_echo('user:password:lost') . "</a></p>";
		
		$form = elgg_view('input/form', array('body' => $form_body, 'action' => $login_url . "action/login", "internalid" => "widget_manager_login_form"));
	} else {
		$form = sprintf(elgg_echo("widget_manager:widgets:index_login:welcome"), get_loggedin_user()->name, $vars["config"]->site->name);
	}
	
?>
<div class="contentWrapper">
	<?php echo $form; ?>
</div>
<script type="text/javascript">
	$(document).ready(function() { $('#widget_manager_login_form input[name=username]').focus(); });
</script>