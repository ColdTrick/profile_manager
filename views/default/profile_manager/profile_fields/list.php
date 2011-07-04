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
			"limit" => 0,
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
		
	$fieldslist = elgg_view_entity_list($ordered, $count, 0, $count, false, false, false);
	if(empty($fieldslist)){
		$fieldslist = elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("profile_manager:profile_fields:no_fields")));
	}
	$categorylist = elgg_view("profile_manager/categories/list");
	$profiletypelist = elgg_view("profile_manager/profile_types/list");
?>
<div id="custom_fields_ordering">
	<?php echo $fieldslist; ?>
</div>
<div id="custom_fields_lists">
	<div id="custom_fields_profile_type_list">
		<?php echo $profiletypelist; ?>	
	</div>
	<div id="custom_fields_category_list">
		<?php echo $categorylist; ?>	
	</div>
</div>
<div class="clearfloat"></div>