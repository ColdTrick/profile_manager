<?php
/**
* Profile Manager
*
* Register profile icon input field
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$profile_icon = elgg_get_plugin_setting('profile_icon_on_register', 'profile_manager');

$div_options = [];
if ($profile_icon == 'yes') {
	$div_options['class'] = 'mandatory';
}

$content = elgg_format_element('label', ['for' => 'register-profile_icon'], elgg_echo('profile_manager:register:profile_icon'));
$content .= '<br />';
$content .= elgg_view('input/file', ['name' => 'profile_icon', 'id' => 'register-profile_icon']);

echo elgg_format_element('div', $div_options, $content);
