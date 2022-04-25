<?php
$id = elgg_extract('id', $vars);

echo elgg_view_icon('info-circle', [
	'id' => $id,
	'class' => 'custom_fields_more_info mls',
]);

echo elgg_format_element('div', [
	'class' => 'hidden',
	'id' => "text_{$id}",
], elgg_extract('text', $vars));

elgg_require_js('profile_manager/tooltips');
elgg_require_css('output/pm_hint');
