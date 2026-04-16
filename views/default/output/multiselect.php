<?php
/**
 * Output view of a multiselect
 */

if (is_string($vars['value'])) {
	$vars['value'] = elgg_string_to_array($vars['value']);
}

echo elgg_view('output/tags', $vars);
