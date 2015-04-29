<?php

if (empty($vars['placeholder'])) {
	$vars['placeholder'] = elgg_echo('profile_manager:pm_facebook:input:placeholder');
}

echo elgg_view('input/url', $vars);