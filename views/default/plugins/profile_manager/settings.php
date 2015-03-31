<?php
/**
* Profile Manager
*
* Admin settings
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);

$noyes_options = array_reverse($yesno_options);

$profile_icon_options = $noyes_options;
$profile_icon_options["optional"] = elgg_echo("profile_manager:settings:profile_icon_on_register:option:optional");

$extra_fields_options = array(
	"extend" => elgg_echo("profile_manager:settings:registration:extra_fields:extend"),
	"beside" => elgg_echo("profile_manager:settings:registration:extra_fields:beside")
);

$enable_username_change_options = array(
	"no" => elgg_echo("option:no"),
	"admin" => elgg_echo("profile_manager:settings:enable_username_change:option:admin"),
	"yes" => elgg_echo("option:yes")
);

$profile_types = array();

$profile_types_options = array(
	"type" => "object",
	"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
	"owner_guid" => elgg_get_site_entity()->getGUID(),
	"limit" => false
);

$profile_type_entities = elgg_get_entities($profile_types_options);

if (!empty($profile_type_entities)) {
	$profile_types[""] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
	foreach ($profile_type_entities as $type) {
		$profile_types[$type->guid] = $type->getTitle();
	}
}

echo elgg_view("profile_manager/admin/tabs", array("settings_selected" => true));

$group_limit_options = array(
		"" => elgg_echo("profile_manager:settings:group:limit:unlimited"),
		0 => elgg_echo("never"),
		1 => 1,
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10
	);
?>
<table>
	<tr>
		<td colspan="2">
			<div class='elgg-module-inline'>
				<div class='elgg-head'>
				<h3><?php echo elgg_echo("profile_manager:settings:registration"); ?></h3>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:generate_username_from_email'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[generate_username_from_email]", "options_values" => $noyes_options, "value" => $vars['entity']->generate_username_from_email)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:profile_icon_on_register'); ?>
		</td>
		<td>
			<?php
				echo elgg_view("input/dropdown", array(
					"name" => "params[profile_icon_on_register]", 
					"options_values" => $profile_icon_options, 
					"value" => $vars['entity']->profile_icon_on_register
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:show_account_hints'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[show_account_hints]", "options_values" => $noyes_options, "value" => $vars['entity']->show_account_hints)); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo elgg_echo('profile_manager:settings:registration:terms'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo elgg_view("input/text", array("name" => "params[registration_terms]", "value" => $vars['entity']->registration_terms)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:registration:extra_fields'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[registration_extra_fields]", "options_values" => $extra_fields_options, "value" => $vars['entity']->registration_extra_fields)); ?>
		</td>
	</tr>
	<?php if (!empty($profile_types)) {?>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:default_profile_type'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[default_profile_type]", "options_values" => $profile_types, "value" => $vars['entity']->default_profile_type)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:hide_profile_type_default'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[hide_profile_type_default]", "options_values" => $noyes_options, "value" => $vars['entity']->hide_profile_type_default)); ?>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2">
			<?php echo elgg_echo('profile_manager:settings:registration:free_text'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo elgg_view("input/longtext", array("name" => "params[registration_free_text]", "value" => $vars['entity']->registration_free_text)); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class='elgg-module-inline'>
				<div class='elgg-head'>
				<h3><?php echo elgg_echo("profile_manager:settings:edit_profile"); ?></h3>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:simple_access_control'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[simple_access_control]", "options_values" => $noyes_options, "value" => $vars['entity']->simple_access_control)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:hide_non_editables'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[hide_non_editables]", "options_values" => $noyes_options, "value" => $vars['entity']->hide_non_editables)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:edit_profile_mode'); ?>
		</td>
		<td>
			<?php
				$edit_profile_mode_options = array("list" => elgg_echo('profile_manager:settings:edit_profile_mode:list'), "tabbed" => elgg_echo('profile_manager:settings:edit_profile_mode:tabbed'));
				echo elgg_view("input/dropdown", array("name" => "params[edit_profile_mode]", "options_values" => $edit_profile_mode_options, "value" => $vars['entity']->edit_profile_mode));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:profile_type_selection'); ?>
		</td>
		<td>
			<?php
				$profile_type_selection_options = array("user" => elgg_echo('profile_manager:settings:profile_type_selection:option:user'), "admin" => elgg_echo('profile_manager:settings:profile_type_selection:option:admin'));
				echo elgg_view("input/dropdown", array("name" => "params[profile_type_selection]", "options_values" => $profile_type_selection_options, "value" => $vars['entity']->profile_type_selection));
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class='elgg-module-inline'>
				<div class='elgg-head'>
				<h3><?php echo elgg_echo("profile_manager:settings:view_profile"); ?></h3>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:show_profile_type_on_profile'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[show_profile_type_on_profile]", "options_values" => $yesno_options, "value" => $vars['entity']->show_profile_type_on_profile)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:display_categories'); ?>
		</td>
		<td>
			<?php
				$display_categories_options = array("plain" => elgg_echo('profile_manager:settings:display_categories:option:plain'), "accordion" => elgg_echo('profile_manager:settings:display_categories:option:accordion'));
				echo elgg_view("input/dropdown", array("name" => "params[display_categories]", "options_values" => $display_categories_options, "value" => $vars['entity']->display_categories));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:display_system_category'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[display_system_category]", "options_values" => $noyes_options, "value" => $vars['entity']->display_system_category)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:user_summary_control'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[user_summary_control]", "options_values" => $noyes_options, "value" => $vars['entity']->user_summary_control)); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class='elgg-module-inline'>
				<div class='elgg-head'>
				<h3><?php echo elgg_echo("profile_manager:settings:group"); ?></h3>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:group:group_limit_name'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[group_limit_name]", "options_values" => $group_limit_options, "value" => $vars['entity']->group_limit_name)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:group:group_limit_description'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[group_limit_description]", "options_values" => $group_limit_options, "value" => $vars['entity']->group_limit_description)); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="elgg-subtext">
			<?php echo elgg_echo("profile_manager:settings:group:limit:info"); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class='elgg-module-inline'>
				<div class='elgg-head'>
				<h3><?php echo elgg_echo("other"); ?></h3>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:enable_profile_completeness_widget'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[enable_profile_completeness_widget]", "options_values" => $noyes_options, "value" => $vars['entity']->enable_profile_completeness_widget)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:enable_username_change'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[enable_username_change]", "options_values" => $enable_username_change_options, "value" => $vars['entity']->enable_username_change)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('profile_manager:settings:enable_site_join_river_event'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[enable_site_join_river_event]", "options_values" => $yesno_options, "value" => $vars['entity']->enable_site_join_river_event)); ?>
		</td>
	</tr>
</table>
<br />