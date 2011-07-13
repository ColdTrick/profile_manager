<?php
	/**
	* Profile Manager
	* 
	* Replaces default Elgg profile edit form
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* 
	* @uses $vars['entity'] The user entity
	* @uses $vars['profile'] Profile items from $CONFIG->profile, defined in profile/start.php for now 
	*/
	
	global $CONFIG;
	
?>

<div class="contentWrapper">
<form id="profile_edit_form" action="<?php echo $vars['url']; ?>action/profile/edit" method="post" enctype="multipart/form-data">

<?php
	
	// Build fields
	
	$categorized_fields = profile_manager_get_categorized_fields($vars['entity'], true);
	$cats = $categorized_fields['categories'];
	$fields = $categorized_fields['fields'];
	
	if(!empty($cats)){
		
		// Profile type selector
		$setting = get_plugin_setting("profile_type_selection", "profile_manager");
		if(empty($setting)){
			// default value
			$setting = "user";
		} 
		
		// can user edit? or just admins
		if($setting == "user" || isadminloggedin()){
			// get profile types
			
			$options = array(
				"type" => "object",
				"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				"limit" => false,
				"owner_guid" => $CONFIG->site_guid
			); 
			
			if($types = elgg_get_entities($options)){
				
				$pulldown_options = array();
				$pulldown_options[""] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
				
				foreach($types as $type){
					
					$pulldown_options[$type->getGUID()] = $type->getTitle();
					
					// preparing descriptions of profile types
					$description = $type->getDescription();
					
					if(!empty($description)){
						$types_description .= "<div id='custom_profile_type_description_" . $type->getGUID() . "' class='custom_profile_type_description'>";
						$types_description .= "<h3 class='settings'>" . elgg_echo("profile_manager:profile:edit:custom_profile_type:description") . "</h3>";
						$types_description .= $description;
						$types_description .= "</div>";
					}
				}
				
				?>
				<script type="text/javascript">
					$(document).ready(function(){
						changeProfileType();
					});
		
					function changeProfileType(){
						var selVal = $('#profile_edit_form select[name="custom_profile_type"]').val();
		
						$('.custom_fields_edit_profile_category').hide();
						$('.custom_profile_type_description').hide();
		
						if(selVal != ""){
							$('.custom_profile_type_' + selVal).show();
							$('#custom_profile_type_description_'+ selVal).show();
						}

						<?php if(get_plugin_setting("edit_profile_mode", "profile_manager") == "tabbed" && count($cats) > 1){ ?>
						$('#elgg_horizontal_tabbed_nav li:visible:first>a').click();
						<?php } ?>
					}
				</script>
				<?php 
				echo "<p>\n";
				echo "<label>\n";
				echo elgg_echo("profile_manager:profile:edit:custom_profile_type:label") . "<br />\n";
				
				echo elgg_view("input/pulldown", array("internalname" => "custom_profile_type",
														"options_values" => $pulldown_options,
														"js" => "onchange='changeProfileType();'",
														"value" => $vars["entity"]->custom_profile_type));
				echo "</label>\n";
				echo elgg_view('input/hidden', array('internalname' => 'accesslevel[custom_profile_type]', 'value' => ACCESS_PUBLIC)); 
				
				echo "</p>\n";
				echo $types_description;
			}
		} else {
			$profile_type = $vars["entity"]->custom_profile_type;
			
			if(!empty($profile_type)){
				echo elgg_view("input/hidden", array("internalname" => custom_profile_type, "value" => $profile_type));
				?>
				<script type="text/javascript">
					$(document).ready(function(){
						$('.custom_profile_type_<?php echo $profile_type; ?>').show();
					});
				</script>
				<?php 		
			}
		}
		
		$tab_header = "";
		$tab_content = "";
		$list_content = "";
		
		foreach($cats as $cat_guid => $cat){
			// make nice title for category		
			if(empty($cat_guid) || !($cat instanceof ProfileManagerCustomFieldCategory)) {
				$title = elgg_echo("profile_manager:categories:list:default");
			} else {
				$title = $cat->getTitle();
			}
			
			$class = "";
			if(!empty($cat_guid) && ($cat instanceof ProfileManagerCustomFieldCategory)){
				
				$profile_type_options = array(
						"type" => "object",
						"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
						"limit" => false,
						"owner_guid" => $cat->getOwner(),
						"site_guid" => $cat->site_guid,
						"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
						"relationship_guid" => $cat_guid,
						"inverse_relationship" => true
					);
				
				if($profile_types = elgg_get_entities_from_relationship($profile_type_options)){
					
					$class = "custom_fields_edit_profile_category";
					
					// add extra class so it can be toggle in the display
					foreach($profile_types as $type){
						$class .= " custom_profile_type_" . $type->getGUID(); 
					}
				}
			}
			
			$tab_header .= "<li class='" . $class . "'><a href='javascript:void(0);' onclick='toggle_tabbed_nav(\"" . $cat_guid . "\", this);'>" . $title . "</a></li>\n";
			$tab_content .= "<div id='profile_manager_profile_edit_tab_content_" . $cat_guid . "' class='profile_manager_profile_edit_tab_content'>\n";
			
			$list_content .= "<div class='" . $class . "'>\n";
			$list_content .= "<h3 class='settings'>" . $title . "</h3>\n";
			
			// display each field for currect category
			foreach($fields[$cat_guid] as $field){
				$metadata_name = $field->metadata_name;
				
				// get options
				$options = $field->getOptions();
				
				// get type of field
				if($field->user_editable == "no"){
					$valtype = "non_editable";
				} else {
					$valtype = $field->metadata_type;	
				}
				// make title
				$title = $field->getTitle();
								
				// get value
				if($metadata = get_metadata_byname($vars['entity']->guid, $metadata_name)) {
					if (is_array($metadata)) {
						$value = '';
						foreach($metadata as $md) {
							if (!empty($value)) $value .= ', ';
							$value .= $md->value;
							$access_id = $md->access_id;
						}
					} else {
						$value = $metadata->value;
						$access_id = $metadata->access_id;
					}
				} else {
					$value = '';
					$access_id = get_default_access($vars["entity"]);
				}
	
				if(get_plugin_setting("hide_non_editables", "profile_manager") == "yes" && ($valtype == "non_editable")){
					$field_result = "<p class='hidden_non_editable'>\n";
				} else {
					$field_result = "<p>\n";
				}	
		
				if(!empty($field->metadata_hint)){ 
					$field_result .= "<span class='custom_fields_more_info' id='more_info_". $metadata_name . "'></span>";		
					$field_result .= "<span class='custom_fields_more_info_text' id='text_more_info_" . $metadata_name . "'>" . $field->metadata_hint . "</span>";
				}
				$field_result .= "<label>\n" . $title . "<br />\n";
				$field_result .= "</label>\n";
				$field_result .= elgg_view("input/" . $valtype, array(
																'internalname' => $metadata_name,
																'value' => $value,
																'options' => $options
																));
				
				$field_result .= "<br />\n";
				$field_result .= elgg_view('input/access', array('internalname' => 'accesslevel[' . $metadata_name . ']', 'value' => $access_id)); 
				$field_result .= "</p>\n";
				
				$tab_content .= $field_result;
				$list_content .= $field_result;
			}
			
			$tab_content .= "</div>\n";
			$list_content .= "</div>\n";
		}
		
		if((get_plugin_setting("edit_profile_mode", "profile_manager") == "tabbed") && (count($cats) > 1)){
			?>
			<script type="text/javascript">
				function toggle_tabbed_nav(div_id, element){
					$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
					$('#profile_manager_profile_edit_tab_content_' + div_id).show();
		
					$('#elgg_horizontal_tabbed_nav .selected').removeClass('selected');
					$(element).parent('li').addClass("selected");
				}
		
				$(document).ready(function(){
					$('#elgg_horizontal_tabbed_nav li:visible:first>a').click();
				});
			</script>
			
			<div id="elgg_horizontal_tabbed_nav">
				<ul>
					<?php echo $tab_header; ?>
				</ul>
			</div>
			<div id="profile_manager_profile_edit_tab_content_wrapper">
				<?php echo $tab_content; ?>
			</div>
			<?php
		} else {
			echo $list_content;
		}
	} else {
		// use default edit fields
		
		if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0){
			foreach($vars['config']->profile as $shortname => $valtype) {
				if ($metadata = get_metadata_byname($vars['entity']->guid, $shortname)) {
					if (is_array($metadata)) {
						$value = '';
						foreach($metadata as $md) {
							if (!empty($value)) $value .= ', ';
							$value .= $md->value;
							$access_id = $md->access_id;
						}
					} else {
						$value = $metadata->value;
						$access_id = $metadata->access_id;
					}
				} else {
					$value = '';
					$access_id = get_default_access($vars["entity"]);
				}
				
				echo "<p>\n";
				echo "<label>\n";
				echo elgg_echo("profile:{$shortname}");
				echo "<br />\n";
				echo elgg_view("input/{$valtype}",array(
													'internalname' => $shortname,
													'value' => $value,
													));
				echo "</label>\n";
				echo elgg_view('input/access',array('internalname' => 'accesslevel['.$shortname.']', 'value' => $access_id));
				echo "</p>\n";
			}
		}
	}

	if(get_plugin_setting("simple_access_control","profile_manager") == "yes"){ 
		?>
		<p>
			<label>
				<?php echo elgg_echo("profile_manager:simple_access_control"); ?><br />
			</label>
				<?php echo elgg_view('input/access',array('internalname' => 'simple_access_control', 'value' => $access_id, 'class' => 'simple_access_control', 'js' => 'onchange="set_access_control(this.value)"')); ?>
		</p>
		<?php 
	} 
	?>
	<p>
		<?php echo elgg_view("input/securitytoken"); ?>
		<input type="hidden" name="username" value="<?php echo page_owner_entity()->username; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
	</p>

</form>
<?php 
	if(get_plugin_setting("simple_access_control","profile_manager") == "yes"){ 
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".simple_access_control").val($(".input-access:first").val()).trigger("change");
		});
	
		function set_access_control(val){
			$(".input-access").val(val);
		}
	</script>
	<style type="text/css">
		.input-access {
			display: none;
		}
	</style>
	<?php 
	} 
?>
</div>