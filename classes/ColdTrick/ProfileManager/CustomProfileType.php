<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomProfileType
 */
class CustomProfileType extends \ElggObject {

	const SUBTYPE = 'custom_profile_type';
	
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
	 * Returns the title of the type
	 *
	 * @return string
	 */
	public function getTitle() {
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:types:{$this->metadata_name}")) {
			return elgg_echo("profile:types:{$this->metadata_name}");
		}
		
		return $this->metadata_name;
	}

	/**
	 * Returns the description (potentially translated) of the type
	 *
	 * @return string
	 */
	public function getDescription() {
		$description = $this->metadata_description;
		if (empty($description) && elgg_language_key_exists("profile:types:{$this->metadata_name}:description")) {
			$description = elgg_echo("profile:types:{$this->metadata_name}:description");
		}
		
		return $description;
	}
}
