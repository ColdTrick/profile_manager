<?php

namespace ColdTrick\ProfileManager\Upgrades;

use ColdTrick\ProfileManager\CustomProfileField;
use Elgg\Upgrade\Result;
use Elgg\Upgrade\SystemUpgrade;

/**
 * Migrates the user profile fields with the type for LinkedIn or Facebook
 */
class MigrateOldFieldTypes extends SystemUpgrade {
	
	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2024060301;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		/* @var $fields \ElggBatch */
		$fields = elgg_get_entities($this->getOptions([
			'offset' => $offset,
		]));
		
		/* @var $field CustomProfileField */
		foreach ($fields as $field) {
			$field->metadata_type = 'url';
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get options for elgg_get_entities()
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 * @see elgg_get_entities()
	 */
	protected function getOptions(array $options = []): array {
		$defaults = [
			'type' => 'object',
			'subtype' => 'custom_profile_field',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => $this->needsIncrementOffset(),
			'metadata_name_value_pairs' => [
				[
					'name' => 'metadata_type',
					'value' => ['pm_facebook', 'pm_linkedin'],
				],
			],
		];
		
		return array_merge($defaults, $options);
	}
}