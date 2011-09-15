<?php 
	/**
	* Profile Manager
	* 
	* Group Fields actions
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/	

?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('profile_manager:actions:title'); ?>
			<span class='custom_fields_more_info' id='more_info_actions'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:reset"), "title" => elgg_echo("profile_manager:actions:reset:description"), "href" => $vars['url'] . "action/profile_manager/reset?type=group", "confirm" => elgg_echo("profile_manager:actions:reset:confirm"), "class" => "elgg-button-action")); ?>
		<?php echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:import:from_default"), "title" => elgg_echo("profile_manager:actions:import:from_default:description"), "href" => $vars['url'] . "action/profile_manager/importFromDefault?type=group", "confirm" => elgg_echo("profile_manager:actions:import:from_default:confirm"), "class" => "elgg-button-action")); ?>
		<?php echo elgg_view("output/url", array("title" => elgg_echo("profile_manager:actions:export:description"),"text" => elgg_echo("profile_manager:actions:export"), "href" => $vars['url'] . "admin/appearance/export_fields?fieldtype=" . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE, "class" => "elgg-button-action")); ?>
		<?php echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:configuration:backup"), "href" => $vars['url'] . "action/profile_manager/configuration/backup?fieldtype=" . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE, "confirm" => elgg_echo("profile_manager:actions:configuration:backup:description"), "class" => "elgg-button-action")); ?>
		<?php echo elgg_view("output/url", array("text" => elgg_echo("profile_manager:actions:configuration:restore"), "js" => "onclick=\"$('#restoreForm').toggle();\"", "class" => "elgg-button-action")); ?>
		<div id='restoreForm'>
			<form action='<?php echo $vars['url']; ?>action/profile_manager/configuration/restore?<?php echo $security_params;?>&fieldtype=<?php echo CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE;?>' method="POST" enctype="multipart/form-data">
				<div><?php echo elgg_echo("profile_manager:actions:configuration:restore:description"); ?></div>
				<input type="file" name="restoreFile" />
				<input type="submit" value="<?php echo elgg_echo("profile_manager:actions:configuration:restore:upload");?>" />
			</form>
		</div>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_actions"><?php echo elgg_echo("profile_manager:tooltips:actions");?></div>