<?php
/**
 * ProfileManagerCustomFieldCategory
 *
 * @package ProfileManager
 *
 */
class ProfileManagerCustomFieldCategory extends ElggObject {

	const SUBTYPE = "custom_profile_field_category";
	
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
		// make title
		$title = $this->metadata_label;
		
		if (empty($title)) {
			if (elgg_language_key_exists("profile:categories:{$this->metadata_name}")) {
				$title = elgg_echo("profile:categories:{$this->metadata_name}");
			} else {
				$title = $this->metadata_name;
			}
		}
		
		return $title;
	}

	/**
	 * Returns an array of linked profile type guids
	 *
	 * @return void
	 */
	public function getLinkedProfileTypes() {
		$types = $this->getEntitiesFromRelationship(array(
			'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
			'inverse_relationship' => true,
			'limit' => false
		));
		
		if ($types) {
			$result = array();
			
			foreach ($types as $type) {
				$result[] = $type->getGUID();
			}
		} else {
			// return 0 as the default
			$result = array(0);
		}
		
		return $result;
	}
}
