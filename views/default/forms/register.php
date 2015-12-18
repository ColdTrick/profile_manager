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
$terms = '';

if (elgg_is_sticky_form('register')) {
	$values = elgg_get_sticky_values('register');
	extract($values);
	elgg_clear_sticky_form('register');
}

echo "<div id='profile_manager_register_left'>";

$show_hints = false;
if (elgg_get_plugin_setting('show_account_hints', 'profile_manager') == 'yes') {
	$show_hints = true;
}

$generate_username_from_email = false;
if (elgg_get_plugin_setting('generate_username_from_email', 'profile_manager') == 'yes') {
	$generate_username_from_email = true;
}

$spinner = elgg_view_icon('spinner', ['class' => 'profile_manager_validate_icon fa-pulse hidden']);
?>

<fieldset>
	<div class="mtm mandatory">
		
		<label for='register-name'><?php echo elgg_echo('name'); ?></label>
		
		<?php
		if ($show_hints) {
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_name',
				'text' => elgg_echo('profile_manager:register:hints:name'),
			]);
		}
		
		echo '<br />';
		echo elgg_view('input/text', [
			'id' => 'register-name',
			'name' => 'name',
			'value' => $name,
			'class' => 'elgg-autofocus',
		]);
		?>
		
	</div>
	<div class="mandatory">
		<label for='register-email'><?php echo elgg_echo('email'); ?></label>
		
		<?php
		if ($show_hints) {
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_email',
				'text' => elgg_echo('profile_manager:register:hints:email'),
			]);
		}
		?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/text', array(
				'id' => 'register-email',
				'name' => 'email',
				'value' => $email,
			));

			echo $spinner;
			?>
		</div>
	</div>
	
	<?php if (!$generate_username_from_email) { ?>
	<div class="mandatory">
		<label for='register-username'><?php echo elgg_echo('username'); ?></label>
		
		<?php
		if ($show_hints) {
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_username',
				'text' => elgg_echo('profile_manager:register:hints:username'),
			]);
		}
		?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/text', array(
				'id' => 'register-username',
				'name' => 'username',
				'value' => $username,
			));

			echo $spinner;
			?>
		</div>
	</div>
	<?php } ?>
	
	<div class="mandatory">
		<label for='register-password'><?php echo elgg_echo('password'); ?></label>
		
		<?php
		if ($show_hints) {
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_password',
				'text' => elgg_echo('profile_manager:register:hints:password'),
			]);
		}
		?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/password', array(
				'id' => 'register-password',
				'name' => 'password',
				'value' => $password,
			));

			echo $spinner;
			?>
		</div>
	</div>
	<div class="mandatory">
		<label for='register-password2'><?php echo elgg_echo('passwordagain'); ?></label>
		
		<?php
		if ($show_hints) {
			echo elgg_view('output/pm_hint', [
				'id' => 'more_info_passwordagain',
				'text' => elgg_echo('profile_manager:register:hints:passwordagain'),
			]);
		}
		?>
		
		<br />
		<div class='profile_manager_register_input_container'>
			<?php
			echo elgg_view('input/password', array(
				'id' => 'register-password2',
				'name' => 'password2',
				'value' => $password2,
			));

			echo $spinner;
			?>
		</div>
	</div>
</fieldset>
<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend');

// Add captcha hook
echo elgg_view('input/captcha');

echo '</div>';

echo elgg_format_element('div', ['id' => 'profile_manager_register_right'], elgg_view('register/extend_side', ['field_location' => 'beside']));


echo "<div class='clearfloat man'></div>";
echo "<div class='elgg-foot'>";
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view("profile_manager/register/terms", $vars);
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register')));
echo "<div class='elgg-subtext mtm'>" . elgg_echo("profile_manager:register:mandatory") . "</div>";
echo "</div>";

echo elgg_format_element('script', [], 'require(["profile_manager/register"]);');
