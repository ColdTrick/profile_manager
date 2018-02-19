<?php

namespace ColdTrick\ProfileManager;

/**
 * Sites
 */
class Sites {
		
	/**
	 * Extend public pages
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $params       hook parameters
	 *
	 * @return array
	 */
	public static function publicPages($hook_name, $entity_type, $return_value, $params) {
		$return = $return_value;
		if (is_array($return)) {
			$return[] = 'action/profile_manager/register/validate.*';
		}
		return $return;
	}
}
