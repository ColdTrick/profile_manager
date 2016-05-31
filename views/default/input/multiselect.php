<?php
/**
* Profile Manager
*
* Multiselect
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'profile-manager-multiselect';

$vars['name'] .= '[]';
$vars['multiple'] = true;

$value = elgg_extract('value', $vars, []);
if (!is_array($value)) {
	$value = string_to_tag_array($value);
}
$vars['value'] = $value;

echo elgg_format_element('div', [], elgg_view('input/select', $vars));
echo elgg_format_element('script', [], 'require(["jquery.multiselect", "profile_manager/multiselect"], function() { elgg.multiselect.init(); });');
