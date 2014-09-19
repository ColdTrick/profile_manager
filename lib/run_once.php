<?php
/**
 * Run Once functions for Profile Manager
 */

/**
 * Fixes a bug in previous profile manager versions that made all fields on register have access_id -1 instead of default access
 *
 * @return void
 */
function profile_manager_fix_access_default() {
	$dbprefix = elgg_get_config("dbprefix");
	
	update_data("UPDATE {$dbprefix}metadata set access_id='" . ACCESS_LOGGED_IN . "' WHERE access_id=" . ACCESS_DEFAULT);
}

/**
 * Run once function
 *
 * @return void
 */
function profile_manager_run_once() {
	$dbprefix = elgg_get_config("dbprefix");
	
	// upgrade class names for subtypes
	$profile_field_class_name = "ProfileManagerCustomProfileField";
	$group_field_class_name = "ProfileManagerCustomGroupField";
	$field_type_class_name = "ProfileManagerCustomProfileType";
	$field_category_class_name = "ProfileManagerCustomFieldCategory";
	
	if ($id = get_subtype_id('object', ProfileManagerCustomProfileField::SUBTYPE)) {
		update_data("UPDATE {$dbprefix}entity_subtypes set class='$profile_field_class_name' WHERE id=$id");
	} else {
		add_subtype('object', ProfileManagerCustomProfileField::SUBTYPE, $profile_field_class_name);
	}
	
	if ($id = get_subtype_id('object', ProfileManagerCustomGroupField::SUBTYPE)) {
		update_data("UPDATE {$dbprefix}entity_subtypes set class='$group_field_class_name' WHERE id=$id");
	} else {
		add_subtype('object', ProfileManagerCustomGroupField::SUBTYPE, $group_field_class_name);
	}
	
	if ($id = get_subtype_id('object', ProfileManagerCustomProfileType::SUBTYPE)) {
		update_data("UPDATE {$dbprefix}entity_subtypes set class='$field_type_class_name' WHERE id=$id");
	} else {
		add_subtype('object', ProfileManagerCustomProfileType::SUBTYPE, $field_type_class_name);
	}
	
	if ($id = get_subtype_id('object', ProfileManagerCustomFieldCategory::SUBTYPE)) {
		update_data("UPDATE {$dbprefix}entity_subtypes set class='$field_category_class_name' WHERE id=$id");
	} else {
		add_subtype('object', ProfileManagerCustomFieldCategory::SUBTYPE, $field_category_class_name);
	}
	
	// update ownerships of profile manager field configuration
	// owner should be site instead of a user (prevents problems when upgrading)
	// Added in Profile Manager v5.6
	
	$options = array(
			"type" => "object",
			"subtypes" => array(
					ProfileManagerCustomProfileField::SUBTYPE,
					ProfileManagerCustomGroupField::SUBTYPE,
					ProfileManagerCustomProfileType::SUBTYPE,
					ProfileManagerCustomFieldCategory::SUBTYPE
				),
			"limit" => false
		);
	$entities = elgg_get_entities($options);
	foreach ($entities as $entity) {
		$entity->owner_guid = $entity->site_guid;
		$entity->container_guid = $entity->site_guid;
		$entity->save();
	}
}
