<?php

if (empty($vars['placeholder'])) {
	$vars['placeholder'] = elgg_echo('profile_manager:pm_linkedin:input:placeholder');
}

echo elgg_view('input/text', $vars);