<?php

$last_login = strtotime('-3 months');

$date = sanitise_int(get_input('last_login'));
if ($date > 0) {
	$last_login = $date;
}

$form_body = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'date',
			'#label' => elgg_echo('profile_manager:admin:users:inactive:last_login'),
			'name' => 'last_login',
			'value' => $last_login,
			'timestamp' => true,
			'readonly' => true,
		],
		[
			'#type' => 'submit',
			'value' => elgg_echo('search'),
		],
	],
]);

$form = elgg_view('input/form', [
	'disable_security' => true,
	'action' => '/admin/users/inactive',
	'method' => 'GET',
	'body' => $form_body,
]);

echo elgg_view_module('inline', null, $form);

$limit = max((int) get_input('limit', 50), 0);
$offset = sanitise_int(get_input('offset', 0), false);

$options = [
	'type' => 'user',
	'limit' => $limit,
	'offset' => $offset,
	'metadata_name_value_pairs' => [
		[
			'name' => 'last_login',
			'operand' => '<=',
			'value' => $last_login,
		],
	],
	'order_by_metadata' => [
		'last_login',
	],
];

$users = elgg_get_entities($options);

if (!empty($users)) {
	$content = '<table class="elgg-table">';
	$content .= '<thead><tr>';
	$content .= '<th>' . elgg_echo('user') . '</th>';
	$content .= '<th>' . elgg_echo('usersettings:statistics:label:lastlogin') . '</th>';
	$content .= '<th>' . elgg_echo('banned') . '</th>';
	$content .= '</tr></thead>';
	
	foreach ($users as $user) {
		$content .= '<tr>';
		$content .= '<td>' . elgg_view('output/url', [
			'text' => $user->name,
			'href' => $user->getURL(),
		]) . '</td>';
		$user_last_login = $user->last_login;
		if (empty($user_last_login)) {
			$content .= '<td>' . elgg_echo('never') . '</td>';
		} else {
			$content .= '<td>' . elgg_view_friendly_time($user_last_login) . '</td>';
		}
		$content .= '<td>' . elgg_echo('option:' . $user->banned) . '</td>';
		$content .= '</tr>';
	}
	
	$content .= '</table>';
	
	$options['count'] = true;
	$count = elgg_get_entities($options);
	
	$content .= elgg_view('navigation/pagination', [
		'offset' => $offset,
		'limit' => $limit,
		'count' => $count,
	]);
} else {
	$content = elgg_echo('notfound');
}

echo elgg_view_module('info', elgg_echo('profile_manager:admin:users:inactive:list'), $content);
