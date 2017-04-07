<?php
/**
* Profile Manager
*
* Replaces default Elgg profile edit form
*
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*
* @uses $user The user entity
*/

$user = elgg_extract('entity', $vars);

elgg_require_js('forms/profile/edit');

echo elgg_view('profile/edit/name', $vars);

echo elgg_view('profile/edit/profile_type', $vars);

$fields = elgg_view('profile/edit/fields', $vars);
echo elgg_format_element('div', [
	'class' => 'profile-manager-edit-profile-fields',
], $fields);

echo elgg_view_field([
	'#type' => 'hidden',	
	'name' => 'guid', 
	'value' => $user->guid,
]);

$footer = elgg_view('input/submit', ['value' => elgg_echo('save')]);
elgg_set_form_footer($footer);
