<?php

$accept_terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
if (empty($accept_terms)) {
	return;
}

$link_begin = "<a target='_blank' href='{$accept_terms}'>";
$link_end = '</a>';

$label = elgg_format_element('label', ['for' => 'register-accept_terms'], elgg_echo('profile_manager:registration:accept_terms', [$link_begin, $link_end]));

$checkbox = elgg_view('input/checkbox', [
	'id' => 'register-accept_terms',
	'name' => 'accept_terms',
	'value' => 'yes',
	'default' => false
]);

echo elgg_format_element('div', ['class' => 'mandatory mbm'], $checkbox . $label);
