<?php

$user = elgg_extract('entity', $vars);
if (!$user instanceof \ElggUser) {
	return;
}

$completeness = profile_manager_profile_completeness($user);
if (empty($completeness)) {
	return;
}

if (elgg_is_xhr()) {
	echo elgg_format_element('link', ['rel' => 'stylesheet', 'href' => elgg_get_simplecache_url('profile_manager/profile_completeness.css')]);
} else {
	elgg_require_css('profile_manager/profile_completeness.css');
}

$percentage_complete = elgg_extract('percentage_completeness', $completeness);

$progress = elgg_format_element('div', [
	'id' => 'widget_profile_completeness_progress',
], "{$percentage_complete}%");

$progress .= elgg_format_element('div', [
	'id' => 'widget_profile_completeness_progress_bar',
	'style' => "width: {$percentage_complete}%;",
]);

echo elgg_format_element('div', [
	'id' => 'widget_profile_completeness_container',
], $progress);

if ($user->guid !== elgg_get_logged_in_user_guid()) {
	return;
}

$missing_fields = elgg_extract('missing_fields', $completeness);

if (count($missing_fields) > 0) {
	$rand_key = array_rand($missing_fields);
	$field = $missing_fields[$rand_key];

	$tips = elgg_echo('widgets:profile_completeness:view:tips', [
		elgg_view_url(elgg_generate_url('edit:user', ['username' => $user->username]), $field->getDisplayName())
	]);
} elseif (elgg_extract('avatar_missing', $completeness, false)) {
	$tips = elgg_echo('widgets:profile_completeness:view:tips', [
		elgg_view_url(elgg_generate_url('edit:user:avatar', ['username' => $user->username]), elgg_echo('avatar'))
	]);
} else {
	$tips = elgg_echo('widgets:profile_completeness:view:complete');
}

echo elgg_format_element('div', ['class' => 'mtm'], $tips);
