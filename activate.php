<?php
/**
 * Register classes for ElggObject subtypes on plugin activation
 */

$classes = [
	'\ColdTrick\ProfileManager\CustomProfileField',
	'\ColdTrick\ProfileManager\CustomGroupField',
	'\ColdTrick\ProfileManager\CustomProfileType',
	'\ColdTrick\ProfileManager\CustomFieldCategory',
];

foreach ($classes as $class) {
	if (get_subtype_id('object', $class::SUBTYPE)) {
		update_subtype('object', $class::SUBTYPE, $class);
	} else {
		add_subtype('object', $class::SUBTYPE, $class);
	}
}
