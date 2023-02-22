<?php

namespace ColdTrick\ProfileManager;

/**
 * Widgets
 */
class Widgets {
		
	/**
	 * Adds the profile completeness widget type
	 *
	 * @param \Elgg\Event $event 'handlers', 'widgets'
	 *
	 * @return array
	 */
	public static function registerProfileCompleteness(\Elgg\Event $event) {
		if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') !== 'yes') {
			return;
		}
		
		$result = $event->getValue();
		
		$result[] = \Elgg\WidgetDefinition::factory([
			'id' => 'profile_completeness',
			'context' => ['profile', 'dashboard'],
		]);
		
		return $result;
	}
}
