<?php
/**
 * ProfileManagerCustomGroupField
 *
 * @package ProfileManager
 *
 */
class ProfileManagerCustomGroupField extends ProfileManagerCustomField {

	const SUBTYPE = "custom_group_field";
	
	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
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
			if (elgg_language_key_exists("groups:{$this->metadata_name}")) {
				$title = elgg_echo("groups:{$this->metadata_name}");
			} else {
				$title = $this->metadata_name;
			}
		}
		
		return $title;
	}
}
