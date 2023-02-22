<?php

namespace ColdTrick\ProfileManager;

/**
 * Menus
 */
class Menus {

	/**
	 * Add admin menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return array
	 */
	public static function registerAdmin(\Elgg\Event $event) {
		if (!elgg_in_context('admin') || !elgg_is_admin_logged_in() || !elgg_is_active_plugin('groups')) {
			return;
		}
		
		$returnvalue = $event->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'configure_utilities:group_fields',
			'text' => elgg_echo('admin:configure_utilities:group_fields'),
			'href' => 'admin/configure_utilities/group_fields',
			'context' => 'admin',
			'parent_name' => 'configure_utilities',
		]);
		
		return $returnvalue;
	}
	
	/**
	 * Returns the profile fields actions
	 *
	 * @param \Elgg\Event $event 'register', 'menu:profile_fields'
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function registerProfileFieldsActions(\Elgg\Event $event) {
		
		$type = $event->getParam('type');
		$fieldtype = $event->getParam('fieldtype');
		if (empty($fieldtype) || empty($type)) {
			return;
		}
		
		$items = $event->getValue();
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'reset',
			'icon' => 'refresh',
			'text' => elgg_echo('reset'),
			'title' => elgg_echo('profile_manager:actions:reset:description'),
			'href' => elgg_generate_action_url('profile_manager/reset', [
				'type' => $type,
			]),
			'confirm' => elgg_echo('profile_manager:actions:reset:confirm'),
			'class' => 'elgg-button elgg-button-action',
		]);
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'import_existing',
			'icon' => 'plus-circle',
			'text' => elgg_echo('profile_manager:actions:import:from_existing'),
			'title' => elgg_echo('profile_manager:actions:import:from_existing:description'),
			'href' => elgg_generate_action_url('profile_manager/import_existing', [
				'type' => $type,
			]),
			'confirm' => true,
			'class' => 'elgg-button elgg-button-action',
		]);
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'backup',
			'icon' => 'download',
			'text' => elgg_echo('profile_manager:actions:configuration:backup'),
			'href' => elgg_generate_action_url('profile_manager/configuration/backup', [
				'fieldtype' => $fieldtype,
			]),
			'confirm' => elgg_echo('profile_manager:actions:configuration:backup:description'),
			'class' => 'elgg-button elgg-button-action',
		]);
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'restore',
			'icon' => 'upload',
			'text' => elgg_echo('profile_manager:actions:configuration:restore'),
			'href' => elgg_http_add_url_query_elements('ajax/view/forms/profile_manager/restore_fields', [
				'fieldtype' => $fieldtype,
			]),
			'class' => 'elgg-lightbox elgg-button elgg-button-action',
		]);
		
		return $items;
	}
}
