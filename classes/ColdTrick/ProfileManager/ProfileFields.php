<?php

namespace ColdTrick\ProfileManager;

/**
 * ProfileFields
 */
class ProfileFields {

	/**
	 * Returns fields config for users
	 *
	 * @param \Elgg\Hook $hook 'fields' 'user:user|group:group'
	 *
	 * @return array
	 */
	public static function getFields(\Elgg\Hook $hook) {
		
		// get from cache
		$entities = elgg_load_system_cache("profile_manager_{$hook->getType()}_fields");
		if ($entities === null) {
			$subtype = \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE;
			if ($hook->getType() === 'group:group') {
				$subtype = \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE;
			}
			
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => $subtype,
				'limit' => false,
				'owner_guid' => elgg_get_config('site_guid'),
			]);
			elgg_save_system_cache("profile_manager_{$hook->getType()}_fields", $entities);
		}
		
		if (empty($entities)) {
			return;
		}
		
		_elgg_services()->metadataCache->populateFromEntities($entities);
		
		$result = [];
		if ($hook->getType() === 'group:group') {
			$result[] = [
				'name' => 'name',
				'#type' => 'text',
			];
		}

		// order fields
		$ordered_entities = [];
		foreach ($entities as $entity) {
			if ($entity->admin_only !== 'yes' || (elgg_is_admin_logged_in() || elgg_get_ignore_access())) {
				$ordered_entities[$entity->order] = $entity;
			}
		}
		ksort($ordered_entities);
		self::registerFieldTranslations($ordered_entities);

		// make new result
		foreach ($ordered_entities as $entity) {
			$result[] = [
				'#type' => $entity->metadata_type,
				'#label' => $entity->getDisplayName(),
				'name' => $entity->metadata_name,
			];
		}
		
		if (!empty($result) && $hook->getType() === 'user:user') {
			$result[] = [
				'#type' => 'hidden',
				'name' => 'custom_profile_type',
			];
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
			foreach ($fields as $field) {
				
				$key = ($field instanceof CustomGroupField) ? "groups:{$field->metadata_name}" : "profile:{$field->metadata_name}";
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
