<?php
/**
 * ProfileManagerCustomProfileType
 *
 * @package ProfileManager
 *
 */
class ProfileManagerCustomProfileType extends ElggObject {

	const SUBTYPE = "custom_profile_type";
	
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
		// make title
		$title = $this->metadata_label;

		if (empty($title)) {
			$trans_key = "profile:types:" . $this->metadata_name;
			if ($trans_key != elgg_echo($trans_key)) {
				$title = elgg_echo($trans_key);
			} else {
				$title = $this->metadata_name;
			}
		}
		
		return $title;
	}

	/**
	 * Returns the description (potentially translated) of the type
	 *
	 * @return string
	 */
	public function getDescription() {
		$description = $this->metadata_description;
		if (empty($description)) {
			$trans_key = "profile:types:" . $this->metadata_name . ":description";
			if ($trans_key != elgg_echo($trans_key)) {
				$description = elgg_echo($trans_key);
			}
		}
		
		return $description;
	}
}
