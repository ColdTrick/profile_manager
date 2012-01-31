<?php 

	$owner = $vars["entity"]->getOwnerEntity();
	
	if($owner->getGUID() === elgg_get_logged_in_user_guid()){
		$completeness = profile_manager_profile_completeness($owner);
		$percentage_complete = $completeness["percentage_completeness"];

		// save the percentage
		$owner->profile_completeness_percentage = $percentage_complete;
		
		$missing_fields = $completeness["missing_fields"]; 
		
		if(count($missing_fields) > 0){
			$rand_key = array_rand($missing_fields);
			$field = $missing_fields[$rand_key];
			
			$tips = elgg_echo("widgets:profile_completeness:view:tips", array("<b>" . $field->getTitle() . "</b>"));
		} else {
			$tips = elgg_echo("widgets:profile_completeness:view:complete");
		}
	} else {
		if($owner->profile_completeness_percentage){
			$percentage_complete = $owner->profile_completeness_percentage;
		} else {
			$completeness = profile_manager_profile_completeness($owner);
			$percentage_complete = $completeness["percentage_completeness"];
		}
	}
?>
<div id="widget_profile_completeness_container">
	<div id="widget_profile_completeness_progress">
		<?php echo $percentage_complete; ?>%
	</div>
	<div id="widget_profile_completeness_progress_bar" style="width: <?php echo $percentage_complete; ?>%;"></div>
</div>
<?php 
echo $tips;