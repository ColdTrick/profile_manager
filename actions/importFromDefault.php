<?php
/**
* Profile Manager
*
* Action to import from default
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$site_guid = elgg_get_site_entity()->getGUID();

$type = get_input('type', 'profile');

if (!in_array($type, ['profile', 'group'])) {
	register_error(elgg_echo('profile_manager:actions:import:from_default:error:wrong_type'));
	forward(REFEER);
}

$added = 0;
$defaults = [];

$subtype = "custom_{$type}_field";
$options = [
	'type' => 'object',
	'subtype' => $subtype,
	'count' => true,
	'owner_guid' => $site_guid,
];

$max_fields = elgg_get_entities($options) + 1;

if ($type == 'profile') {
	$defaults = [
		'description' => 'longtext',
		'briefdescription' => 'text',
		'location' => 'location',
		'interests' => 'tags',
		'skills' => 'tags',
		'contactemail' => 'email',
		'phone' => 'text',
		'mobile' => 'text',
		'website' => 'url',
		'twitter' => 'text',
	];
} elseif ($type == 'group') {
	$defaults = [
		'description' => 'longtext',
		'briefdescription' => 'text',
		'interests' => 'tags',
	];
}

foreach ($defaults as $metadata_name => $metadata_type) {
	$options['metadata_name_value_pairs'] = ['name' => 'metadata_name', 'value' => $metadata_name];
	
	$count = elgg_get_entities_from_metadata($options);
	if ($count) {
		continue;
	}
	
	$field = new ElggObject(); // not using classes so we can handle both profile and group in one function
			
	$field->owner_guid = $site_guid;
	$field->container_guid = $site_guid;
	$field->access_id = ACCESS_PUBLIC;
	$field->subtype = $subtype;
	$field->save();
	
	$field->metadata_name = $metadata_name;
	$field->metadata_type = $metadata_type;
	
	if ($type == 'profile') {
		$field->show_on_register = 'no';
		$field->mandatory = 'no';
		$field->user_editable = 'yes';
	}
	$field->order = $max_fields;
	
	$field->save();
	
	$max_fields++;
	$added++;
}

if ($added == 0) {
	register_error(elgg_echo('profile_manager:actions:import:from_default:no_fields'));
} else {
	elgg_get_system_cache()->delete("profile_manager_{$type}_fields_{$site_guid}");
	system_message(elgg_echo('profile_manager:actions:import:from_default:new_fields', [$added]));
}

forward(REFERER);
