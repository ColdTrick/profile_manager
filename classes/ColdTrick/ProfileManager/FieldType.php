<?php

namespace ColdTrick\ProfileManager;

/**
 * FieldType
 */
class FieldType {
		
	/**
	 * Creates a new field type
	 *
	 * @param array $options The array of options for the field type
	 *
	 * @return void
	 */
	public static function factory(array $options) {
		$type = elgg_extract('type', $options);
		$name = elgg_extract('name', $options);
		if (empty($name) && elgg_language_key_exists("profile:field:{$type}")) {
			$name = elgg_echo("profile:field:{$type}");
		}
		
		$config = new self();
		
		$config->type = $type;
		$config->name = $name;
		$config->options = array_merge(['show_on_profile' => true], elgg_extract('options', $options));
		
		return $config;
	}
}
