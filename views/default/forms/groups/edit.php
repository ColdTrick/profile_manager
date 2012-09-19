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
	$access = $vars['entity']->access_id;
	if ($access != ACCESS_PUBLIC && $access != ACCESS_LOGGED_IN) {
		// group only - this is done to handle access not created when group is created
		$access = ACCESS_PRIVATE;
	}
} else {
	$membership = ACCESS_PUBLIC;
	$access = ACCESS_PUBLIC;
}
	
?>

<div>
	<label><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo("groups:name"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'name',
		'value' => $vars['entity']->name,
	));
	?>
</div>
		
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
					$value .= $md;
				}
			} else {
				$value = $metadata;
			}
		}		
		
		$line_break = '<br />';
		if ($valtype == 'longtext') {
			$line_break = '';
		}
		echo '<div><label>';
		echo $title;
		echo "</label>";
		
		if($hint = $field->getHint()){ 
			?>
			<span class='custom_fields_more_info' id='more_info_<?php echo $metadata_name; ?>'></span>		
			<span class="custom_fields_more_info_text" id="text_more_info_<?php echo $metadata_name; ?>"><?php echo $hint;?></span>
			<?php 
		}
		
		echo $line_break;
		echo elgg_view("input/{$valtype}", array(
			'name' => $metadata_name,
			'value' => $value,
			$valtype == 'radio' ? 'options' : 'options_values' => $options
		));
		echo '</div>';
	}
}

?>
<div>
	<label>
		<?php echo elgg_echo('groups:membership'); ?><br />
		<?php echo elgg_view('input/access', array(
			'name' => 'membership',
			'value' => $membership,
			'options_values' => array(
				ACCESS_PRIVATE => elgg_echo('groups:access:private'),
				ACCESS_PUBLIC => elgg_echo('groups:access:public')
			)
		));
		?>
	</label>
</div>
<?php
	
    if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
		$this_owner = $vars['entity']->owner_guid;
		
		if (!$this_owner) {
			$this_owner = elgg_get_logged_in_user_guid();
		}
		$access_options = array(
			ACCESS_PRIVATE => elgg_echo('groups:access:group'),
			ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
			ACCESS_PUBLIC => elgg_echo("PUBLIC")
		);
		
		?>
	
	<div>
		<label>
				<?php echo elgg_echo('groups:visibility'); ?><br />
				<?php echo elgg_view('input/access', array(
					'name' => 'vis',
					'value' =>  $access,
					'options_values' => $access_options,
				));
				?>
		</label>
	</div>
	
	<?php 	
}
	
$tools = elgg_get_config('group_tool_options');
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	foreach ($tools as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		if ($group_option->default_on) {
			$group_option_default_value = 'yes';
		} else {
			$group_option_default_value = 'no';
		}
		$value = $vars['entity']->$group_option_toggle_name ? $vars['entity']->$group_option_toggle_name : $group_option_default_value;
		?>	
		<div>
			<label>
				<?php echo $group_option->label; ?><br />
			</label>
			<?php 
			echo elgg_view("input/radio", array(
				"name" => $group_option_toggle_name,
				"value" => $value,
				'options' => array(
					elgg_echo('groups:yes') => 'yes',
					elgg_echo('groups:no') => 'no',
				)
			));
			?>
		</div>
		<?php 
	}
}
?>
<div class="elgg-foot">
	<?php
	
	if (isset($vars['entity'])) {
		echo elgg_view('input/hidden', array(
			'name' => 'group_guid',
			'value' => $vars['entity']->getGUID(),
		));
	}
	
	echo elgg_view('input/submit', array('value' => elgg_echo('save')));

	if (isset($vars['entity'])) {
		$delete_url = 'action/groups/delete?guid=' . $vars['entity']->getGUID();
		echo elgg_view('output/confirmlink', array(
			'text' => elgg_echo('groups:delete'),
			'href' => $delete_url,
			'confirm' => elgg_echo('groups:deletewarning'),
			'class' => 'elgg-button elgg-button-delete float-alt',
		));
	}
	?>
</div>