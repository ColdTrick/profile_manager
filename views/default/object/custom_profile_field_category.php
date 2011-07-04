<?php 
	/**
	* Profile Manager
	* 
	* Object view of a custom profile field category
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
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"limit" => 0,
			"owner_guid" => $CONFIG->site_guid,
			"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
			"relationship_guid" => $object->guid,
			"inverse_relationship" => true
		);
		
		$cats = elgg_get_entities_from_relationship($options);
		
		if($cats){
			$guids = array();
			foreach($cats as $cat){
				$guids[] = $cat->guid;
			}
			
			$rels = implode(",", $guids);
		}
		
	?>
	<div class="custom_fields_category" id="custom_profile_field_category_<?php echo $object->guid;?>">
		<div class="custom_fields_category_edit" onclick="editCategory('<?php echo $object->guid;?>','<?php echo addslashes($object->metadata_name);?>','<?php echo addslashes($object->metadata_label);?>', '<?php echo $rels; ?>');"></div>
		<a href="javascript:void(0);" onclick="filterCustomFields(<?php echo $object->guid; ?>)"><?php echo $title; ?></a>
	</div>
	<?php 
	} else {
		echo "&nbsp;";
	}	
?>