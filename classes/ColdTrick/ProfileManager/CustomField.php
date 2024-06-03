<?php

namespace ColdTrick\ProfileManager;

/**
 * CustomField
 *
 * @property string $admin_only           field is only for admins (yes|no)
 * @property string $blank_available      add a blank option (yes|no)
 * @property string $metadata_name        metadata name of the profile field
 * @property string $metadata_label       label of the profile field
 * @property string $metadata_input_label label of the profile field during editing
 * @property string $metadata_hint        hint/help text
 * @property string $metadata_placeholder input placeholder
 * @property string $metadata_type        input type
 * @property string $metadata_options     input options
 * @property int    $order                order of the profile field
 * @property string $output_as_tags       show the output as tags (yes|no)
 * @property string $show_on_profile      show on the profile (yes|no)
 */
abstract class CustomField extends \ElggObject {
	
	/**
	 * {@inheritdoc}
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
	 * @param bool $add_blank_option optional boolean if there should be an extra empty option added
	 *
	 * @return array|null
	 */
	public function getOptions(bool $add_blank_option = false): ?array {
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
		
		return array_combine($options, $options); // add values as labels for deprecated notices
	}
	
	/**
	 * Returns the hint text
	 *
	 * @return string
	 */
	public function getHint(): string {
		$result = $this->metadata_hint;
		
		if (empty($result) && elgg_language_key_exists("profile:hint:{$this->metadata_name}")) {
			$result = elgg_echo("profile:hint:{$this->metadata_name}");
		}
		
		return (string) $result;
	}

	/**
	 * Returns the placeholder text
	 *
	 * @return string
	 */
	public function getPlaceholder(): string {
		$result = $this->metadata_placeholder;
		
		if (empty($result) && elgg_language_key_exists("profile:placeholder:{$this->metadata_name}")) {
			$result = elgg_echo("profile:placeholder:{$this->metadata_name}");
		}
		
		return (string) $result;
	}

	/**
	 * Checks if can show on profile
	 *
	 * @return bool
	 */
	public function showOnProfile(): bool {
		return $this->show_on_profile !== 'no';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function delete(bool $recursive = true, bool $persistent = null): bool {
		$deleted = parent::delete($recursive, $persistent);
		if ($deleted) {
			elgg_delete_system_cache('profile_manager_user:user_fields');
			elgg_delete_system_cache('profile_manager_group:group_fields');
		}
		
		return $deleted;
	}
}
