<?php

use ColdTrick\ProfileManager\CustomProfileType;
use ColdTrick\ProfileManager\DefaultProfileType;

$entity = elgg_extract('entity', $vars);
$current_profile_type = (int) $entity->custom_profile_type;

$setting = elgg_get_plugin_setting('profile_type_selection', 'profile_manager', 'user');
$can_change = $setting == 'user' || elgg_is_admin_logged_in();

if (!$can_change) {
	return;
}

$profile_types = elgg_get_entities([
	'type' => 'object',
	'subtype' => CustomProfileType::SUBTYPE,
	'limit' => false,
	'owner_guid' => elgg_get_site_entity()->guid,
		]);

if (!$profile_types) {
	return;
}

$default_profile_type = new DefaultProfileType();
$profile_type_options = [
	0 => $default_profile_type->getTitle(),
];
foreach ($profile_types as $profile_type) {
	$profile_type_options[$profile_type->guid] = $profile_type->getTitle();
}

if (elgg_get_plugin_setting('hide_profile_type_default', 'profile_manager') == 'yes') {
	// only unset if the current type exists in the options, otherwise keep default intact
	if (array_key_exists($current_profile_type, $profile_type_options)) {
		unset($profile_type_options['']);
	}
}

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('profile_manager:profile:edit:custom_profile_type:label'),
	'options_values' => $profile_type_options,
	'value' => $current_profile_type,
	'class' => 'profile-manager-profile-type-picker',
	'data-guid' => $entity->guid,
]);
?>
<script>
	require(['profile/edit/profile_type']);
</script>