<?php

set_time_limit(0);

$last_login = sanitise_int(get_input('last_login'), false);

if (empty($last_login)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$dbprefix = elgg_get_config('dbprefix');
$fields = ['username', 'name', 'email', 'last_login', 'banned'];

ob_start();

$df = fopen('php://output', 'w');

$headers = [];
foreach ($fields as $field) {
	$headers[] = $field;
}
fputcsv($df, $headers, ';');

$options = [
	'type' => 'user',
	'limit' => false,
	'relationship' => 'member_of_site',
	'relationship_guid' => elgg_get_site_entity()->getGUID(),
	'inverse_relationship' => true,
	'site_guids' => false,
	'joins' => ['JOIN ' . $dbprefix . 'users_entity ue ON e.guid = ue.guid'],
	'wheres' => ['ue.last_login <= ' . $last_login],
	'order_by' => 'ue.last_login'
];

$users = new ElggBatch('elgg_get_entities_from_relationship', $options);
foreach ($users as $user) {
	$row = [];
	foreach ($fields as $field) {
		$row[] = $user->$field;
	}
	fputcsv($df, $row, ';');
}

fclose($df);

$output = ob_get_clean();

if (empty($output)) {
	register_error(elgg_echo("error:missing_data"));
	forward(REFERER);
}

// We'll be outputting a CSV
// It will be called export_inactive.csv
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream');
header('Content-Type: application/download');
header('Content-Disposition: attachment;filename=export_inactive.csv');
header('Content-Transfer-Encoding: binary');

echo $output;

exit();
