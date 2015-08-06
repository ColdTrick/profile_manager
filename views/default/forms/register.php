<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');
$terms = "";

if (elgg_is_sticky_form('register')) {
	$values = elgg_get_sticky_values('register');
	extract($values);
	elgg_clear_sticky_form('register');
}

echo "<div id='profile_manager_register_left'>";

$show_hints = false;
if (elgg_get_plugin_setting("show_account_hints", "profile_manager") == "yes") {
	$show_hints = true;
}

$generate_username_from_email = false;
if (elgg_get_plugin_setting("generate_username_from_email", "profile_manager") == "yes") {
	$generate_username_from_email = true;
}
?>

<fieldset>
	<div class="mtm mandatory">
		
		<label for='register-name'><?php echo elgg_echo('name'); ?></label>
		
		<?php if ($show_hints) { ?>
		<span class='custom_fields_more_info' id='more_info_name'></span>
		<span class='hidden' id='text_more_info_name'><?php echo elgg_echo("profile_manager:register:hints:name")?></span>
		<?php } ?>
		
		<br />
		
		<?php
		echo elgg_view('input/text', array(
			'id' => 'register-name',
			'name' => 'name',
			'value' => $name,
			'class' => 'elgg-autofocus'
		));
		?>
		
	</div>
	<div class="mandatory">
		<label for='register-email'><?php echo elgg_echo('email'); ?></label>
		
		<?php if ($show_hints) { ?>
		<span class='custom_fields_more_info' id='more_info_email'></span>
		<span class='hidden' id='text_more_info_email'><?php echo elgg_echo("profile_manager:register:hints:email")?></span>
		<?php } ?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/text', array(
				'id' => 'register-email',
				'name' => 'email',
				'value' => $email,
			));
			?>
			<span class='elgg-icon profile_manager_validate_icon'></span>
		</div>
	</div>
	
	<?php if (!$generate_username_from_email) { ?>
	<div class="mandatory">
		<label for='register-username'><?php echo elgg_echo('username'); ?></label>
		
		<?php if ($show_hints) { ?>
		<span class='custom_fields_more_info' id='more_info_username'></span>
		<span class='hidden' id='text_more_info_username'><?php echo elgg_echo("profile_manager:register:hints:username")?></span>
		<?php } ?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/text', array(
				'id' => 'register-username',
				'name' => 'username',
				'value' => $username,
			));
			?>
			<div class='elgg-icon profile_manager_validate_icon'></div>
		</div>
	</div>
	<?php } ?>
	
	<div class="mandatory">
		<label for='register-password'><?php echo elgg_echo('password'); ?></label>
		
		<?php if ($show_hints) { ?>
		<span class='custom_fields_more_info' id='more_info_password'></span>
		<span class='hidden' id='text_more_info_password'><?php echo elgg_echo("profile_manager:register:hints:password")?></span>
		<?php } ?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/password', array(
				'id' => 'register-password',
				'name' => 'password',
				'value' => $password,
			));
			?>
			<span class='elgg-icon profile_manager_validate_icon'></span>
		</div>
	</div>
	<div class="mandatory">
		<label for='register-password2'><?php echo elgg_echo('passwordagain'); ?></label>
		
		<?php if ($show_hints) { ?>
		<span class='custom_fields_more_info' id='more_info_passwordagain'></span>
		<span class='hidden' id='text_more_info_passwordagain'><?php echo elgg_echo("profile_manager:register:hints:passwordagain")?></span>
		<?php } ?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/password', array(
				'id' => 'register-password2',
				'name' => 'password2',
				'value' => $password2,
			));
			?>
			<span class='elgg-icon profile_manager_validate_icon'></span>
		</div>
	</div>
</fieldset>
<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend');

// Add captcha hook
echo elgg_view('input/captcha');

echo "</div>";

echo "<div id='profile_manager_register_right'>";
echo elgg_view("register/extend_side", array("field_location" => "beside"));
echo "</div>";

echo "<div class='clearfloat man'></div>";
echo "<div class='elgg-foot'>";
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view("profile_manager/register/terms", $vars);
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register')));
echo "<div class='elgg-subtext mtm'>" . elgg_echo("profile_manager:register:mandatory") . "</div>";
echo "</div>";

?>
<script type='text/javascript'>
	require(['profile_manager/register']);
</script>
