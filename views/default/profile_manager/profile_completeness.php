<?php

$user = elgg_extract('entity', $vars);
if (!$user instanceof \ElggUser) {
	return;
}

$completeness = profile_manager_profile_completeness($user);
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

if ($user->getGUID() !== elgg_get_logged_in_user_guid()) {
	return;
}

$missing_fields = elgg_extract('missing_fields', $completeness);

if (count($missing_fields) > 0) {
	$rand_key = array_rand($missing_fields);
	$field = $missing_fields[$rand_key];
	$url = elgg_view('output/url', [
		'href' => elgg_generate_url('edit:user', ['username' => $user->username]),
		'text' => $field->getDisplayName(),
	]);
	$tips = elgg_echo('widgets:profile_completeness:view:tips', [$url]);
} elseif (elgg_extract('avatar_missing', $completeness, false)) {
	$url = elgg_view('output/url', [
		'href' => elgg_generate_url('edit:user:avatar', ['username' => $user->username]),
		'text' => elgg_echo('avatar'),
	]);
	$tips = elgg_echo('widgets:profile_completeness:view:tips', [$url]);
} else {
	$tips = elgg_echo('widgets:profile_completeness:view:complete');
}

echo elgg_format_element('div', ['class' => 'mtm'], $tips);
