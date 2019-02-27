<?php

/**
 * Elgg add user form.
 *
 * @package Elgg
 * @subpackage Core
 *
 */
elgg_require_js('forms/useradd');

if (elgg_is_sticky_form('useradd')) {
	$values = elgg_get_sticky_values('useradd');
	elgg_clear_sticky_form('useradd');
} else {
	$values = array();
}

$password = $password2 = '';
$name = elgg_extract('name', $values);
$username = elgg_extract('username', $values);
$email = elgg_extract('email', $values);
$admin = elgg_extract('admin', $values);
$autogen_password = elgg_extract('autogen_password', $values);

$admin_option = false;
if (elgg_is_admin_logged_in() && elgg_extract('show_admin', $vars)) {
	$admin_option = true;
}

echo elgg_view_field([
	'#type' => 'text',
	'name' => 'name',
	'value' => $name,
	'#label' => elgg_echo('name'),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'text',
	'name' => 'username',
	'value' => $username,
	'#label' => elgg_echo('username'),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'email',
	'name' => 'email',
	'value' => $email,
	'#label' => elgg_echo('email'),
	'required' => true,
]);

echo elgg_view_field(array(
	'#type' => 'checkbox',
	'name' => 'autogen_password',
	'value' => 1,
	'default' => false,
	'label' => elgg_echo('autogen_password_option'),
	'checked' => (bool) $autogen_password,
));

echo elgg_view_field([
	'#type' => 'password',
	'name' => 'password',
	'value' => $password,
	'#label' => elgg_echo('password'),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'password',
	'name' => 'password2',
	'value' => $password2,
	'#label' => elgg_echo('passwordagain'),
	'required' => true,
]);

if ($admin_option) {
	echo elgg_view_field(array(
		'#type' => 'checkbox',
		'name' => 'admin',
		'value' => 1,
		'default' => false,
		'label' => elgg_echo('admin_option'),
		'checked' => $admin,
	));
	
	echo elgg_view_field(array(
		'#type' => 'checkbox',
		'name' => 'notify',
		'value' => 1,
		'label' => elgg_echo('profile_manager:admin:adduser:notify'),
	));
	
	echo elgg_view_field(array(
		'#type' => 'checkbox',
		'name' => 'use_default_access',
		'value' => 1,
		'label' => elgg_echo('profile_manager:admin:adduser:use_default_access'),
	));
	
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

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('register'),
	'#class' => 'elgg-foot',
]);
elgg_set_form_footer($footer);
