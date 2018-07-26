<?php
/**
 * @uses $vars['entity']       The user entity
 * @uses $vars['microformats'] Mapping of fieldnames to microformats
 * @uses $vars['fields']       Array of profile fields to show
 */

$user = elgg_extract('entity', $vars);
if (!($user instanceof ElggUser)) {
	return;
}

$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = elgg_extract('categories', $categorized_fields);
$fields = elgg_extract('fields', $categorized_fields);

if (count($cats) < 1) {
	return;
}

$output = '';

$show_profile_type_on_profile = elgg_get_plugin_setting('show_profile_type_on_profile', 'profile_manager');
$show_as_tabs = (bool) (elgg_get_plugin_setting('display_categories', 'profile_manager') == 'tabs');

if ($show_profile_type_on_profile !== 'no') {
	if ($profile_type_guid = $user->custom_profile_type) {
		if (($profile_type = get_entity($profile_type_guid)) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
			$output .= elgg_format_element('div', ['class' => 'even'], '<b>' . elgg_echo('profile_manager:user_details:profile_type') . '</b>: ' . $profile_type->getDisplayName());
		}
	}
}

// only show category headers if more than 1 category available
$show_header = (bool) (count($cats) > 1);

$tabs = [];
foreach ($cats as $cat_guid => $cat) {

	$cat_data = elgg_view('profile/fields/category', [
		'entity' => $user,
		'category' => $cat,
		'category_guid' => $cat_guid,
		'fields' => $fields[$cat_guid],
		'microformats' => elgg_extract('microformats', $vars, []),
	]);
	
	if (empty($cat_data)) {
		continue;
	}
	
	if (!$show_header) {
		$output .= $cat_data;
		continue;
	}
	
	$cat_title = $cat;
	if ($cat_guid == -1) {
		$cat_title = elgg_echo('profile_manager:categories:list:system');
	} elseif ($cat_guid == 0) {
		if (empty($cat)) {
			$cat_title = elgg_echo('profile_manager:categories:list:default');
		}
	} elseif ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
		$cat_title = $cat->getDisplayName();
	}
	
	if ($show_as_tabs) {
		$tabs[] = [
			'text' => $cat_title,
			'content' => $cat_data,
		];
	} else {
		$output .= elgg_view_module('info', $cat_title, $cat_data);
	}
}

if (!empty($tabs)) {
	// make the first tab selected
	$tabs[0]['selected'] = true;
	$output .= elgg_view('page/components/tabs', [
		'tabs' => $tabs,
	]);
}

if (empty($output)) {
	return;
}

echo elgg_format_element('div', ['class' => 'elgg-profile-fields'], $output);
