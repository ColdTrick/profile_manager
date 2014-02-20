<?php
/**
* Profile Manager
*
* jQuery call to reorder the Custom Fields
*
* @param ordering (array of guids)
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$ordering = get_input("elgg-object");

if (!empty($ordering) && is_array($ordering)) {
	foreach ($ordering as $order => $guid) {
		$entity = get_entity($guid);
		if ($entity instanceof ProfileManagerCustomField) {
			$entity->order = $order + 1;
			
			// trigger memcache update
			$entity->save();
		}
	}
}

exit();
