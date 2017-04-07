<?php

namespace ColdTrick\ProfileManager;

class DefaultProfileType extends CustomProfileType {

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
	public function getTitle($plural = false) {
		return elgg_echo('profile_manager:profile:edit:custom_profile_type:default');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription() {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function save() {
		return false;
	}

}
