<?php

/**
 * Elgg user display (details)
 * @uses $vars['entity'] The user entity
 */
$user = elgg_get_page_owner_entity();

$content = elgg_format_element('h2', [], $user->name);

$content .= elgg_view('profile/status', [
	'entity' => $user,
		]);

$show_profile_type_on_profile = elgg_get_plugin_setting('show_profile_type_on_profile', 'profile_manager');

$categorized_fields = profile_manager_get_categorized_fields($user, false, false, true);
$categories = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$details_result = '';

if ($show_profile_type_on_profile !== 'no') {
	if ($profile_type_guid = $user->custom_profile_type) {
		if (($profile_type = get_entity($profile_type_guid)) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
			$details_result .= elgg_format_element('div', ['class' => 'even'], '<b>' . elgg_echo('profile_manager:user_details:profile_type') . '</b>: ' . $profile_type->getTitle());
		}
	}
}

foreach ($categories as $category_guid => $category) {
	$category_title = '';
	$field_result = '';
	$i = 1;

	if (count($categories) > 1) {
		// make nice title
		$title = $category;
		if ($category_guid == -1) {
			$title = elgg_echo('profile_manager:categories:list:system');
		} elseif ($category_guid == 0) {
			$title = elgg_echo('profile_manager:categories:list:default');
		} elseif ($category instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
			$title = $category->getTitle();
		}

		$collapse_link = elgg_view('output/url', [
			'text' => ' ',
			'href' => '#',
			'class' => 'elgg-widget-collapse-button',
			'rel' => 'toggle',
		]);

		$category_title = elgg_format_element('h3', ['class' => 'elgg-head mtm'], $title);
	}

	foreach ($fields[$category_guid] as $field) {
		$field_result .= elgg_view('profile_manager/field/output', [
			'field' => $field,
			'entity' => $user,
			'class' => $i % 2 ? 'odd' : 'even',
		]);
		$i++;
	}

	if (!empty($field_result)) {
		$details_result .= $category_title;
		$details_result .= elgg_format_element('div', [], $field_result);
	}
}

if (!empty($details_result)) {
	$details_options = [
		'id' => 'custom_fields_userdetails',
		'class' => ['elgg-module', 'elgg-module-info'],
	];
	if (elgg_get_plugin_setting('display_categories', 'profile_manager') == 'accordion') {
		elgg_require_js('profile_manager/accordion');
		$details_options['class'][] = 'profile-manager-accordion';
	}
	$content .= elgg_format_element('div', $details_options, $details_result);
}

if ($user->isBanned()) {
	$content .= elgg_format_element('p', ['class' => 'profile-banned-user'], elgg_echo('banned'));
}

echo elgg_format_element('div', ['id' => 'profile-details', 'class' => 'elgg-body pll'], $content);
