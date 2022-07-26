<?php

namespace ColdTrick\ProfileManager;

/**
 * Menus
 */
class Menus {

	/**
	 * Add admin menu items
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:page'
	 *
	 * @return array
	 */
	public static function registerAdmin(\Elgg\Hook $hook) {
		if (!elgg_in_context('admin') || !elgg_is_admin_logged_in() || !elgg_is_active_plugin('groups')) {
			return;
		}
		
		$returnvalue = $hook->getValue();
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'configure_utilities:group_fields',
			'text' => elgg_echo('admin:configure_utilities:group_fields'),
			'href' => 'admin/configure_utilities/group_fields',
			'context' => 'admin',
			'parent_name' => 'configure_utilities',
			'section' => 'configure',
		]);
		
		return $returnvalue;
	}
	
	/**
	 * Returns the profile fields actions
	 *
	 * @param \Elgg\Hook $hook hook
	 *
	 * @return \ElggMenuItem[]
	 */
	public static function registerProfileFieldsActions(\Elgg\Hook $hook) {
		
		$type = $hook->getParam('type');
		$fieldtype = $hook->getParam('fieldtype');
		if (empty($fieldtype) || empty($type)) {
			return;
		}
		
		$items = $hook->getValue();
		
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
