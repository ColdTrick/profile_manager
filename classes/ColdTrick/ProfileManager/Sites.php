<?php

namespace ColdTrick\ProfileManager;

/**
 * Sites
 */
class Sites {

	/**
	 * Adds a river event when a user joins the site
	 *
	 * @param string           $event       Event name
	 * @param string           $object_type Event type
	 * @param ElggRelationship $object      Relationship object being created
	 *
	 * @return void
	 */
	public static function createMember($event, $object_type, $object) {
		if ($object->relationship !== 'member_of_site') {
			return;
		}
		
		$enable_river_event = elgg_get_plugin_setting('enable_site_join_river_event', 'profile_manager');
		if ($enable_river_event == 'no') {
			return;
		}
	
		$user_guid = $object->guid_one;
		$site_guid = $object->guid_two;

		// clear current river events
		elgg_delete_river([
			'view' => 'river/relationship/member_of_site/create',
			'subject_guid' => $user_guid,
			'object_guid' => $site_guid,
		]);

		// add new join river event
		elgg_create_river_item([
			'view' => 'river/relationship/member_of_site/create',
			'action_type' => 'join',
			'subject_guid' => $user_guid,
			'object_guid' => $site_guid,
		]);
	}
	
	/**
	 * Remove river join event on site leave
	 *
	 * @param string           $event       Event name
	 * @param string           $object_type Event type
	 * @param ElggRelationship $object      Relationship object being removed
	 *
	 * @return void
	 */
	public static function deleteMember($event, $object_type, $object) {
		if ($object->relationship !== 'member_of_site') {
			return;
		}
		
		elgg_delete_river([
			'view' => 'river/relationship/member_of_site/create',
			'subject_guid' => $object->guid_one,
			'object_guid' => $object->guid_two,
		]);
	}
	
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