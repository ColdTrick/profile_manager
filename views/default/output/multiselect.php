<?php
/**
 * Profile Manager
 *
 * Output view of a multiselect
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

if (is_string($vars['value'])) {
	$vars['value'] = elgg_string_to_array($vars['value']);
}

echo elgg_view('output/tags', $vars);
