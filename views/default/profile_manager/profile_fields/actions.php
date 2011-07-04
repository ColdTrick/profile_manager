<?php 
	/**
	* Profile Manager
	* 
	* Profile Fields actions view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	$ts = time();
	$token = generate_action_token($ts);
	$security_params = "__elgg_ts=" . $ts . "&__elgg_token=" . $token;
?>
<div class="contentWrapper">
	<h3 class='settings'><span id="more_info_actions" class="custom_fields_more_info"></span><?php echo elgg_echo("profile_manager:actions:title");?></h3>
	<table class='custom_profile_fields_actions_list'>
		<tr>
			<td>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:reset"); ?>" onclick="if(confirm('<?php echo elgg_echo("profile_manager:actions:reset:confirm"); ?>')) document.location.href='<?php echo $vars['url']; ?>action/profile_manager/reset?<?php echo $security_params;?>';">
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:reset:description"); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:import:from_custom"); ?>" onclick="if(confirm('<?php echo elgg_echo("profile_manager:actions:import:from_custom:confirm"); ?>')) document.location.href='<?php echo $vars['url']; ?>action/profile_manager/importFromCustom?<?php echo $security_params;?>';">
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:import:from_custom:description"); ?>
			</td>
		</tr>
		<tr>
			<td>	
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:import:from_default"); ?>" onclick="if(confirm('<?php echo elgg_echo("profile_manager:actions:import:from_default:confirm"); ?>')) document.location.href='<?php echo $vars['url']; ?>action/profile_manager/importFromDefault?<?php echo $security_params;?>';">
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:import:from_default:description"); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:export"); ?>" onclick="document.location.href='<?php echo $vars['url']; ?>pg/profile_manager/export/<?php echo CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE;?>';">
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:export:description"); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:configuration:backup"); ?>" onclick="document.location.href='<?php echo $vars['url']; ?>action/profile_manager/configuration/backup?<?php echo $security_params;?>&fieldtype=<?php echo CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE;?>';">
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:configuration:backup:description"); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("profile_manager:actions:configuration:restore"); ?>" onclick="$('#restoreForm').toggle();">				
			</td>
			<td>
				<?php echo elgg_echo("profile_manager:actions:configuration:restore:description"); ?>
			</td>
		</tr>
	</table>
	<div id='restoreForm'>
		<form action='<?php echo $vars['url']; ?>action/profile_manager/configuration/restore?<?php echo $security_params;?>&fieldtype=<?php echo CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE;?>' method="POST" enctype="multipart/form-data">
			<input type="file" name="restoreFile" />
			<input type="submit" value="<?php echo elgg_echo("profile_manager:actions:configuration:restore:upload");?>" />
		</form>
	</div>
</div>