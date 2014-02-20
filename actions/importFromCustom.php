<?php
/**
* Profile Manager
*
* Action to import from 'default' custom profile fields
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$n = 0;
$skipped = 0;

$options = array(
	"type" => "object",
	"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
	"count" => true,
	"owner_guid" => elgg_get_site_entity()->getGUID()
);

$new_order = elgg_get_entities($options) + 1;
	
if ($fieldlist = elgg_get_config('profile_custom_fields')) {
	$fieldlistarray = explode(',', $fieldlist);
	foreach ($fieldlistarray as $listitem) {
		if ($translation = elgg_get_config("admin_defined_profile_{$listitem}")) {
			$metadata_name = "admin_defined_profile_$listitem";
			$metadata_label = $translation;
			
			$type = elgg_get_config("admin_defined_profile_type_$listitem");
			if (empty($type)) {
				$type = 'text';
			}
			$metadata_type = $type;
			
			$options["metadata_name_value_pairs"] = array("name" => "metadata_name", "value" => $metadata_name);
				
			$count = elgg_get_entities_from_metadata($options);
			
			if ($count == 0) {
				$field = new ProfileManagerCustomProfileField();
						
				$field->save();
				
				$field->metadata_name = $metadata_name;
				$field->metadata_label = $metadata_label;
				$field->metadata_type = $metadata_type;
				
				$field->show_on_register = "no";
				$field->mandatory = "no";
				$field->user_editable = "yes";
				
				$field->order = $new_order;
				
				$field->save();
				
				$new_order++;
			} else {
				$skipped++;
			}
			$n++;
		}
	}
	
	// clear cache
	$site_guid = elgg_get_site_entity()->getGUID();
	elgg_get_system_cache()->delete("profile_manager_profile_fields_" . $site_guid);
}

if (($n - $skipped) == 0) {
	register_error(elgg_echo("profile_manager:actions:import:from_custom:no_fields"));
} else {
	system_message(elgg_echo("profile_manager:actions:import:from_custom:new_fields", array($n - $skipped)));
}

forward(REFERER);
