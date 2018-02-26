<?php
/**
* Profile Manager
*
* Extended registerpage view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$fields = [];

$profile_icon = elgg_get_plugin_setting('profile_icon_on_register', 'profile_manager');
if ($profile_icon == 'yes' || $profile_icon == 'optional') {
	$fields[] = [
		'#type' => 'file',
		'#label' => elgg_echo('profile_manager:register:profile_icon'),
		'name' => 'profile_icon',
		'required' => ($profile_icon == 'yes'),
	];
}

$categorized_fields = profile_manager_get_categorized_fields(null, true, true);

$profile_fields = elgg_extract('fields', $categorized_fields);
$cats = elgg_extract('categories', $categorized_fields);

$tabbed = (bool) (elgg_get_plugin_setting('edit_profile_mode', 'profile_manager') == 'tabbed');
if (count($cats) < 2) {
	$tabbed = false;
}

if (elgg_is_sticky_form('profile_manager_register')) {
	$sticky_values = elgg_get_sticky_values('profile_manager_register');
	extract($sticky_values);
	elgg_clear_sticky_form('profile_manager_register');
}

$custom_profile_fields_custom_profile_type = elgg_get_plugin_setting('default_profile_type', 'profile_manager');

if (elgg_get_plugin_setting('profile_type_selection', 'profile_manager') !== 'admin') {
	$profile_types = elgg_view('profile_manager/register/profile_type_selection', [
		'value' => $custom_profile_fields_custom_profile_type,
	]);
	if (!empty($profile_types)) {
		$fields[] = ['#html' => $profile_types];
	}
} else {
	$fields[] = [
		'#type' => 'hidden',
		'name' => 'custom_profile_fields_custom_profile_type',
		'value' => $custom_profile_fields_custom_profile_type,
	];
}

if (!empty($profile_fields)) {
	foreach ($cats as $cat_guid => $cat) {
		
		$linked_profile_types = [0];
		if ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
			$linked_profile_types = $cat->getLinkedProfileTypes();
		}
		
		$category_fields = [];
		foreach ($profile_fields[$cat_guid] as $field) {
			$metadata_type = $field->metadata_type;
						
			$field_name = "custom_profile_fields_{$field->metadata_name}";
			
			$value = '';
			if (isset($$field_name)) {
				$value = $$field_name;
			}
			
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			
			$category_fields[] = [
				'#type' => $metadata_type,
				'#label' => $field->getDisplayName(true),
				'#help' => $field->getHint(),
				'name' => $field_name,
				'value' => $value,
				'required' => ($field->mandatory == 'yes'),
				'options' => $field->getOptions(),
				'placeholder' => $field->getPlaceholder(),
			];
		}
		
		$category_classes = ["custom_profile_type_{$cat_guid}"];
		
		if (($linked_profile_types[0] !== 0) && !in_array($custom_profile_fields_custom_profile_type, $linked_profile_types)) {
			$category_classes[] = 'hidden';
		}
		
		foreach ($linked_profile_types as $type_guid) {
			$category_classes[] = "custom_profile_type_{$type_guid}";
		}
				
		$category_classes[] = 'custom_fields_edit_profile_category';
		
		$cat_title = empty($cat_guid) ? elgg_echo('profile_manager:categories:list:default') : $cat->getDisplayName();
		
		$cat_body = elgg_view_field([
			'#type' => 'fieldset',
			'#class' => $category_classes,
			'fields' => $category_fields,
		]);
		
		if ($tabbed) {
			$tabs[] = [
				'text' => $cat_title,
				'content' => $cat_body,
				'class' => $category_classes,
			];
		} else {
			$fields[] = [
				'#html' => elgg_view_module('inline', $cat_title, $cat_body, ['class' => $category_classes]),
			];
		}
	}
}

if (!empty($tabs)) {
	$fields[] = [
		'#html' => elgg_view('page/components/tabs', ['tabs' => $tabs]),
	];
}

if (empty($fields)) {
	return;
}

echo elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'register-form-fields',
	'fields' => $fields,
]);
