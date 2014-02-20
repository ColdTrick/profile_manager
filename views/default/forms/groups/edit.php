<?php
/**
* Profile Manager
*
* Overrules group edit form to support options (radio, dropdown, multiselect)
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

$group = elgg_extract("entity", $vars);

$name_limit = elgg_get_plugin_setting("group_limit_name", "profile_manager");
$description_limit = elgg_get_plugin_setting("group_limit_description", "profile_manager");
	
echo "<div>";
echo "<label>" . elgg_echo("groups:icon") . "</label><br />";
echo elgg_view("input/file", array('name' => 'icon'));
echo "</div>";

echo "<div>";
echo "<label>" . elgg_echo("groups:name") . "</label><br />";

$show_input = false;
if (empty($group) || ($name_limit === NULL) || ($name_limit === "") || elgg_is_admin_logged_in()) {
	$show_input = true;
}

if (!$show_input && !empty($group) && (!empty($name_limit) || ($name_limit == "0"))) {
	$name_limit = (int) $name_limit;
	$name_edit_count = (int) $group->getPrivateSetting("profile_manager_name_edit_count");

	if ($name_edit_count < $name_limit) {
		$show_input = true;
	}
	
	$name_edit_num_left = $name_limit - $name_edit_count;
}

if ($show_input) {
	echo elgg_view("input/text", array(
			'name' => 'name',
			'value' => $vars['entity']->name,
	));
	if (!empty($name_edit_num_left)) {
		echo "<div class='elgg-subtext'>" . elgg_echo("profile_manager:group:edit:limit", array("<strong>" . $name_edit_num_left . "</strong>")) . "</div>";
	}
} else {
	// show value
	echo elgg_view("output/text", array(
			'value' => $vars['entity']->name,
	));
	
	// add hidden so it gets saved and form checks still are valid
	echo elgg_view("input/hidden", array(
			'name' => 'name',
			'value' => $vars['entity']->name,
	));
}

echo "</div>";

// retrieve group fields
$group_fields = profile_manager_get_categorized_group_fields();

if (count($group_fields["fields"]) > 0) {
	$group_fields = $group_fields["fields"];
	
	foreach ($group_fields as $field) {
		$metadata_name = $field->metadata_name;
		
		// get options
		$options = $field->getOptions();
		
		// get type of field
		$valtype = $field->metadata_type;
		
		// get title
		$title = $field->getTitle();
		
		// get value
		$value = '';
		if ($metadata = $vars['entity']->$metadata_name) {
			if (is_array($metadata)) {
				foreach ($metadata as $md) {
					if (!empty($value)) {
						$value .= ', ';
					}
					
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
		
		if ($hint = $field->getHint()) {
			?>
			<span class='custom_fields_more_info' id='more_info_<?php echo $metadata_name; ?>'></span>
			<span class="custom_fields_more_info_text" id="text_more_info_<?php echo $metadata_name; ?>"><?php echo $hint;?></span>
			<?php
		}
		
		echo $line_break;
		
		if ($metadata_name == "description") {
		
			$show_input = false;
			if (empty($group) || ($description_limit === NULL) || ($description_limit === "") || elgg_is_admin_logged_in()) {
				$show_input = true;
			}
			
			$edit_num_left = 0;
			
			if (!$show_input && !empty($group) && (!empty($description_limit) || ($description_limit == "0"))) {
				$description_limit = (int) $description_limit;
				$field_edit_count = (int) $group->getPrivateSetting("profile_manager_description_edit_count");
			
				if ($field_edit_count < $description_limit) {
					$show_input = true;
				}
					
				$edit_num_left = $description_limit - $field_edit_count;
			}
			
			if ($show_input) {
				echo elgg_view("input/{$valtype}", array(
						'name' => $metadata_name,
						'value' => $value,
				));
				
				if (!empty($edit_num_left)) {
					echo "<div class='elgg-subtext'>" . elgg_echo("profile_manager:group:edit:limit", array("<strong>" . $edit_num_left . "</strong>")) . "</div>";
				}
			} else {
				// show value
				echo elgg_view("output/{$valtype}", array(
						'value' => $value
				));
					
				// add hidden so it gets saved and form checks still are valid
				echo elgg_view("input/hidden", array(
						'name' => $metadata_name,
						'value' => $value
				));
			}
		} else {
			if ($valtype == "dropdown") {
				// add div around dropdown to let it act as a block level element
				echo "<div>";
			}
			
			echo elgg_view("input/{$valtype}", array(
				'name' => $metadata_name,
				'value' => $value,
				'options' => $options
			));
			
			if ($valtype == "dropdown") {
				echo "</div>";
			}
		}
		
		echo '</div>';
	}
}

echo "<div>";
echo "<label>" . elgg_echo('groups:membership') . "<br />";
echo elgg_view('input/access', array(
			'name' => 'membership',
			'value' => $membership,
			'options_values' => array(
				ACCESS_PRIVATE => elgg_echo('groups:access:private'),
				ACCESS_PUBLIC => elgg_echo('groups:access:public')
			)
		));
echo "</label>";
echo "</div>";

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

	echo "<div>";
	echo "<label>" . elgg_echo('groups:visibility') . "<br />";
	echo elgg_view('input/access', array(
					'name' => 'vis',
					'value' => $access,
					'options_values' => $access_options,
				));
	echo "</label>";
	echo "</div>";
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
echo "<div class='elgg-foot'>";

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
echo "</div>";
