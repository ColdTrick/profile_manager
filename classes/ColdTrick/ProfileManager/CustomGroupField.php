<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomGroupField
 */
class CustomGroupField extends CustomField {

	const SUBTYPE = 'custom_group_field';
	
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
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("groups:{$this->metadata_name}")) {
			return elgg_echo("groups:{$this->metadata_name}");
		}
		
		return $this->metadata_name;
	}
}
