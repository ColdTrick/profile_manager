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

	$entity = $vars["entity"];

	// get title
	$title = $entity->getTitle();
	
?>
<div class="custom_profile_type" id="custom_profile_type_<?php echo $entity->guid;?>">
	<?php echo $title; ?>
	<a href="<?php echo $vars["url"];?>profile_manager/forms/type/<?php echo $entity->guid;?>" class="profile-manager-popup"><span class="elgg-icon elgg-icon-settings-alt" title="<?php echo elgg_echo("edit");?>"></span></a>
	<span class="elgg-icon elgg-icon-delete" title="<?php echo elgg_echo("delete");?>" onclick="deleteProfileType('<?php echo $entity->guid;?>');"></span>
</div>