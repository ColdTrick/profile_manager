<?php

$free_text = elgg_get_plugin_setting('registration_free_text', 'profile_manager');
if ($free_text) {
	echo elgg_view('output/longtext', ['value' => $free_text]);
}