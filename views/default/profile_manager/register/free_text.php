<?php

$free_text = elgg_get_plugin_setting('registration_free_text', 'profile_manager');
if (empty($free_text)) {
	return;
}

echo elgg_view('output/longtext', [
	'value' => $free_text,
	'id' => 'registration-free-text',
]);
