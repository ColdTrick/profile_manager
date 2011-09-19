<?php 
	/**
	* Profile Manager
	* 
	* Object view of a custom profile field type
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	if(get_context() != "search"){
		$object = $vars["entity"];
	
		// get title
		$title = $object->getTitle();
		
		$rels = "";
		
		$options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid,
			"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
			"relationship_guid" => $object->guid,
			"inverse_relationship" => false
		);
		
		$rel_count = elgg_get_entities_from_relationship($options);
		
		if($rel_count > 0){
			$options["limit"] = $rel_count;
			$options["count"] = false;
			
			$cats = elgg_get_entities_from_relationship($options);
			
			$guids = array();
			foreach($cats as $cat){
				$guids[] = $cat->guid;
			}
			
			$rels = implode(",", $guids);
		}
	?>
	<div class="custom_profile_type" id="custom_profile_type_<?php echo $object->guid;?>" onmouseover="highlightCategories(this, '<?php echo $rels;?>');" onmouseout="highlightCategories(this, '<?php echo $rels;?>');">
		<span class="elgg-icon elgg-icon-delete" title="<?php echo elgg_echo("delete");?>" onclick="deleteProfileType('<?php echo $object->guid;?>');"></span>
		<span class="elgg-icon elgg-icon-settings-alt" title="<?php echo elgg_echo("edit");?>" onclick="editProfileType('<?php echo $object->guid;?>','<?php echo addslashes($object->metadata_name);?>','<?php echo addslashes($object->metadata_label);?>','<?php echo $object->show_on_members;?>', '<?php echo $rels; ?>');"></span>
		<?php echo $title; ?>
	</div>
	<?php
	} else {
		echo "&nbsp;";
	}
?>