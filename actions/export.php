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
	
$fieldtype = get_input("fieldtype");
$fields = get_input("export");
	
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename={$filename}");
header("Content-Transfer-Encoding: binary");

ob_start();

$df = fopen("php://output", 'w');
	
if (!empty($fieldtype) && !empty($fields)) {
	if ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE) {
		$include_groups = false;
		
		$options = array(
			"limit" => false
		);
		
		if ($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) {
			$type = "user";
			$options["relationship"] = "member_of_site";
			$options["relationship_guid"] = elgg_get_site_entity()->getGUID();
			$options["inverse_relationship"] = true;
			$options["site_guids"] = false;
			
			if (get_input("include_group_membership")) {
				$include_groups = true;
			}
		} else {
			$type = "group";
		}
			
		$options["type"] = $type;
		
		$headers = array();
		foreach ($fields as $field) {
			$headers[] = $field;
		}
		if ($include_groups) {
			$headers[] = "group membership";
		}
		fputcsv($df, $headers, ";");
		
		$group_options = array (
				"selects" => array("ge.name"),
				"type" => "group",
				"relationship" => "member",
				"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
				"inverse_relationship" => false,
				"callback" => "profile_manager_export_group_name"
			);
		
		$entities = new ElggBatch('elgg_get_entities_from_relationship', $options);
		if (!empty($entities)) {
			foreach ($entities as $entity) {
				$row = array();
				foreach ($fields as $field) {
					$field_data = $entity->$field;
					if (is_array($field_data)) {
						$field_data = implode(",", $field_data);
					}
					$row[] = $field_data;
				}
				if ($include_groups) {
					$group_options["relationship_guid"] = $entity->guid;
					$groups = elgg_get_entities_from_relationship($group_options);
					
					$groups_text = implode(",", $groups);
					
					$row[] = "$groups_text";
				}
				fputcsv($df, $row, ";");
			}
		}
	}
		
	fclose($df);

	echo ob_get_clean();
	exit;
}

exit();
