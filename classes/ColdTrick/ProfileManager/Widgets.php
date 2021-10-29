<?php

namespace ColdTrick\ProfileManager;

/**
 * Widgets
 */
class Widgets {
		
	/**
	 * Adds the profile completeness widget type
	 *
	 * @param \Elgg\Hook $hook 'handlers', 'widgets'
	 *
	 * @return array
	 */
	public static function registerProfileCompleteness(\Elgg\Hook $hook) {
		if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') !== 'yes') {
			return;
		}
		
		$result = $hook->getValue();
		$result[] = \Elgg\WidgetDefinition::factory([
			'id' => 'profile_completeness',
			'context' => ['profile', 'dashboard'],
		]);
		
		return $result;
	}
}
