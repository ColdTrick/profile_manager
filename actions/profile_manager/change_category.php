<?php
/**
 * Profile Manager
 *
 * jQuery Profile Field change category
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

use ColdTrick\ProfileManager\CustomField;

$guid = (int) get_input('guid');
$category_guid = (int) get_input('category_guid');

$entity = get_entity($guid);
if (!$entity instanceof CustomField) {
	return elgg_error_response(elgg_echo('profile_manager:actions:change_category:error:unknown'));
}

if (!empty($category_guid)) {
	$entity->category_guid = $category_guid;
} else {
	unset($entity->category_guid);
}

// trigger memcache update
$entity->save();
