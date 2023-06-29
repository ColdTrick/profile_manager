<?php

namespace ColdTrick\ProfileManager;

/**
 * CustomGroupField
 */
class CustomGroupField extends CustomField {

	const SUBTYPE = 'custom_group_field';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		if ($this->metadata_label) {
			return (string) $this->metadata_label;
		}
		
		if (elgg_language_key_exists("groups:{$this->metadata_name}")) {
			return elgg_echo("groups:{$this->metadata_name}");
		}
		
		return (string) $this->metadata_name;
	}
}
