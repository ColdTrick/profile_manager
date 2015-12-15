<?php

namespace ColdTrick\ProfileManager;

/**
 * Groups
 */
class Groups {
	
	/**
	 * Increments edit counter for name editing
	 *
	 * @param string     $event       Event name
	 * @param string     $object_type Event type
	 * @param ElggObject $object      Group that is being edited
	 *
	 * @return void
	 */
	public static function nameIncrement($event, $object_type, $object) {
		if (elgg_instanceof($object, "group")) {
			$count = (int) $object->getPrivateSetting("profile_manager_name_edit_count");
			$object->setPrivateSetting("profile_manager_name_edit_count", $count + 1);
		}
	
		// only do this once
		elgg_unregister_event_handler("update", "group", "\ColdTrick\ProfileManager\Groups::nameIncrement");
	}
	
	/**
	 * Increments edit counter for description editing
	 *
	 * @param string     $event       Event name
	 * @param string     $object_type Event type
	 * @param ElggObject $object      Group that is being edited
	 *
	 * @return void
	 */
	public static function descriptionIncrement($event, $object_type, $object) {
		if (elgg_instanceof($object, "group")) {
			$count = (int) $object->getPrivateSetting("profile_manager_description_edit_count");
			$object->setPrivateSetting("profile_manager_description_edit_count", $count + 1);
		}
	
		// only do this once
		elgg_unregister_event_handler("update", "group", "\ColdTrick\ProfileManager\Groups::descriptionIncrement");
	}
	
	/**
	 * Enforcing group edit limits
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $params       hook parameters
	 *
	 * @return void
	 */
	public static function groupsEdit($hook_name, $entity_type, $return_value, $params) {
		$guid = get_input("group_guid");
		if (!empty($guid) || !elgg_is_admin_logged_in()) {
	
			$group = get_entity($guid);
	
			if (elgg_instanceof($group, "group")) {
				$name_input = get_input("name", false);
				$description_input = get_input("description", false);
					
				if (($name_input !== false) && ($name_input !== $group->name)) {
					$limit = elgg_get_plugin_setting("group_limit_name", "profile_manager");
	
					if (!empty($limit) || ($limit == "0")) {
						$limit = (int) $limit;
						$count = (int) $group->getPrivateSetting("profile_manager_name_edit_count");
							
						if ($count < $limit) {
							// register function to increment count on succesful edit
							elgg_register_event_handler("update", "group", "\ColdTrick\ProfileManager\Groups::nameIncrement");
						} else {
							// group name needs special treatment
							$name = htmlspecialchars_decode($group->name, ENT_QUOTES);
	
							// cannot be changed, so reset to current value
							set_input("name", $name);
						}
					}
				}
					
				if (($description_input !== false) && ($description_input !== $group->description)) {
					$limit = elgg_get_plugin_setting("group_limit_description", "profile_manager");
	
					if (!empty($limit) || ($limit == "0")) {
						$limit = (int) $limit;
						$count = (int) $group->getPrivateSetting("profile_manager_description_edit_count");
							
						if ($count < $limit) {
							// register function to increment count on succesful edit
							elgg_register_event_handler("update", "group", "\ColdTrick\ProfileManager\Groups::descriptionIncrement");
						} else {
							// cannot be changed, so reset to current value
							set_input("description", $group->description);
						}
					}
				}
			}
		}
	}
}