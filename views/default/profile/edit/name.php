<?php

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('user:name:label'),
	'name' => 'name',
	'value' => $vars['entity']->name,
	'required' => true,
]);
