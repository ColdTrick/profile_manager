<?php

namespace ColdTrick\ProfileManager;

/**
 * Menus
 */
class Menus {

	/**
	 * Add admin menu items
	 *
	 * @param string $hook        hook name
	 * @param string $entity_type hook type
	 * @param array  $returnvalue current return value
	 * @param array  $params      parameters
	 *
	 * @return array
	 */
	public static function registerAdmin($hook, $entity_type, $returnvalue, $params) {
		if (!elgg_in_context('admin') || !elgg_is_admin_logged_in()) {
			return;
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'users:export',
			'text' => elgg_echo('admin:users:export'),
			'href' => 'admin/users/export',
			'context' => 'admin',
			'parent_name' => 'users',
			'section' => 'administer',
		]);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'users:inactive',
			'text' => elgg_echo('admin:users:inactive'),
			'href' => 'admin/users/inactive',
			'context' => 'admin',
			'parent_name' => 'users',
			'section' => 'administer',
		]);
		
		if (elgg_is_active_plugin('groups')) {
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'appearance:group_fields',
				'text' => elgg_echo('admin:appearance:group_fields'),
				'href' => 'admin/appearance/group_fields',
				'context' => 'admin',
				'parent_name' => 'appearance',
				'section' => 'configure',
			]);
		}
		
		return $returnvalue;
	}
	
}