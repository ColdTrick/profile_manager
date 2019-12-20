<?php

namespace ColdTrick\ProfileManager;

/**
 * ProfileFields
 */
class ProfileFields {

	/**
	 * Hook to replace the profile fields
	 *
	 * @param \Elgg\Hook $hook 'profile:fields', 'profile'
	 *
	 * @return array
	 */
	public static function getUserFields(\Elgg\Hook $hook) {
		$result = [];
	
		// get from cache
		$entities = elgg_load_system_cache('profile_manager_profile_fields');
		if ($entities === null) {
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
				'limit' => false,
				'owner_guid' => elgg_get_config('site_guid'),
			]);
			elgg_save_system_cache('profile_manager_profile_fields', serialize($entities));
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
			}

			$translations["profile:{$entity->metadata_name}"] = $entity;
		}

		self::registerFieldTranslations($translations);

		if (count($result) > 0) {
			$result['custom_profile_type'] = 'hidden';
		}
		
		return $result;
	}
	
	/**
	 * Function to replace group profile fields
	 *
	 * @param \Elgg\Hook $hook 'profile:fields', 'group'
	 *
	 * @return array
	 */
	public static function getGroupFields(\Elgg\Hook $hook) {
	
		// get from cache
		$entities = elgg_load_system_cache('profile_manager_group_fields');
		if ($entities === null) {
			$options = [
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
				'limit' => false,
				'owner_guid' => elgg_get_config('site_guid')
			];
			$entities = elgg_get_entities($options);
			elgg_save_system_cache('profile_manager_group_fields', serialize($entities));
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
		
			$translations["groups:{$group_field->metadata_name}"] = $group_field;
		}
	
		self::registerFieldTranslations($translations);
	
		return $result;
	}
	
	/**
	 * Hook to add a system category to the profile fields
	 *
	 * @param \Elgg\Hook $hook 'categorized_profile_fields', 'profile_manager'
	 *
	 * @return array
	 */
	public static function addAdminFields(\Elgg\Hook $hook) {
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		if (elgg_get_plugin_setting('display_system_category', 'profile_manager') !== 'yes') {
			return;
		}

		if ($hook->getParam('edit') || $hook->getParam('register')) {
			return;
		}

		// optionally add the system fields for admins
		$result = $hook->getValue();
		
		$result['categories'][-1] = '';
		$result['fields'][-1] = [];

		$system_fields = [
			'guid' => 'text',

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
	
	/**
	 * Register translations for profile fields
	 *
	 * @param array $fields Array of translations keys and fields to register
	 *
	 * @return void
	 */
	protected static function registerFieldTranslations($fields = []) {
		$languages = ['en'];
		$languages[] = get_current_language();
		$languages[] = elgg_get_config('language');
		$languages = array_unique($languages);
		
		foreach ($languages as $lang) {
			
			$translations = [];
			foreach ($fields as $key => $field) {
				$title = $field->getDisplayName(false, $lang);
				if (elgg_language_key_exists($key, $lang)) {
					// check if translation registration is needed
					if ($title === elgg_echo($key, [], $lang)) {
						// skip adding if already exists
						continue;
					}
				}
				
				$translations[$key] = $title;
			}
			
			if (empty($translations)) {
				continue;
			}
			
			add_translation($lang, $translations);
		}
	}
}
