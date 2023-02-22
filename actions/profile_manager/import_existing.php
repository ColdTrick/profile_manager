<?php
/**
 * Profile Manager
 *
 * Action to import from 'existing' profile fields
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

$type = get_input('type', 'user');

$n = 0;
$skipped = 0;

$options = [
	'type' => 'object',
	'subtype' => \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE,
	'owner_guid' => elgg_get_site_entity()->guid,
];

if ($type === 'group') {
	$options['subtype'] = \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE;
}

$new_order = elgg_count_entities($options) + 1;

// deregister events
elgg_unregister_event_handler('fields', 'user:user', '\ColdTrick\ProfileManager\ProfileFields::getFields');
elgg_unregister_event_handler('fields', 'group:group', '\ColdTrick\ProfileManager\ProfileFields::getFields');

if ($type === 'group') {
	$existing_fields = elgg()->fields->get('group', 'group');
} else {
	$existing_fields = elgg()->fields->get('user', 'user');
}

if (empty($existing_fields)) {
	return elgg_error_response(elgg_echo('profile_manager:actions:import:from_existing:no_fields'));
}

foreach ($existing_fields as $existing_field) {
	$metadata_name = $existing_field['name'];
	$metadata_label = $existing_field['#label'];
	$metadata_type = $existing_field['#type'];
	
	$options['metadata_name_value_pairs'] = ['name' => 'metadata_name', 'value' => $metadata_name];
		
	$count = elgg_count_entities($options);
	
	if ($count == 0) {
		if ($type === 'group') {
			$field = new \ColdTrick\ProfileManager\CustomGroupField();
		} else {
			$field = new \ColdTrick\ProfileManager\CustomProfileField();
		}
		
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

elgg_delete_system_cache("profile_manager_{$type}:{$type}_fields");

$num_new_fields = $n - $skipped;
if (!$num_new_fields) {
	return elgg_error_response(elgg_echo('profile_manager:actions:import:from_existing:no_fields'));
}

return elgg_ok_response('', elgg_echo('profile_manager:actions:import:from_existing:new_fields', [$num_new_fields]));
