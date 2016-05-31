<?php

namespace ColdTrick\ProfileManager;

/**
 * ProfileFields
 */
class ProfileFields {

	/**
	 * Hook to replace the profile fields
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return array
	 */
	public static function getUserFields($hook_name, $entity_type, $return_value, $parameters) {
		$result = [];
	
		// get from cache
		$site_guid = elgg_get_config('site_guid');
	
		$entities = elgg_load_system_cache("profile_manager_profile_fields_{$site_guid}");
		if ($entities === null) {
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				'limit' => false,
				'owner_guid' => elgg_get_config('site_guid'),
			]);
			elgg_save_system_cache("profile_manager_profile_fields_{$site_guid}", serialize($entities));
		} else {
			$entities = unserialize($entities);
		}
		
		if (empty($entities)) {
			return $result;
		}
	
		$guids = [];

		foreach ($entities as $entity) {
			$guids[] = $entity->getGUID();
		}

		_elgg_services()->metadataCache->populateFromEntities($guids);

		$translations = [];
		$context = elgg_get_context();

		// order fields
		$ordered_entities = [];
		foreach ($entities as $entity) {
			$ordered_entities[$entity->order] = $entity;
		}
		ksort($ordered_entities);

		// make new result
		foreach ($ordered_entities as $entity) {
			if ($entity->admin_only != 'yes' || (elgg_is_admin_logged_in() || elgg_get_ignore_access())) {

				$result[$entity->metadata_name] = $entity->metadata_type;

				// should it be handled as tags? TODO: is this still needed? Yes it is, it handles presentation of these fields in listing mode
				if ($context == 'search' && ($entity->output_as_tags == 'yes' || $entity->metadata_type == 'multiselect')) {
					$result[$entity->metadata_name] = 'tags';
				}
			}

			$translations["profile:{$entity->metadata_name}"] = $entity->getTitle();
		}

		$languages = ['en'];
		$languages[] = get_current_language();
		$languages[] = elgg_get_config('language');
		array_unique($languages);

		foreach ($languages as $lang) {
			add_translation($lang, $translations);
		}

		if (count($result) > 0) {
			$result['custom_profile_type'] = 'hidden';
		}
		
		return $result;
	}
	
	/**
	 * Function to replace group profile fields
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return array
	 */
	public static function getGroupFields($hook_name, $entity_type, $return_value, $parameters) {
	
		// get from cache
		$site_guid = elgg_get_config('site_guid');
		
		$entities = elgg_load_system_cache("profile_manager_group_fields_{$site_guid}");
		if ($entities === null) {
			$options = [
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
				'limit' => false,
				'owner_guid' => elgg_get_config('site_guid')
			];
			$entities = elgg_get_entities($options);
			elgg_save_system_cache("profile_manager_group_fields_{$site_guid}", serialize($entities));
		} else {
			$entities = unserialize($entities);
		}
	
		if (empty($entities)) {
			return;
		}
	
		$guids = [];
		$translations = [];
	
		foreach ($entities as $entity) {
			$guids[] = $entity->getGUID();
		}
	
		_elgg_services()->metadataCache->populateFromEntities($guids);
	
		$result = [];
		$ordered = [];
	
		// Order the group fields and filter some types out
		foreach ($entities as $group_field) {
			if ($group_field->admin_only != 'yes' || (elgg_is_admin_logged_in() || elgg_get_ignore_access())) {
				$ordered[$group_field->order] = $group_field;
			}
		}
		ksort($ordered);
	
		// build the correct list
		$result['name'] = 'text';
		foreach ($ordered as $group_field) {
			$result[$group_field->metadata_name] = $group_field->metadata_type;
	
			// should it be handled as tags? Q: is this still needed? A: Yes it is, it handles presentation of these fields in listing mode
			if (elgg_get_context() == 'search' && ($group_field->output_as_tags == 'yes' || $group_field->metadata_type == 'multiselect')) {
				$result[$group_field->metadata_name] = 'tags';
			}
	
			$translations["groups:{$group_field->metadata_name}"] = $group_field->getTitle();
		}
	
		$languages = ['en'];
		$languages[] = get_current_language();
		$languages[] = elgg_get_config('language');
		array_unique($languages);
	
		foreach ($languages as $lang) {
			add_translation($lang, $translations);
		}
	
		return $result;
	}
	
	/**
	 * Hook to add a system category to the profile fields
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $params       hook parameters
	 *
	 * @return array
	 */
	public static function addAdminFields($hook_name, $entity_type, $return_value, $params) {
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		if (elgg_get_plugin_setting('display_system_category', 'profile_manager') !== 'yes') {
			return;
		}
		
		$edit = elgg_extract('edit', $params);
		$register = elgg_extract('register', $params);

		if ($edit || $register) {
			return;
		}

		// optionally add the system fields for admins
		$result = $return_value;
		
		$result['categories'][-1] = '';
		$result['fields'][-1] = [];

		$system_fields = [
			'guid' => 'text',
			'owner_guid' => 'text',
			'container_guid' => 'text',
			'site_guid' => 'text',

			'time_created' => 'date',
			'time_updated' => 'date',
			'last_action' => 'date',
			'prev_last_login' => 'date',
			'last_login' => 'date',

			'admin_created' => 'text',
			'created_by_guid' => 'text',
			'validated' => 'text',
			'validated_method' => 'text',

			'username' => 'text',
			'email' => 'text',
			'language' => 'text',
			'icontime' => 'text',
			'code' => 'text'
		];

		foreach ($system_fields as $metadata_name => $metadata_type) {
			$system_field = new \ColdTrick\ProfileManager\CustomProfileField();

			$system_field->metadata_name = $metadata_name;
			$system_field->metadata_type = $metadata_type;

			$result['fields'][-1][] = $system_field;
		}
	
		return $result;
	}
}
