<?php

namespace ColdTrick\ProfileManager;

/**
 * CustomFieldCategory
 *
 * @property string $metadata_label readable label of the category
 * @property string $metadata_name  name of the category
 * @property int    $order          order of the category
 */
class CustomFieldCategory extends \ElggObject {

	const SUBTYPE = 'custom_profile_field_category';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = elgg_get_site_entity()->guid;
		$this->attributes['container_guid'] = elgg_get_site_entity()->guid;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		if ($this->metadata_label) {
			return (string) $this->metadata_label;
		}
		
		if (elgg_language_key_exists("profile:categories:{$this->metadata_name}")) {
			return elgg_echo("profile:categories:{$this->metadata_name}");
		}
		
		return (string) $this->metadata_name;
	}

	/**
	 * Returns an array of linked profile type guids
	 *
	 * @return array
	 */
	public function getLinkedProfileTypes(): array {
		$types = $this->getEntitiesFromRelationship([
			'relationship' => \ColdTrick\ProfileManager\CustomProfileType::CATEGORY_RELATIONSHIP,
			'inverse_relationship' => true,
			'limit' => false
		]);
		
		if (empty($types)) {
			// return 0 as the default
			return [0];
		}
		
		$result = [];
				
		foreach ($types as $type) {
			$result[] = $type->guid;
		}
		
		return $result;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function delete(bool $recursive = true, bool $persistent = null): bool {
		$guid = $this->guid;
		
		$deleted = parent::delete($recursive, $persistent);
		
		if ($deleted) {
			// remove reference to this category on related profile fields
			$fields = elgg_get_entities([
				'type' => 'object',
				'subtype' => \ColdTrick\ProfileManager\CustomProfileField::SUBTYPE,
				'limit' => false,
				'owner_guid' => elgg_get_site_entity()->guid,
				'metadata_name_value_pairs' => [
					'name' => 'category_guid',
					'value' => $guid,
				],
				'batch' => true,
				'batch_inc_offset' => false,
			]);
			
			foreach ($fields as $field) {
				unset($field->category_guid);
			}
		}
		
		return $deleted;
	}
}
