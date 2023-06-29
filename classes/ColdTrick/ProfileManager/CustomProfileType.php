<?php

namespace ColdTrick\ProfileManager;

/**
 * CustomProfileType
 *
 * @property string $metadata_description  description of the profile type
 * @property string $metadata_label        readable label of the profile type (singular)
 * @property string $metadata_label_plural readable label of the profile type (plural)
 * @property string $metadata_name         name of the profile type
 */
class CustomProfileType extends \ElggObject {

	const SUBTYPE = 'custom_profile_type';
	const CATEGORY_RELATIONSHIP = 'custom_profile_type_category_relationship';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->guid;
		$this->attributes['container_guid'] = elgg_get_site_entity()->guid;
	}

	/**
	 * Returns the title of the type
	 *
	 * @param bool $plural set to true if you want to return the plural form (if available)
	 *
	 * @return string
	 */
	public function getDisplayName(bool $plural = false): string {
		if ($plural) {
			$result = $this->getPluralTitle();
			if (!empty($result)) {
				return $result;
			}
		}
		
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:types:{$this->metadata_name}")) {
			return elgg_echo("profile:types:{$this->metadata_name}");
		}
		
		return $this->metadata_name;
	}
	
	/**
	 * Returns the plural form of the profile type label
	 *
	 * @return string
	 */
	protected function getPluralTitle(): string {
		if ($this->metadata_label_plural) {
			return $this->metadata_label_plural;
		}
		
		if (elgg_language_key_exists("profile:types:{$this->metadata_name}:plural")) {
			return elgg_echo("profile:types:{$this->metadata_name}:plural");
		}
		
		return '';
	}

	/**
	 * Returns the description (potentially translated) of the type
	 *
	 * @return string
	 */
	public function getDescription(): string {
		$description = $this->metadata_description;
		if (empty($description) && elgg_language_key_exists("profile:types:{$this->metadata_name}:description")) {
			$description = elgg_echo("profile:types:{$this->metadata_name}:description");
		}
		
		return (string) $description;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function delete(bool $recursive = true): bool {
		$guid = $this->guid;
		
		$deleted = parent::delete($recursive);
		
		if ($deleted) {
			// remove corresponding profile type metadata from userobjects
			$entities = elgg_get_entities([
				'type' => 'user',
				'limit' => false,
				'batch' => true,
				'batch_inc_offset' => false,
				'metadata_name_value_pairs' => [
					'name' => 'custom_profile_type',
					'value' => $guid,
				],
			]);
			
			foreach ($entities as $entity) {
				// unset currently deleted profile type for user
				unset($entity->custom_profile_type);
			}
		}
		
		return $deleted;
	}
}
