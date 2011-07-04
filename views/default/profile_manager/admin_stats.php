<?php
	/**
	* Profile Manager
	* 
	* Admin stats view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	
	$total_users = elgg_get_entities(array("type" => "user","count" => true));

	$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid
		);
	
	$profile_types_count = elgg_get_entities($options);
	
	$options["count"] = false;
	$options["limit"] = $profile_types_count;
	
	$profile_entities = elgg_get_entities($options);
	
	$profile_listing = "";
	foreach($profile_entities as $profile_type){
		$options = array(
				"type" => "user",
				"count" => true,
				"metadata_name_value_pairs" => array("name" => "custom_profile_type", "value" =>  $profile_type->guid)
			);
		$count = elgg_get_entities_from_metadata($options);
		$profile_listing .= "<b>" . $profile_type->metadata_name . "</b>: " . $count . "<br />";
	}

?>
<div class='contentWrapper'>
	<h3 class='settings'><?php echo elgg_echo("profile_manager:admin_stats:title");?></h3>
	
	<?php echo elgg_echo("profile_manager:admin_stats:total");?>: <?php echo $total_users;?><br /><br />
	<?php echo elgg_echo("profile_manager:admin_stats:profile_types");?>:<br />
	<?php echo $profile_listing;?>
</div>