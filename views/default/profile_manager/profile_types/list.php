<?php
	/**
	* Profile Manager
	* 
	* Profile Types list view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"limit" => 0,
			"owner_guid" => elgg_get_site_entity()->getGUID(),
			"full_view" => false,
			"list_type_toggle" => false,
			"pagination" => false
		);

	$list = elgg_list_entities($options);
	
	if(empty($list)){
		$list = elgg_echo("profile_manager:profile_types:list:no_types");
	}
	
?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<?php echo elgg_view("output/url", array("text" => elgg_echo("add"), "href" => elgg_get_site_url() . "profile_manager/forms/type", "class" => "elgg-button elgg-button-action profile-manager-popup")); ?>
		<h3>
			<?php echo elgg_echo('profile_manager:profile_types:list:title'); ?>
			<span class='custom_fields_more_info' id='more_info_profile_type_list'></span>
		</h3>
	</div>
	<div class="elgg-body" id="custom_fields_profile_types_list_custom">
		<?php echo $list; ?>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_profile_type"><?php echo elgg_echo("profile_manager:tooltips:profile_type");?></div>
<div class="custom_fields_more_info_text" id="text_more_info_profile_type_list"><?php echo elgg_echo("profile_manager:tooltips:profile_type_list");?></div>