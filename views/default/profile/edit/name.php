<?php

$content = elgg_format_element('label', [], elgg_echo('user:name:label'));
$content .= elgg_view('input/text', ['name' => 'name', 'value' => $vars['entity']->name]);

echo elgg_format_element('div', [], $content);
