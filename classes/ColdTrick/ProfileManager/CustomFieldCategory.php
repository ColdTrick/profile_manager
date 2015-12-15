<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomFieldCategory
 */
class CustomFieldCategory extends \ElggObject {

	const SUBTYPE = 'custom_profile_field_category';
	
	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
		$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
	}

	/**
	 * Returns the title of the category
	 *
	 * @return string
	 */
	public function getTitle() {
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:categories:{$this->metadata_name}")) {
			return elgg_echo("profile:categories:{$this->metadata_name}");
		}
		
		return $this->metadata_name;
	}

	/**
	 * Returns an array of linked profile type guids
	 *
	 * @return void
	 */
	public function getLinkedProfileTypes() {
		$types = $this->getEntitiesFromRelationship([
			'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
			'inverse_relationship' => true,
			'limit' => false
		]);
		
		if (empty($types)) {
			// return 0 as the default
			return [0];
		}
		
		$result = [];
				
		foreach ($types as $type) {
			$result[] = $type->getGUID();
		}
		
		return $result;
	}
}
