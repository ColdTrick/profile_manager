<?php

echo elgg_view_field([
	'#type' => 'text',
	'name' => 'name',
	'value' => $vars['entity']->name,
	'#label' => elgg_echo('user:name:label'),
	'maxlength' => 50, // hard coded in /actions/profile/edit
]);
