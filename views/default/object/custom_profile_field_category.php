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

	$entity = $vars["entity"];

	// get title
	$title = $entity->getTitle();
	
?>
<div class="custom_fields_category" id="custom_profile_field_category_<?php echo $entity->guid;?>">
	<span class="elgg-icon elgg-icon-drag-arrow"></span>
	<a href="javascript:void(0);" onclick="filterCustomFields(<?php echo $entity->guid; ?>)"><?php echo $title; ?></a>
	<a href="<?php echo $vars["url"];?>profile_manager/forms/category/<?php echo $entity->guid;?>" class="profile-manager-popup"><span class="elgg-icon elgg-icon-settings-alt" title="<?php echo elgg_echo("edit");?>"></span></a>
	<span class="elgg-icon elgg-icon-delete" title="<?php echo elgg_echo("delete");?>" onclick="deleteCategory('<?php echo $entity->guid;?>');"></span>
</div>