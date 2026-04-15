<?php

namespace ColdTrick\ProfileManager\Upgrades;

use Elgg\Upgrade\Result;
use Elgg\Upgrade\SystemUpgrade;

/**
 * Migrates the plugin settings from yes/no to 1/0
 */
class MigratePluginSwitchSettings extends SystemUpgrade {
	
	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2026041501;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return false;
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
		return 1;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		$plugin = elgg_get_plugin_from_id('profile_manager');

		$settings = [
			'generate_username_from_email',
			'show_account_hints',
			'hide_profile_type_default',
			'simple_access_control',
			'show_profile_type_on_profile',
		];

		foreach ($settings as $setting) {
			$current_setting = $plugin->$setting;
			if (!in_array($current_setting, ['yes', 'no'])) {
				continue;
			}
			
			$plugin->$setting = ($current_setting === 'yes');
		}
			
		$result->markComplete();
		
		return $result;
	}
}
