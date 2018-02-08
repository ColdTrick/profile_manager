<?php
/**
* Profile Manager
*
* Action to reset profile fields
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$type = get_input('type', 'profile');
$error = false;

if (!in_array($type, ['profile', 'group'])) {
	return elgg_error_response(elgg_echo('profile_manager:actions:reset:error:wrong_type'));
}

$site_guid = elgg_get_site_entity()->getGUID();

$entities = elgg_get_entities([
	'type' => 'object',
	'subtype' => "custom_{$type}_field",
	'limit' => false,
	'owner_guid' => $site_guid,
]);

if ($entities) {
	foreach ($entities as $entity) {
		if (!$entity->delete()) {
			$error = true;
		}
	}
}

elgg_get_system_cache()->delete("profile_manager_{$type}_fields_{$site_guid}");

if ($error) {
	return elgg_error_response(elgg_echo('profile_manager:actions:reset:error:unknown'));
}

return elgg_ok_response('', elgg_echo('profile_manager:actions:reset:success'));
