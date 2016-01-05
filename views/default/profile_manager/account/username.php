<?php

$enable_username_change = elgg_get_plugin_setting('enable_username_change', 'profile_manager', 'no');
if ($enable_username_change == 'no' || ($enable_username_change == 'admin' && !elgg_is_admin_logged_in())) {
	return;
}

elgg_require_js('profile_manager/username_change');

$user = elgg_get_page_owner_entity();

$body = elgg_view('input/button', [
	'href' => '#profile_manager_username',
	'rel' => 'toggle',
	'value' => elgg_echo('profile_manager:account:username:button'),
	'class' => 'elgg-button-action profile-manager-account-change-username',
]);

$body .= '<div id="profile_manager_username" class="hidden">';
$body .= elgg_view('input/text', [
	'name' => 'username',
	'value' => $user->username,
	'rel' => $user->username,
]);
$body .= elgg_view_icon('spinner', ['class' => 'profile_manager_validate_icon fa-pulse hidden']);

$body .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('profile_manager:account:username:info'));
$body .= '</div>';

echo elgg_view_module('info' , elgg_echo('username'), $body);
