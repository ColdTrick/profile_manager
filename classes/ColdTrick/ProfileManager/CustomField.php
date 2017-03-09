<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomField
 *
 * @property int $category_guid GUID of the category the field belongs to (null for Default)
 * @property string $metadata_name
 * @property string $metadata_label
 * @property string $metadata_type
 * @property string $metadata_hint
 * @property string $metadata_placeholder
 * @property string|array  $metadata_options
 * @property string $mandatory 'no'|'yes'
 * @property string $user_editable 'no'|'yes'
 * @property string $output_as_tags 'no'|'yes'
 * @property string $show_on_register 'no'|'yes'
 * @property string $admin_only 'no'|'yes'
 * @property string $blank_available 'no'|'yes'
 */
abstract class CustomField extends \ElggObject {
	
	/**
	 * initializes the default class attributes
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
		$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
	}
	
	/**
	 * Returns an array of options to be used in input views
	 *
	 * @param boolean $add_blank_option optional boolean if there should be an extra empty option added
	 *
	 * @return string
	 */
	public function getOptions($add_blank_option = false) {
		$options = '';
		
		// get options
		if (empty($this->metadata_options)) {
			return $options;
		}
			
		$options = explode(',', $this->metadata_options);
		
		if ($this->blank_available == 'yes') {
			// if field has a blank option available, always add the blank option
			$add_blank_option = true;
		}
		
		if ($this->metadata_type != 'multiselect' && $add_blank_option) {
			// optionally add a blank option to the field options
			array_unshift($options, '');
		}
		
		$options = array_combine($options, $options); // add values as labels for deprecated notices
		
		return $options;
	}
	
	/**
	 * Returns the hint text
	 *
	 * @return string
	 */
	public function getHint() {
		$result = $this->metadata_hint;
		
		if (empty($result) && elgg_language_key_exists("profile:hint:{$this->metadata_name}")) {
			$result = elgg_echo("profile:hint:{$this->metadata_name}");
		}
		return $result;
	}

	/**
	 * Returns the placeholder text
	 *
	 * @return string
	 */
	public function getPlaceholder() {
		$result = $this->metadata_placeholder;
		
		if (empty($result) && elgg_language_key_exists("profile:placeholder:{$this->metadata_name}")) {
			$result = elgg_echo("profile:placeholder:{$this->metadata_name}");
		}
		return $result;
	}
}
