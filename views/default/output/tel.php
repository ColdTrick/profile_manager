<?php

$value = elgg_extract('value', $vars);

echo elgg_format_element('a', [
	'href' => "tel:{$value}",
], $value);
