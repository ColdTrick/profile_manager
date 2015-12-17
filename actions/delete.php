<?php
/**
* Profile Manager
*
* jQuery call to remove a custom_profile_field or custom_group_field
*
* @param guid (of the entity to remove)
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!elgg_instanceof($entity, 'object', CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE) && !elgg_instanceof($entity, 'object', CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE)) {
	register_error(elgg_echo('profile_manager:actions:delete:error:unknown'));
	return;
}

$site_guid = $entity->site_guid;

if (!$entity->delete()) {
	register_error(elgg_echo('profile_manager:actions:delete:error:unknown'));
	return;
}

// clear cache
elgg_get_system_cache()->delete("profile_manager_profile_fields_{$site_guid}");
elgg_get_system_cache()->delete("profile_manager_group_fields_{$site_guid}");
