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
 
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
			"limit" => false,
			"order_by_metadata" => array(array('name' => 'order', 'direction' => "asc", 'as' => "integer")),
			"owner_guid" => elgg_get_site_entity()->getGUID(),
			"pagination" => false,
			"full_view" => false
		);

	$list = elgg_list_entities_from_metadata($options);	
	
	if(empty($list)){
		$list = elgg_echo("profile_manager:profile_fields:no_fields");
	}
	
?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<?php echo elgg_view("output/url", array("text" => elgg_echo("add"), "href" => $vars["url"] . "profile_manager/forms/profile_field", "class" => "elgg-button elgg-button-action profile-manager-popup"));?>
		<h3>
			<?php echo elgg_echo('profile_manager:profile_fields:list:title'); ?>
		</h3>
	</div>
	<div class="elgg-body" id="custom_fields_ordering">
		<?php echo $list; ?>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_profile_field"><?php echo elgg_echo("profile_manager:tooltips:profile_field");?></div>
<div class="custom_fields_more_info_text" id="text_more_info_profile_field_additional"><?php echo elgg_echo("profile_manager:tooltips:profile_field_additional");?></div>
