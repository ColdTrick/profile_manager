<?php
/**
 * Elgg register form
 */

$show_hints = (bool) (elgg_get_plugin_setting('show_account_hints', 'profile_manager') === 'yes');
$generate_username_from_email = (bool) (elgg_get_plugin_setting('generate_username_from_email', 'profile_manager') === 'yes');

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
		'value' => elgg_extract('name', $vars, get_input('n')),
		'autofocus' => true,
		'required' => true,
	],
	[
		'#type' => 'email',
		'#label' => elgg_echo('email'),
		'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:email') : null,
		'name' => 'email',
		'value' => elgg_extract('email', $vars, get_input('e')),
		'required' => true,
	],
];

if (!$generate_username_from_email) {
	elgg_import_esm('forms/register');
	
	$fields[] = [
		'#type' => 'text',
		'#label' => elgg_echo('username'),
		'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:username') : null,
		'name' => 'username',
		'value' => elgg_extract('username', $vars, get_input('u')),
		'required' => true,
	];
}

$fields[] = [
	'#type' => 'password',
	'#label' => elgg_echo('password'),
	'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:password') : null,
	'name' => 'password',
	'required' => true,
	'autocomplete' => 'new-password',
	'add_security_requirements' => true,
];

$fields[] = [
	'#type' => 'password',
	'#label' => elgg_echo('passwordagain'),
	'#help' => $show_hints ? elgg_echo('profile_manager:register:hints:passwordagain') : null,
	'name' => 'password2',
	'required' => true,
	'autocomplete' => 'new-password',
	'add_security_requirements' => true,
];

echo elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'register-form-account',
	'fields' => $fields,
]);

// view to extend to add more fields to the registration form
echo elgg_view('register/extend', $vars);

// Add captcha
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
	'text' => elgg_echo('register'),
]);

elgg_set_form_footer($footer);
