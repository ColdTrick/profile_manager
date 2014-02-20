<?php
/**
 * Group profile fields
 */

$group = $vars['entity'];

$group_fields = profile_manager_get_categorized_group_fields();
		
if (count($group_fields["fields"]) > 0) {
	$group_fields = $group_fields["fields"];
	$even_odd = 'odd';
	
	foreach ($group_fields as $field) {
		$metadata_name = $field->metadata_name;
		$value = $group->$metadata_name;
		
		if ($value) {
			// make title
			$title = $field->getTitle();
			
			// adjust output type
			if ($field->output_as_tags == "yes") {
				$output_type = "tags";
				$value = string_to_tag_array($value);
			} else {
				$output_type = $field->metadata_type;
			}
			
			if ($field->metadata_type == "url") {
				$target = "_blank";
			} else {
				$target = null;
			}
	
			echo "<div class=\"{$even_odd}\">";
			echo "<b>";
			echo $title;
			echo ": </b>";
			echo elgg_view("output/$output_type",  array('value' => $value, "target" => $target));
			echo "</div>";
			
			$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
		}
	}
}
