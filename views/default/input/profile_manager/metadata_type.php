<?php

$entity = elgg_extract('entity', $vars);
$field_type = elgg_extract('field_type', $vars);

$config = profile_manager_get_field_types();

if (empty($config[$field_type]['metadata_types'])) {
	return;
}

$options_values = ['' => ''];

foreach ($config[$field_type]['metadata_types'] as $metadata_type) {
	$options_values[$metadata_type->type] = $metadata_type->name;
}

if ($entity && !array_key_exists($entity->metadata_type, $options_values)) {
	$options_values[$metadata_type] = $metadata_type;
}

$vars['options_values'] = $options_values;
$vars['class'] = elgg_extract_class($vars, 'profile-manager-metadata-type-picker');
$vars['data-field-type'] = $field_type;
$vars['data-guid'] = $entity->guid;

echo elgg_view('input/select', $vars);
?>
<script>
	require(['input/profile_manager/metadata_type']);
</script>