<?php

namespace ColdTrick\ProfileManager\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin_header menu
 */
class AdminHeader {
	
	/**
	 * Add admin menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return null|MenuItems
	 */
	public static function registerGroupFields(\Elgg\Event $event): ?MenuItems {
		if (!elgg_in_context('admin') || !elgg_is_admin_logged_in() || !elgg_is_active_plugin('groups')) {
			return null;
		}
		
		/* @var $returnvalue MenuItems */
		$returnvalue = $event->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'configure_utilities:group_fields',
			'text' => elgg_echo('admin:configure_utilities:group_fields'),
			'href' => 'admin/configure_utilities/group_fields',
			'parent_name' => 'configure_utilities',
		]);
		
		return $returnvalue;
	}
}
