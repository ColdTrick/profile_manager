<?php

namespace ColdTrick\ProfileManager;

/**
 * ProfileFields
 */
class ProfileFields {

	/**
	 * Returns fields config for users
	 *
	 * @param \Elgg\Event $event 'fields' 'user:user|group:group'
	 *
	 * @return array
	 */
	public static function getFields(\Elgg\Event $event) {
		
		// get from cache
		$entities = elgg_load_system_cache("profile_manager_{$event->getType()}_fields");
		if ($entities === null) {
			$subtype = \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE;
			if ($event->getType() === 'group:group') {
				$subtype = \ColdTrick\ProfileManager\CustomGroupField::SUBTYPE;
			}
			
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => $subtype,
				'limit' => false,
				'owner_guid' => elgg_get_site_entity()->guid,
			]);
			elgg_save_system_cache("profile_manager_{$event->getType()}_fields", $entities);
		}
		
		if (empty($entities)) {
			return;
		}
		
		_elgg_services()->metadataCache->populateFromEntities($entities);
		
		$result = [];
		if ($event->getType() === 'group:group') {
			$result[] = [
				'name' => 'name',
				'#type' => 'text',
				'#label' => elgg_echo('groups:name'),
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
				'placeholder' => $entity->getPlaceholder(),
			];
		}
		
		if (!empty($result) && $event->getType() === 'user:user') {
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
	protected static function registerFieldTranslations(array $fields = []): void {
		$languages = ['en'];
		$languages[] = elgg_get_current_language();
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
			
			elgg()->translator->addTranslation($lang, $translations);
		}
	}
	
	/**
	 * Registers the field types available for the configuration of user profile fields
	 *
	 * @param \Elgg\Event $event 'types:custom_profile_field', 'profile_manager'
	 *
	 * @return array
	 */
	public static function registerUserProfileFieldTypes(\Elgg\Event $event) {
		$result = $event->getValue();
		
		$standard_options = [
			'show_on_register' => true,
			'mandatory' => true,
			'user_editable' => true,
			'output_as_tags' => true,
			'admin_only' => true,
			'count_for_completeness' => true,
		];
		
		$result[] = FieldType::factory([
			'type' => 'text',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'longtext',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'tags',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'location',
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'url',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'email',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'tel',
			'name' => elgg_echo('profile_manager:admin:options:tel'),
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'date',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'dropdown',
			'name' => elgg_echo('profile_manager:admin:options:dropdown'),
			'options' => array_merge($standard_options, [
				'blank_available' => true,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'radio',
			'name' => elgg_echo('profile_manager:admin:options:radio'),
			'options' => array_merge($standard_options, [
				'blank_available' => true,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'multiselect',
			'name' => elgg_echo('profile_manager:admin:options:multiselect'),
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'pm_rating',
			'name' => elgg_echo('profile_manager:admin:options:pm_rating'),
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'pm_twitter',
			'name' => elgg_echo('profile_manager:admin:options:pm_twitter'),
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'pm_facebook',
			'name' => elgg_echo('profile_manager:admin:options:pm_facebook'),
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'pm_linkedin',
			'name' => elgg_echo('profile_manager:admin:options:pm_linkedin'),
			'options' => array_merge($standard_options, [
				'output_as_tags' => false,
			]),
		]);
				
		return $result;
	}
	
	/**
	 * Registers the field types available for the configuration of group profile fields
	 *
	 * @param \Elgg\Event $event 'types:custom_group_field', 'profile_manager'
	 *
	 * @return array
	 */
	public static function registerGroupProfileFieldTypes(\Elgg\Event $event) {
		$result = $event->getValue();
		
		$standard_options = [
			'output_as_tags' => true,
			'admin_only' => true,
		];
		
		$result[] = FieldType::factory([
			'type' => 'text',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'longtext',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'tags',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'url',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'email',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'tel',
			'name' => elgg_echo('profile_manager:admin:options:tel'),
			'options' => ['admin_only' => true],
		]);
		$result[] = FieldType::factory([
			'type' => 'date',
			'options' => $standard_options,
		]);
		$result[] = FieldType::factory([
			'type' => 'location',
			'options' => ['admin_only' => true],
		]);
		$result[] = FieldType::factory([
			'type' => 'dropdown',
			'name' => elgg_echo('profile_manager:admin:options:dropdown'),
			'options' => array_merge($standard_options, [
				'blank_available' => true,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'radio',
			'name' => elgg_echo('profile_manager:admin:options:radio'),
			'options' => array_merge($standard_options, [
				'blank_available' => true,
			]),
		]);
		$result[] = FieldType::factory([
			'type' => 'multiselect',
			'name' => elgg_echo('profile_manager:admin:options:multiselect'),
			'options' => $standard_options,
		]);
		
		return $result;
	}
}
