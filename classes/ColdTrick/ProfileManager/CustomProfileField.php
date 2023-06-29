<?php

namespace ColdTrick\ProfileManager;

/**
 * CustomProfileField
 *
 * @property string $mandatory            mandatory on the registration form (yes|no)
 * @property string $show_on_register     show on the registration form (yes|no)
 * @property string $user_editable        the user can edit this field (yes|no)
 */
class CustomProfileField extends CustomField {

	const SUBTYPE = 'custom_profile_field';

	/**
	 * {@inheritdoc}
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
	 * @param bool   $input set to true if you need the title for an input field
	 * @param string $lang  (optional) specific language for the title
	 *
	 * @return string
	 */
	public function getDisplayName(bool $input = false, string $lang = null): string {
		if (!isset($lang)) {
			$lang = elgg_get_current_language();
		}
		
		if ($input) {
			if ($this->metadata_input_label) {
				return $this->metadata_input_label;
			}
			
			if (elgg_language_key_exists("profile:{$this->metadata_name}:input", $lang)) {
				return elgg_echo("profile:{$this->metadata_name}:input", [], $lang);
			}
		}
		
		if ($this->metadata_label) {
			return $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:{$this->metadata_name}", $lang)) {
			return elgg_echo("profile:{$this->metadata_name}", [], $lang);
		}
		
		return $this->metadata_name;
	}
}
