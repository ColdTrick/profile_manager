<?php
/**
 * Group profile fields
 */

$group = $vars['entity'];

$group_fields = profile_manager_get_categorized_group_fields();
		
$group_fields = elgg_extract('fields', $group_fields);

if (empty($group_fields)) {
	return;
}

$even_odd = 'odd';

foreach ($group_fields as $field) {
	$metadata_name = $field->metadata_name;
	$value = $group->$metadata_name;
	
	if (is_null($value)) {
		continue;
	}
	
	// make title
	$title = $field->getTitle();
	
	// adjust output type
	if ($field->output_as_tags == 'yes') {
		$output_type = 'tags';
		$value = string_to_tag_array($value);
	} else {
		$output_type = $field->metadata_type;
	}
	
	if ($field->metadata_type == 'url') {
		$target = '_blank';
	} else {
		$target = null;
	}

	echo "<div class='{$even_odd}'>";
	echo '<b>';
	echo $title;
	echo ': </b>';
	echo elgg_view("output/{$output_type}",  ['value' => $value, 'target' => $target]);
	echo '</div>';
	
	$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
}