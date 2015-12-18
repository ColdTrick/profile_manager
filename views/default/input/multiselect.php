<?php
/**
* Profile Manager
*
* Multiselect
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

global $multiselect;

if (empty($multiselect)) {
	$multiselect = 1;
} else {
	$multiselect++;
}

$selected_items = elgg_extract('value', $vars, '');
$options_values = elgg_extract('options_values', $vars);
$options = elgg_extract('options', $vars);

if (!is_array($selected_items)) {
	$selected_items = string_to_tag_array($selected_items);
}

$selected_items = array_map('strtolower', $selected_items);

if (elgg_is_xhr()) {
	// register form for walled garden could load via ajax, so we need to load library manually
	echo elgg_format_element('script', ['src' => elgg_normalize_url('mod/profile_manager/vendors/jquery_ui_multiselect/jquery.multiselect.js')]);
} else {
	elgg_load_js('jquery.ui.multiselect');
}

$select_options = '';
if (!empty($options_values)) {
	foreach ($options_values as $value => $option) {

		$encoded_value = htmlentities($value, ENT_QUOTES, 'UTF-8');
		$encoded_option = htmlentities($option, ENT_QUOTES, 'UTF-8');

		$select_options .= elgg_format_element('option', [
			'value' => $encoded_value,
			'selected' => in_array(strtolower($value), $selected_items),
		], $encoded_option);
	}
} elseif (!empty($options)) {
	foreach ($options as $option) {
		$encoded_option = htmlentities($option, ENT_QUOTES, 'UTF-8');

		$select_options .= elgg_format_element('option', [
			'value' => $encoded_option,
			'selected' => in_array(strtolower($encoded_option), $selected_items),
		], $encoded_option);
	}
}

$hidden = elgg_view('input/hidden', ['name' => elgg_extract('name', $vars) . '[]']);
$select = elgg_format_element('select', [
	'class' => 'profile-manager-multiselect',
	'name' => elgg_extract('name', $vars) . '[]',
	'multiple' => true,
], $select_options);
echo elgg_format_element('div', [], $hidden . $select);

echo elgg_format_element('script', [], 'require(["profile_manager/multiselect"]);');
