<?php
/**
 * jQuery call to reorder the Custom Fields
 *
 * @param ordering (array of guids)
 */

$ordering = get_input('elgg-object');

if (empty($ordering) || !is_array($ordering)) {
	return;
}

foreach ($ordering as $order => $guid) {
	$entity = get_entity($guid);
	if ($entity instanceof \ColdTrick\ProfileManager\CustomField) {
		$entity->order = $order + 1;
		
		// trigger memcache update
		$entity->save();
	}
}
