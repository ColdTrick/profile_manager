<?php

$owner = $vars['entity']->getOwnerEntity();
$tips = '';

if ($owner->getGUID() === elgg_get_logged_in_user_guid()) {
	$completeness = profile_manager_profile_completeness($owner);
	$percentage_complete = $completeness['percentage_completeness'];

	// save the percentage
	$owner->profile_completeness_percentage = $percentage_complete;
	
	$missing_fields = $completeness['missing_fields'];
	
	if (count($missing_fields) > 0) {
		$rand_key = array_rand($missing_fields);
		$field = $missing_fields[$rand_key];
		
		$tips = elgg_echo('widgets:profile_completeness:view:tips', ['<b>' . $field->getTitle() . '</b>']);
	} else {
		$tips = elgg_echo('widgets:profile_completeness:view:complete');
	}
} else {
	if ($owner->profile_completeness_percentage) {
		$percentage_complete = $owner->profile_completeness_percentage;
	} else {
		$completeness = profile_manager_profile_completeness($owner);
		$percentage_complete = $completeness["percentage_completeness"];
	}
}

$progress = elgg_format_element('div', ['id' => 'widget_profile_completeness_progress'], "{$percentage_complete}%");
$progress .= elgg_format_element('div', ['id' => 'widget_profile_completeness_progress_bar', 'style' => "width: {$percentage_complete}%;"]);

echo elgg_format_element('div', ['id' => 'widget_profile_completeness_container'], $progress);
echo $tips;
