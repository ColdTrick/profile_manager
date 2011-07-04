<?php
	/**
	* Profile Manager
	* 
	* Full Profile view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$profile_user = $vars['entity'];
	
	$icon = elgg_view("profile/icon", array(
					'entity' => $vars['entity'],
					'size' => 'large',
					'override' => true,
				  ));
				  
	$categorized_fields = profile_manager_get_categorized_fields($vars['entity']);
	$cats = $categorized_fields['categories'];
	$fields = $categorized_fields['fields'];
	
	if(count($cats) > 0){
		
		$profile_type_guid = $profile_user->custom_profile_type;
		
		$result .= "<div id='custom_fields_userdetails'>\n";
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
					$title = elgg_echo("profile_manager:categories:list:default");
				} else {
					$title = $cat->getTitle();
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
	}				  
				  
?>
<div class='contentWrapper'>
	<table>
		<tr>
			<td id='custom_profile_fields_full_profile_icon'>
				<?php echo $icon;?>
			</td>
			<td id='custom_profile_fields_full_profile_details'>
				<h2><a href="<?php echo $profile_user->getUrl(); ?>" ><?php echo $profile_user->name; ?></a></h2>
				<?php echo elgg_view("profile/status", array("entity" => $profile_user));?>
				<?php 
					echo $result; 
					if($profile_user->description) {
						echo "<h3>" . elgg_echo("profile:aboutme") . "</h3>";
						echo elgg_view('output/longtext', array('value' => $profile_user->description));
					}
				?>
			</td>
		</tr>
	</table>
</div>