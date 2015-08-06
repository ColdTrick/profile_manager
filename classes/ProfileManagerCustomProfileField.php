<?php
/**
 * ProfileManagerCustomProfileField
 *
 * @package ProfileManager
 *
 */
class ProfileManagerCustomProfileField extends ProfileManagerCustomField {

	const SUBTYPE = "custom_profile_field";

	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * Returns the title of the field
	 *
	 * @return string
	 */
	public function getTitle() {
		// make title
		$title = $this->metadata_label;
		
		if (empty($title)) {
			if (elgg_language_key_exists("profile:{$this->metadata_name}")) {
				$title = elgg_echo("profile:{$this->metadata_name}");
			} else {
				$title = $this->metadata_name;
			}
		}
		return $title;
	}
}
