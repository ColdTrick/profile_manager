<?php
	/**
	* Profile Manager
	* 
	* Profile Fields list view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	global $CONFIG;
	
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
			"limit" => false,
			"owner_guid" => $CONFIG->site_guid
		);

	$fields = elgg_get_entities($options);
    
	$ordered = array();
	if($fields){
		foreach($fields as $field){
			$ordered[$field->order] = $field;
		}
		
		ksort($ordered);
	}
		
	$list = elgg_view_entity_list($ordered, $count, 0, $count, false, false, false);
	if(empty($list)){
		$list = elgg_echo("profile_manager:profile_fields:no_fields");
	}
	
?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<?php echo elgg_view("output/url", array("text" => elgg_echo("add"), "href" => "#custom_fields_form", "class" => "elgg-button-action profile-manager-popup"));?>
		<h3>
			<?php echo elgg_echo('profile_manager:profile_fields:list:title'); ?>
		</h3>
	</div>
	<div class="elgg-body" id="custom_fields_ordering">
		<?php echo $list; ?>
	</div>
</div>
<?php echo elgg_view("profile_manager/profile_fields/add");?>
<div class="custom_fields_more_info_text" id="text_more_info_profile_field"><?php echo elgg_echo("profile_manager:tooltips:profile_field");?></div>
<div class="custom_fields_more_info_text" id="text_more_info_profile_field_additional"><?php echo elgg_echo("profile_manager:tooltips:profile_field_additional");?></div>
