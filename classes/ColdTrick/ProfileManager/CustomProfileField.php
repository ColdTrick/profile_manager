<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomProfileField
 */
class CustomProfileField extends CustomField {

	const SUBTYPE = 'custom_profile_field';

	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		
		$this->show_on_register = 'no';
		$this->mandatory = 'no';
		$this->user_editable = 'yes';
	}
	
	/**
	 * Returns the title of the field
	 *
	 * @return string
	 */
	public function getTitle() {
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:{$this->metadata_name}")) {
			return elgg_echo("profile:{$this->metadata_name}");
		}
		
		return $this->metadata_name;
	}
}
