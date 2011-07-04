<?php
	/**
	* Profile Manager
	* 
	* view to extend the user details
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	$profile_user = $vars["entity"];
	$categorized_fields = profile_manager_get_categorized_fields($profile_user);
	$cats = $categorized_fields['categories'];
	$fields = $categorized_fields['fields'];
	?>
	<script type="text/javascript">
		$('#profile_info_column_middle > p:not(.profile_info_edit_buttons)').remove();
	</script>
	
	<?php 
	
	
	if(count($cats) > 0){
		
		$result .= "<div id='custom_fields_userdetails'>\n";
		
		if($profile_type_guid = $profile_user->custom_profile_type){
			
			if(($profile_type = get_entity($profile_type_guid)) && ($profile_type instanceof ProfileManagerCustomProfileType)){
				
				$result .= "<p class='even'><b>" . elgg_echo("profile_manager:user_details:profile_type") . "</b>: " . $profile_type->getTitle() . " </p>";	
			}
			
		}
				
		// only show category headers if more than 1 category available
		if(count($cats) > 1){
			$show_header = true;
		} else {
			$show_header = false;
		}
		
		foreach($cats as $cat_guid => $cat){
			if($show_header){
				// make nice title
				if($cat_guid == -1){
					$title = elgg_echo("profile_manager:categories:list:system");
				} elseif($cat_guid == 0){
					if(!empty($cat)){
						$title = $cat;
					} else {
						$title = elgg_echo("profile_manager:categories:list:default");
					}
				} elseif($cat instanceof ProfileManagerCustomFieldCategory) {
					$title = $cat->getTitle();
				} else {
					$title = $cat;
				}
				
				$result .= "<h3><span class='accordion-icon'></span>" . $title . "</h3>\n";
			}
			
			$result .= "<div>\n";
			$even_odd = "even";
			
			foreach($fields[$cat_guid] as $field){
				$metadata_name = $field->metadata_name;
				
				if($metadata_name != "description"){
					// give correct class
					if($even_odd != "even"){
						$even_odd = "even";
					} else {
						$even_odd = "odd";
					}
					$result .= "<p class='" . $even_odd . "'>";
					
					// make nice title
					$title = $field->getTitle();
					
					// get user value
					$value = $profile_user->$metadata_name;
					
					// adjust output type
					if($field->output_as_tags == "yes"){
						$output_type = "tags";
					} else {
						$output_type = $field->metadata_type;
					}
					
					if($field->metadata_type == "url"){
						$target = "_blank";
					} else {
						$target = null;
					}
					
					// build result
					$field_result = "<b>" . $title . "</b>:&nbsp;";
					$field_result .= elgg_view("output/" . $output_type, array("value" => $value, "target" => $target));
					
					$result .=  $field_result;
					$result .= "</p>\n";
				}
			}
			$result .= "</div>\n";
		}
		$result .= "</div>\n";
		
?>
	<div id="custom_profile_fields_userdetails">
		<?php echo $result; ?>
	</div>
	
	<script type="text/javascript">
		var custom_userdetails = $('#custom_profile_fields_userdetails').html();
		$('#profile_info_column_middle').append(custom_userdetails);
	
		$('#custom_profile_fields_userdetails').remove();
	</script>
	
	<?php if(get_plugin_setting("display_categories", "profile_manager") == "accordion"){ ?>
	
	<script type="text/javascript">
		$('#custom_fields_userdetails').accordion({
			header: 'h3',
			autoHeight: false
		});
	</script>
	<?php 
		}
	}
?>