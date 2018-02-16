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
			'name' => 'users:inactive',
			'text' => elgg_echo('admin:users:inactive'),
			'href' => 'admin/users/inactive',
			'context' => 'admin',
			'parent_name' => 'users',
			'section' => 'administer',
		]);
		
		if (elgg_is_active_plugin('groups')) {
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'configure_utilities:group_fields',
				'text' => elgg_echo('admin:configure_utilities:group_fields'),
				'href' => 'admin/configure_utilities/group_fields',
				'context' => 'admin',
				'parent_name' => 'configure_utilities',
				'section' => 'configure',
			]);
		}
		
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
			'text' => elgg_echo('reset'),
			'title' => elgg_echo('profile_manager:actions:reset:description'),
			'href' => elgg_generate_action_url('profile_manager/reset', [
				'type' => $type,
			]),
			'confirm' => elgg_echo('profile_manager:actions:reset:confirm'),
			'class' => 'elgg-button elgg-button-action',
		]);
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'import_default',
			'text' => elgg_echo('profile_manager:actions:import:from_default'),
			'title' => elgg_echo('profile_manager:actions:import:from_default:description'),
			'href' => elgg_generate_action_url('profile_manager/import_from_default', [
				'type' => $type,
			]),
			'confirm' => elgg_echo('profile_manager:actions:import:from_default:confirm'),
			'class' => 'elgg-button elgg-button-action',
		]);
		
		if ($type === 'profile') {
			$items[] = \ElggMenuItem::factory([
				'name' => 'import_custom',
				'text' => elgg_echo('profile_manager:actions:import:from_custom'),
				'title' => elgg_echo('profile_manager:actions:import:from_custom:description'),
				'href' => elgg_generate_action_url('profile_manager/import_from_custom'),
				'confirm' => elgg_echo('profile_manager:actions:import:from_custom:confirm'),
				'class' => 'elgg-button elgg-button-action',
			]);
		}
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'backup',
			'text' => elgg_echo('profile_manager:actions:configuration:backup'),
			'href' => elgg_generate_action_url('profile_manager/configuration/backup', [
				'fieldtype' => $fieldtype,
			]),
			'confirm' => elgg_echo('profile_manager:actions:configuration:backup:description'),
			'class' => 'elgg-button elgg-button-action',
		]);
		
		$items[] = \ElggMenuItem::factory([
			'name' => 'restore',
			'text' => elgg_echo('profile_manager:actions:configuration:restore'),
			'href' => elgg_http_add_url_query_elements('ajax/view/forms/profile_manager/restore_fields', [
				'fieldtype' => $fieldtype,
			]),
			'class' => 'elgg-lightbox elgg-button elgg-button-action',
		]);
		
		return $items;
	}
}
