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
}