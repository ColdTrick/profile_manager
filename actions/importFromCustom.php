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

$options = [
	'type' => 'object',
	'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
	'count' => true,
	'owner_guid' => elgg_get_site_entity()->getGUID(),
];

$new_order = elgg_get_entities($options) + 1;

$fieldlist = elgg_get_config('profile_custom_fields');

if (empty($fieldlist)) {
	register_error(elgg_echo('profile_manager:actions:import:from_custom:no_fields'));
	forward(REFERER);
}

$fieldlistarray = explode(',', $fieldlist);
foreach ($fieldlistarray as $listitem) {
	$translation = elgg_get_config("admin_defined_profile_{$listitem}");
	if (empty($translation)) {
		continue;
	}

	$metadata_name = "admin_defined_profile_{$listitem}";
	$metadata_label = $translation;
	$metadata_type = elgg_get_config("admin_defined_profile_type_{$listitem}") ?: 'text';
	
	$options['metadata_name_value_pairs'] = ['name' => 'metadata_name', 'value' => $metadata_name];
		
	$count = elgg_get_entities_from_metadata($options);
	
	if ($count == 0) {
		$field = new \ColdTrick\ProfileManager\CustomProfileField();
				
		$field->save();
		
		$field->metadata_name = $metadata_name;
		$field->metadata_label = $metadata_label;
		$field->metadata_type = $metadata_type;
		
		$field->order = $new_order;
		
		$field->save();
		
		$new_order++;
	} else {
		$skipped++;
	}
	$n++;
}

// clear cache
$site_guid = elgg_get_site_entity()->getGUID();
elgg_get_system_cache()->delete("profile_manager_profile_fields_{$site_guid}");

$num_new_fields = $n - $skipped;
if ($num_new_fields) {
	system_message(elgg_echo('profile_manager:actions:import:from_custom:new_fields', [$num_new_fields]));
} else {
	register_error(elgg_echo('profile_manager:actions:import:from_custom:no_fields'));
}

forward(REFERER);
