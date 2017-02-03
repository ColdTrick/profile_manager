<?php
/**
 * Elgg add user form.
 *
 * @package Elgg
 * @subpackage Core
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */

$name = $username = $email = $password = $password2 = $admin = '';

if (elgg_is_sticky_form('useradd')) {
	$values = elgg_get_sticky_values('useradd');
	extract($values);
	elgg_clear_sticky_form('useradd');
	if (is_array($admin)) {
		$admin = $admin[0];
	}
}

$admin_option = false;
if ((elgg_get_logged_in_user_entity()->isAdmin()) && ($vars['show_admin'])) {
	$admin_option = true;
}
?>
<div>
	<label><?php echo elgg_echo('name');?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'name',
		'value' => $name,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('username'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'username',
		'value' => $username,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('email'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'email',
		'value' => $email,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password',
		'value' => $password,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('passwordagain'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password2',
		'value' => $password2,
	));
	?>
</div>

<?php
if ($admin_option) {
	echo "<div>";
	echo elgg_view('input/checkboxes', array(
		'name' => "admin",
		'options' => array(elgg_echo('admin_option') => 1),
		'value' => $admin,
	));
	echo "</div>";
	
	echo "<div>" . elgg_view('input/checkboxes', array('name' => "notify", 'options' => array(elgg_echo('profile_manager:admin:adduser:notify') => 1))) . "</div>";
	echo "<div>" . elgg_view('input/checkboxes', array('name' => "use_default_access", 'value' => elgg_echo('profile_manager:admin:adduser:use_default_access'), 'options' => array(elgg_echo('profile_manager:admin:adduser:use_default_access') => 1))) . "</div>";
	
	// get profile types
	$types = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_site_entity()->getGUID(),
	]);
	
	$categorized_fields = profile_manager_get_categorized_fields(null, true);
	$cats = $categorized_fields['categories'];
	$fields = $categorized_fields['fields'];
	
	if ($types || !empty($fields[0])) {
		echo "<a href='javascript:void(0);' onclick='$(\"#extra_metadata\").show(); $(this).hide();'>" . elgg_echo("profile_manager:admin:adduser:extra_metadata") . "</a>";
		echo "<div id='extra_metadata' class='hidden'>";
	}
	
	if ($types) {
		
		$options = [
			'' => elgg_echo('profile_manager:profile:edit:custom_profile_type:default'),
		];
		
		foreach ($types as $type) {
			$options[$type->guid] = $type->getTitle();
		}
		
		echo elgg_view_field([
			'#type' => 'select',
			'#label' => elgg_echo('profile_manager:profile:edit:custom_profile_type:label'),
			'name' => 'custom_profile_fields[custom_profile_type]', 
			'options_values' => $options,
		]);
		
	}
	
	if (!empty($cats)) {
		foreach ($cats as $cat_guid => $cat) {
			// display each field for currect category
			foreach ($fields[$cat_guid] as $field) {
				echo elgg_view_field([
					'#type' => $field->metadata_type,
					'#label' => $field->getTitle(),
					'name' => "custom_profile_fields[{$field->metadata_name}]",
					'options' => $field->getOptions(true),
				]);
			}
		}
	}
	
	if ($types || !empty($fields[0])) {
		echo "</div>";
	}
}

$footer = elgg_view('input/submit', ['value' => elgg_echo('register')]);
elgg_set_form_footer($footer);
