<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

if (elgg_is_sticky_form('register')) {
	$values = elgg_get_sticky_values('register');

	// Add the sticky values to $vars so views extending
	// register/extend also get access to them.
	$vars = array_merge($vars, $values);

	elgg_clear_sticky_form('register');
} else {
	$values = [];
}

$password = $password2 = '';
$username = elgg_extract('username', $values, get_input('u'));
$email = elgg_extract('email', $values, get_input('e'));
$name = elgg_extract('name', $values, get_input('n'));

$terms = elgg_extract('terms', $values);

$show_hints = (bool) (elgg_get_plugin_setting('show_account_hints', 'profile_manager') == 'yes');
$generate_username_from_email = (bool) (elgg_get_plugin_setting('generate_username_from_email', 'profile_manager') == 'yes');

$fields = [
	[
		'#type' => 'hidden',
		'name' => 'friend_guid',
		'value' => elgg_extract('friend_guid', $vars),
	],
	[
		'#type' => 'hidden',
		'name' => 'invitecode',
		'value' => elgg_extract('invitecode', $vars),
	],
	[
		'#type' => 'text',
		'#label' => elgg_echo('name'),
		'#class' => 'mtm',
		'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:name') : null,
		'name' => 'name',
		'value' => $name,
		'autofocus' => true,
		'required' => true,
	],
	[
		'#type' => 'email',
		'#label' => elgg_echo('email'),
		'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:email') : null,
		'name' => 'email',
		'value' => $email,
		'required' => true,
	],
];

if (!$generate_username_from_email) {
	$fields[] = [
		'#type' => 'text',
		'#label' => elgg_echo('username'),
		'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:username') : null,
		'name' => 'username',
		'value' => $username,
		'required' => true,
	];
}

$fields[] = [
	'#type' => 'password',
	'#label' => elgg_echo('password'),
	'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:password') : null,
	'name' => 'password',
	'value' => $password,
	'required' => true,
];
$fields[] = [
	'#type' => 'password',
	'#label' => elgg_echo('passwordagain'),
	'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:passwordagain') : null,
	'name' => 'password2',
	'value' => $password2,
	'required' => true,
];

echo elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'register-form-account',
	'fields' => $fields,
]);

// view to extend to add more fields to the registration form
echo elgg_view('register/extend', $vars);

// Add captcha hook
echo elgg_view('input/captcha', $vars);

$footer = '';
$accept_terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
if ($accept_terms) {
	$footer .= elgg_view_field([
		'#type' => 'checkbox',
		'#label' => elgg_echo('profile_manager:registration:accept_terms', [
			"<a target='_blank' href='{$accept_terms}'>",
			'</a>',
		]),
		'required' => true,
		'name' => 'accept_terms',
		'value' => 'yes',
		'default' => false,
	]);
}

$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('register'),
]);

elgg_set_form_footer($footer);

echo elgg_format_element('script', [], 'require(["profile_manager/register"]);');
