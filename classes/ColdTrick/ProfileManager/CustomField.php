<?php
namespace ColdTrick\ProfileManager;

/**
 * CustomField
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
		$this->attributes['owner_guid'] = elgg_get_site_entity()->guid;
		$this->attributes['container_guid'] = elgg_get_site_entity()->guid;
	}
	
	/**
	 * Returns an array of options to be used in input views
	 *
	 * @param boolean $add_blank_option optional boolean if there should be an extra empty option added
	 *
	 * @return array|null
	 */
	public function getOptions($add_blank_option = false) {
		if (empty($this->metadata_options)) {
			return null;
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

	/**
	 * Checks if can show on profile
	 *
	 * @return bool
	 */
	public function showOnProfile() {
		return $this->show_on_profile !== 'no';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function delete($recursive = true) {
		$deleted = parent::delete($recursive);
		if ($deleted) {
			elgg_delete_system_cache('profile_manager_profile_fields');
			elgg_delete_system_cache('profile_manager_group_fields');
		}
		
		return $deleted;
	}
}
