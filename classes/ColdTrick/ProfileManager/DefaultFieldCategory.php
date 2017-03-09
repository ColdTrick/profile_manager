<?php

namespace ColdTrick\ProfileManager;

class DefaultFieldCategory extends CustomFieldCategory {

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();
		$this->temp_metadata['metadata_name'] = 'default';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTitle() {
		return elgg_echo('profile_manager:categories:list:default');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLinkedProfileTypes() {
		$result = elgg_get_entities([
			'types' => 'object',
			'subtypes' => CustomProfileType::SUBTYPE,
			'limit' => 0,
		]);

		return $result ? : [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function save() {
		return false;
	}
}
