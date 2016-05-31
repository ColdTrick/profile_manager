<?php
/**
* Profile Manager
*
* export profile data action
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

global $DB_QUERY_CACHE;
$DB_QUERY_CACHE = false; // no need for cache. Will only cause OOM issues

set_time_limit(0);
	
$filename = 'export.csv';
	
$fieldtype = get_input('fieldtype');
$fields = get_input('export');
	
if (empty($fieldtype) || empty($fields)) {
	register_error(elgg_echo("error:missing_data"));
	forward(REFERER);
}

if (!in_array($fieldtype, [CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE])) {
	register_error(elgg_echo("error:missing_data"));
	forward(REFERER);
}

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream');
header('Content-Type: application/download');
header("Content-Disposition: attachment;filename={$filename}");
header('Content-Transfer-Encoding: binary');

ob_start();

$df = fopen('php://output', 'w');
	
$include_groups = false;

$options = [
	'limit' => false,
	'type' => 'group',
];

if ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) {
	$options['type'] = 'user';
	$options['relationship'] = 'member_of_site';
	$options['relationship_guid'] = elgg_get_site_entity()->getGUID();
	$options['inverse_relationship'] = true;
	$options['site_guids'] = false;
	
	if (get_input('include_group_membership')) {
		$include_groups = true;
	}
}

$headers = [];
foreach ($fields as $field) {
	$headers[] = $field;
}

if ($include_groups) {
	$headers[] = 'group membership';
}

fputcsv($df, $headers, ';');

$group_options = [
	'selects' => ['ge.name'],
	'type' => 'group',
	'relationship' => 'member',
	'joins' => ['JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid'],
	'inverse_relationship' => false,
];

$entities = new ElggBatch('elgg_get_entities_from_relationship', $options);

foreach ($entities as $entity) {
	$row = [];
	foreach ($fields as $field) {
		$field_data = $entity->$field;
		if (is_array($field_data)) {
			$field_data = implode(',', $field_data);
		}
		$row[] = $field_data;
	}
	
	if ($include_groups) {
		$group_options['relationship_guid'] = $entity->guid;
		
		$groups_text = [];
		
		$groups = new ElggBatch('elgg_get_entities_from_relationship', $group_options);
		foreach ($groups as $group) {
			$group_name = htmlspecialchars_decode($group->name);
			$group_name = str_replace('\'', '', $group_name);
			$group_name = str_replace(',', ' ', $group_name);
			
			$groups_text[] = $group_name;
		}
		$groups_text = implode(',', $groups_text);
		$row[] = "$groups_text";
	}
	
	fputcsv($df, $row, ';');
}
	
fclose($df);

echo ob_get_clean();

exit();
