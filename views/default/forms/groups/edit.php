<?php
	/**
	* Profile Manager
	* 
	* Overrules group edit form to support options (radio, pulldown, multiselect)
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	// new groups default to open membership
	if (isset($vars['entity'])) {
		$membership = $vars['entity']->membership;
	} else {
		$membership = ACCESS_PUBLIC;
	}
	
?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/groups/edit" enctype="multipart/form-data" method="post">
	<?php echo elgg_view('input/securitytoken'); ?>
	<p>
		<label><?php echo elgg_echo("groups:icon"); ?><br />
		<?php

			echo elgg_view("input/file",array('internalname' => 'icon'));
		
		?>
		</label>
	</p>
	<p>
		<label>
			<?php echo elgg_echo("groups:name"); ?><br />
		</label>
			<?php echo elgg_view("input/text",array(
															'internalname' => "name",
															'value' => $vars['entity']->name
															)); ?>
		
	</p>
<?php

	// retrieve group fields
	$group_fields = profile_manager_get_categorized_group_fields();
	
	if(count($group_fields["fields"]) > 0){
		$group_fields = $group_fields["fields"];
		
		foreach($group_fields as $field) {
			$metadata_name = $field->metadata_name;
			
			// get options
			$options = $field->getOptions();
			
			// get type of field
			$valtype = $field->metadata_type;
			
			// get title
			$title = $field->getTitle();
			
			
			// get value
			$value = '';
			if($metadata = $vars['entity']->$metadata_name) {
				if (is_array($metadata)) {
					foreach($metadata as $md) {
						if (!empty($value)) $value .= ', ';
						$value .= $md->value;
					}
				} else {
					$value = $metadata;
				}
			}		
			
	?>
		<p>
			<?php if(!empty($field->metadata_hint)){ ?>
			<span class='custom_fields_more_info' id='more_info_<?php echo $metadata_name; ?>'></span>		
			<span class="custom_fields_more_info_text" id="text_more_info_<?php echo $metadata_name; ?>"><?php echo $field->metadata_hint;?></span>
			<?php } ?>
			
			<label>
				<?php echo $title; ?>
				<br />
				<?php echo elgg_view("input/{$valtype}",array(
																'internalname' => $metadata_name,
																'value' => $value,
																'options' => $options
																)); ?>
			</label>
		</p>
	<?php
		}
	}
?>

	<p>
		<label>
			<?php echo elgg_echo('groups:membership'); ?><br />
			<?php echo elgg_view('input/access', array('internalname' => 'membership','value' => $membership, 'options' => array( ACCESS_PRIVATE => elgg_echo('groups:access:private'), ACCESS_PUBLIC => elgg_echo('groups:access:public')))); ?>
		</label>
	</p>
	
	
    <?php
	    if (get_plugin_setting('hidden_groups', 'groups') == 'yes')
		{
	?>
	
		<p>
			<label>
				<?php echo elgg_echo('groups:visibility'); ?><br />
				<?php 
				
				$this_owner = $vars['entity']->owner_guid;
				if (!$this_owner) $this_owner = get_loggedin_userid();
				
				$access = array(ACCESS_FRIENDS => elgg_echo("access:friends:label"), ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"), ACCESS_PUBLIC => elgg_echo("PUBLIC"));
				$collections = get_user_access_collections($vars['entity']->guid);
				if (is_array($collections)) {
					foreach ($collections as $c)
						$access[$c->id] = $c->name;
				}
	
				$current_access = ($vars['entity']->access_id ? $vars['entity']->access_id : ACCESS_PUBLIC);
				echo elgg_view('input/access', array('internalname' => 'vis', 
													'value' =>  $current_access,
													'options' => $access));
				
				?>
			</label>
		</p>
	
	<?php 	
		}
    
		if (isset($vars['config']->group_tool_options)) {
			foreach($vars['config']->group_tool_options as $group_option) {
				$group_option_toggle_name = $group_option->name."_enable";
				if ($group_option->default_on) {
					$group_option_default_value = 'yes';
				} else {
					$group_option_default_value = 'no';
				}
?>	
    <p>
			<label>
				<?php echo $group_option->label; ?><br />
				<?php

					echo elgg_view("input/radio",array(
									"internalname" => $group_option_toggle_name,
									"value" => $vars['entity']->$group_option_toggle_name ? $vars['entity']->$group_option_toggle_name : $group_option_default_value,
									'options' => array(
														elgg_echo('groups:yes') => 'yes',
														elgg_echo('groups:no') => 'no',
													   ),
													));
				?>
			</label>
	</p>
	<?php
		}
	}
	?>
	<p>
		<?php
			if ($vars['entity'])
			{ 
			?><input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" /><?php 
			}
		?>
		<input type="hidden" name="user_guid" value="<?php echo page_owner_entity()->guid; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
		
	</p>

</form>
</div>

<?php
if ($vars['entity']) {
?>
<div class="contentWrapper">
<div id="delete_group_option">
	<form action="<?php echo $vars['url'] . "action/groups/delete"; ?>">
		<?php
			echo elgg_view('input/securitytoken');
				$warning = elgg_echo("groups:deletewarning");
			?>
			<input type="hidden" name="group_guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
			<input type="submit" name="delete" value="<?php echo elgg_echo('groups:delete'); ?>" onclick="javascript:return confirm('<?php echo $warning; ?>')"/>
	</form>
</div><div class="clearfloat"></div>
</div>
<?php
}
?>