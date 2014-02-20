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
			$trans_key = "profile:" . $this->metadata_name;
			if ($trans_key != elgg_echo($trans_key)) {
				$title = elgg_echo($trans_key);
			} else {
				$title = $this->metadata_name;
			}
		}
		return $title;
	}
}
