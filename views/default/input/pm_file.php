<?php 
	if(!empty($vars["value"]) && $file = get_entity($vars["value"])){
		
?>
	<div>
		<?php 
			echo elgg_echo("Currently uploaded file") .": "; 
		
			if(is_plugin_enabled("file")){
				echo "<a target='_blank' href='" . $file->getURL() . "'>" . $file->originalfilename . "</a>";
			} else {
				echo "<a target='_blank' href='" . $vars["url"] . "pg/profile_manager/file_download/" . $file->getGUID() . "'>" . $file->originalfilename . "</a>";
			}
		?>

		
		<a href="javascript:void(0);" onclick="$(this).parent().next().val(''); $(this).parent().remove();"><?php echo elgg_echo("clear");?></a>
	</div>
	<input type="hidden" name="<?php echo $vars['internalname']; ?>" value="<?php echo $vars["value"]; ?>" />
<?php }?>
<input type="file" size="30" name="<?php echo $vars['internalname']; ?>"/>