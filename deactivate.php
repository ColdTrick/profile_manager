<?php
/**
 * Unregister classes for ElggObject subtypes on plugin deactivation
 */

$classes = [
	'\ColdTrick\ProfileManager\CustomProfileField',
	'\ColdTrick\ProfileManager\CustomGroupField',
	'\ColdTrick\ProfileManager\CustomProfileType',
	'\ColdTrick\ProfileManager\CustomFieldCategory',
];

foreach ($classes as $class) {
	update_subtype('object', $class::SUBTYPE);
}
