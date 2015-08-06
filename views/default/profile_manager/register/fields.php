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

$field_location = $vars['field_location'];
$field_location_setting = elgg_get_plugin_setting('registration_extra_fields', 'profile_manager');
if ($field_location == 'beside') {
	if ($field_location_setting !== 'beside') {
		// beside should be beside
		return true;
	}
} elseif ($field_location_setting == 'beside') {
	// below or default
	return true;
}

$tabbed = false;
if (elgg_get_plugin_setting('edit_profile_mode', 'profile_manager') == 'tabbed') {
	$tabbed = true;
}

$result = '';

// profile icon
$profile_icon = elgg_get_plugin_setting('profile_icon_on_register', 'profile_manager');
if ($profile_icon == 'yes' || $profile_icon == 'optional') {
	$result .= elgg_view('input/profile_icon');
}

$categorized_fields = profile_manager_get_categorized_fields(null, true, true);
$fields = $categorized_fields['fields'];
$cats = $categorized_fields['categories'];

if (elgg_is_sticky_form('profile_manager_register')) {
	$sticky_values = elgg_get_sticky_values('profile_manager_register');
	extract($sticky_values);
	elgg_clear_sticky_form('profile_manager_register');
}
	
if (empty($custom_profile_fields_custom_profile_type)) {
	$custom_profile_fields_custom_profile_type = elgg_get_plugin_setting('default_profile_type', 'profile_manager');
}

if (elgg_get_plugin_setting('profile_type_selection', 'profile_manager') !== 'admin') {
	$result .= elgg_view('profile_manager/register/profile_type_selection', ['value' => $custom_profile_fields_custom_profile_type]);
} else {
	$result .= elgg_view('input/hidden', ['name' => 'custom_profile_fields_custom_profile_type', 'value' => $custom_profile_fields_custom_profile_type]);
}

if (!empty($fields)) {
	$tabbed_cat_titles = '';
	$tabbed_cat_content = '';
	$tab_selected = false;
	foreach ($cats as $cat_guid => $cat) {
		
		$linked_profile_types = array(0);
		if ($cat instanceof ProfileManagerCustomFieldCategory) {
			$linked_profile_types = $cat->getLinkedProfileTypes();
		}
		
		$fields_result = '';
		foreach ($fields[$cat_guid] as $field) {
			$metadata_type = $field->metadata_type;
			if ($metadata_type == 'longtext') {
				// bug when showing tinymce on register page (when moving) newer versions of tinymce are working correctly
				$metadata_type = 'plaintext';
			}
			
			$field_name = "custom_profile_fields_{$field->metadata_name}";
			
			$value = '';
			if (isset($$field_name)) {
				$value = $$field_name;
			}
			
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			$field_class = [];
			if ($field->mandatory == 'yes') {
				$field_class[] = 'mandatory';
			}
			
			$field_result = elgg_format_element('label', [], $field->getTitle());
			
			$hint = $field->getHint();
			if ($hint) {
				$field_result .= elgg_format_element('span', ['class' => 'custom_fields_more_info', 'id' => "more_info_{$field->metadata_name}"]);
				$field_result .= elgg_format_element('span', ['class' => 'hidden', 'id' => "text_more_info_{$field->metadata_name}"], $hint);
			}
			
			$field_result .= '<br />';
			
			$field_result .= elgg_view("input/{$metadata_type}", [
				'name' => $field_name,
				'value' => $value,
				'options' => $field->getOptions(),
				'placeholder' => $field->getPlaceholder()
			]);
			$fields_result .= elgg_format_element('div', ['class' => $field_class], $field_result);
		}
		
		$category_classes = ["category_{$cat_guid}"];
		
		if (($linked_profile_types[0] !== 0) && !in_array($custom_profile_fields_custom_profile_type, $linked_profile_types)) {
			$category_classes[] = 'hidden';
		}
		
		foreach ($linked_profile_types as $type_guid) {
			$category_classes[] = "profile_type_{$type_guid}";
		}
		
		$cat_header = '';
		if (count($cats) > 1) {
			// make nice title
			if ($cat_guid == 0) {
				$title = elgg_echo("profile_manager:categories:list:default");
			} else {
				$title = $cat->getTitle();
			}
			
			if ($tabbed) {
				$tab_link = elgg_format_element('a', ['href' => 'javascript:void(0);', 'onclick' => "elgg.profile_manager.toggle_tabbed_nav('{$cat_guid}', this);"], $title);
				
				$li_classes = $category_classes;
				if (!$tab_selected && !in_array('hidden', $category_classes)) {
					$li_classes[] = 'elgg-state-selected';
					$tab_selected = true;
				}
				$tabbed_cat_titles .= elgg_format_element('li', ['class' => $li_classes], $tab_link);
			} else {
				$cat_header = elgg_format_element('div', ['class' => 'elgg-head'], "<h3>{$title}</h3>");
			}
		}
		
		$cat_body = elgg_format_element('div', ['class' => 'elgg-body'], "<fieldset>{$fields_result}</fieldset>");
		
		$category_classes[] = 'profile_manager_register_category';
		$category_classes[] = 'elgg-module';
		$category_classes[] = 'elgg-module-info';
		
		$cat_result = elgg_format_element('div', ['class' => $category_classes], $cat_header . $cat_body);
		
		if ($tabbed) {
			$tabbed_cat_content .= $cat_result;
		} else {
			$result .= $cat_result;
		}
	}
	
	if ($tabbed) {
		if ($tabbed_cat_titles) {
			
			$result .= elgg_format_element('ul', ['class' => 'elgg-tabs elgg-htabs', 'id' => 'profile_manager_register_tabbed'], $tabbed_cat_titles);
			$result .= elgg_format_element('div', [], $tabbed_cat_content);
		} else {
			$result .= $tabbed_cat_content;
		}
	}
}

if (!empty($result)) {
	echo elgg_format_element('fieldset', [], $result);
}
